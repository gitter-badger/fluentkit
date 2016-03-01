<?php
namespace App\Tests;

use App\Models\User;

class ForgotPasswordTest extends \TestCase
{
    /**
     * A basic email invalid test on forgot password.
     *
     * @return void
     */
    public function testInvalidForgotEmail()
    {
        $this->json('post', '/forgot-password', [
            'email' => 'invalidemail'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A basic email doesnt exist forgot password test.
     *
     * @return void
     */
    public function testValidEmailDoesntExists()
    {
        $this->json('post', '/forgot-password', [
            'email' => 'doesnt@exists.com'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A basic valid reset request.
     *
     * @return void
     */
    public function testValidResetRequest()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->save();

        $this->json('post', '/forgot-password', [
            'email' => 'valid@email.com'
        ])->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(200);
    }

    /**
     * A valid password reset test.
     *
     * @return void
     */
    public function testValidReset()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->save();

        \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'testing123',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->json('post', '/reset-password', [
            'token' => 'testing123',
            'email' => 'valid@email.com',
            'password' => 'anewpassword',
            'password_confirmation' => 'anewpassword'
        ])->seeJson([
            'status' => 'success'
        ])->assertResponseStatus(206);
    }

    /**
     * A invalid password reset test via token.
     *
     * @return void
     */
    public function testInvalidTokenReset()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'testing123',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->json('post', '/reset-password', [
            'token' => 'testing',
            'email' => 'valid@email.com',
            'password' => 'anewpassword',
            'password_confirmation' => 'anewpassword'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A invalid password reset test via password.
     *
     * @return void
     */
    public function testInvalidPasswordReset()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        \DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'testing123',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->json('post', '/reset-password', [
            'token' => 'testing',
            'email' => 'valid@email.com',
            'password' => 'anewpassword',
            'password_confirmation' => 'anewpasswordinvalid'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

}
