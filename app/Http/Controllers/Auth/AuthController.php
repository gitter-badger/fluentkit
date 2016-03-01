<?php

namespace App\Http\Controllers\Auth;

use App\Models\Provider;
use App\Repositories\Provider\ProviderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $throttle;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(RateLimiter $throttle)
    {
        $this->throttle = $throttle;

        $this->middleware('guest', ['except' => 'getLogout']);

        $this->middleware('config:user.allow_registration', ['only' => ['getRegister', 'postRegister']]);
    }


    public function getLogin($provider = null){

        if(null !== $provider){
            return Socialite::driver($provider)->redirect();
        }

        return view('auth.login')->with('page_title', trans('auth.login_title'));
    }

    public function getLoginCallback($provider = null, ProviderRepositoryInterface $repo, UserRepositoryInterface $userRepo){

        $user = null;

        $data = Socialite::driver($provider)->user();

        if(null === $data->getEmail()){
            throw new \Exception("Whoops, looks like the provider doesn't want to give us the email address, Twitter by any chance? We really need it so you need to request higher permissions.");
        }

        $providerFound = $repo->where('provider_id', $data->getId())->where('provider', $provider)->first();
        if($providerFound){
            $user = $userRepo->find($providerFound->user_id);
        }

        if(!$user){
            $user = $userRepo->where('email', $data->getEmail())->first();
        }

        if(!$user){
            $name = explode(' ', $data->getName(), 2);
            $user = $userRepo->create([
                'first_name' => $name[0],
                'last_name' => $name[1],
                'email' => $data->getEmail(),
                'password' => bcrypt(md5($data->getEmail() . time()))
            ]);
        }

        if(!$providerFound){
            $userProvider = new Provider([
                'provider' => $provider,
                'provider_id' => $data->getId(),
                'provider_data' => (array) $data,
            ]);
            $user->providers()->save($userProvider);
        }

        Auth::login($user);
        Session::set('logged_in_via', $provider);

        return redirect()->to('/dashboard');
    }


    public function postLogin(Request $request, UserRepositoryInterface $repo){

        //validate
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => trans('auth.invalid_email')
        ]);

        //throttle
        if ($this->hasTooManyLoginAttempts($request)) {
            $seconds = $this->throttle->availableIn(
                $request->input('email').$request->ip()
            );

            return response()->json([
                'status' => 'failed',
                'errors' => [
                    'email' => [trans('auth.throttle', ['seconds' => $seconds])]
                ]
            ])->setStatusCode(422);
        }

        //try login
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            $this->clearLoginAttempts($request);
            $user = Auth::user();
            return response()->json([
                'status' => 'success',
                'location' => $request->session()->pull('url.intended', '/'),
                'user' => $user,
                'message' => 'Welcome back ' . $user->first_name
            ]);
        }

        //increment failed login
        $this->incrementLoginAttempts($request);

        return response()->json([
            'status' => 'failed',
            'errors' => [
                'email' => [trans('auth.invalid_email')]
            ]
        ])->setStatusCode(422);

    }

    public function getLogout(){

        Auth::logout();
        Session::forget('logged_in_via');
        Session::forget('url.intended');
        return redirect('/login')->with('logged_out', true);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register')->with('page_title', trans('auth.register_title'));
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, UserRepositoryInterface $repo)
    {
        //validate
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        //create
        $user = $repo->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        //login
        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'location' => $request->session()->pull('url.intended', '/'),
            'user' => $user,
            'message' => 'Registration Successful, welcome ' . $user->first_name
        ])->setStatusCode(201);
    }

    public function getForgotPassword(){
        return view('auth.forgot_password')->with('page_title', trans('auth.forgot_password_title'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postForgotPassword(Request $request, UserRepositoryInterface $repo)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => trans('auth.invalid_email')
        ]);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Your Password Reset Link');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                $user = $repo->where('email', $request->get('email'))->first();
                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'message' => 'Password Reset email sent to ' . $request->get('email')
                ])->setStatusCode(200);
                break;
            case Password::INVALID_USER:
                return response()->json([
                    'status' => 'failed',
                    'errors' => [
                        'email' => trans($response)
                    ]
                ])->setStatusCode(404);
                break;
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function getResetPassword($token = null)
    {
        if (is_null($token)) {
            return $this->getForgotPassword();
        }

        return view('auth.reset_password')->with('token', $token)->with('page_title', trans('auth.reset_password_title'));
    }

    public function postResetPassword(Request $request, UserRepositoryInterface $repo){

        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'email.exists' => trans('auth.invalid_email')
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {

            $user->password = bcrypt($password);

            $user->save();

            Auth::login($user);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                $user = $repo->where('email', $request->get('email'))->first();
                return response()->json([
                    'status' => 'success',
                    'location' => $request->session()->pull('url.intended', '/'),
                    'user' => $user,
                    'message' => 'Password Reset Successful for ' . $request->get('email') . '. Please wait while we log you in.',
                ])->setStatusCode(206);
                break;
            default:
                return response()->json([
                    'status' => 'failed',
                    'errors' => [
                        'email' => trans($response)
                    ]
                ])->setStatusCode(422);
                break;
        }
    }




    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->throttle->tooManyAttempts(
            $request->input('email').$request->ip(),
            config('auth.login_attempts'), config('auth.lockout_time') / 60
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->throttle->hit(
            $request->input('email').$request->ip()
        );
    }

    /**
     * Determine how many retries are left for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    protected function retriesLeft(Request $request)
    {
        $attempts = $this->throttle->attempts(
            $request->input('email').$request->ip()
        );

        return config('auth.login_attempts') - $attempts + 1;
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->throttle->clear(
            $request->input('email').$request->ip()
        );
    }
}
