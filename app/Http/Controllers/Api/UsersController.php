<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 21:55
 */

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $allowedWheres = [
        'name',
        'email',
    ];

    protected $allowedIncludes = [
        'roles',
    ];

    protected $repo;

    public function __construct(UserRepositoryInterface $repo){

        $this->repo = $repo;

        parent::__construct();

        $this->middleware('can:view.users', ['only' => ['getIndex', 'getShow']]);
        $this->middleware('can:create.users', ['only' => 'postCreate']);
        $this->middleware('can:update.users', ['only' => ['patchUpdate', 'patchRolesUpdate', 'putRolesUpdate', 'deleteRolesDestroy', 'deleteRolesDestroyAll']]);
        $this->middleware('can:delete.users', ['only' => 'deleteDestroy']);
    }

    public function getIndex(Request $request){

        $includes = $this->getIncludes($request);
        $where = $this->getWhereQuery($request);
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'asc');
        $per_page = $this->getPerPage($request);

        return $this->repo->with($includes)
            ->where($where)
            ->orderBy($sort, $order)
            ->paginate($per_page)
            ->appends($request->query());
    }

    public function postCreate(Request $request){

        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:6|max:255'
        ]);

        //fetch all roles requested, if all dont exist bail as we cant create relationships here
        $roles = Role::whereIn('name', $request->get('roles', []))->get();
        if($roles->count() != count($request->get('roles', []))){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_create_failed', ['resource' => trans('global.user')]),
                'errors' => [
                    'roles' => [
                        trans('api.resource_create_failed_relationship', ['relationship' => trans('global.role')])
                    ]
                ]
            ]);
        }

        $request->merge(['password' => bcrypt($request->get('password'))]);


        //new up a role and assign permissions
        $user = $this->repo->create($request->only(['first_name', 'last_name', 'email', 'password']));

        foreach($roles as $role){
            $user->assignRole($role);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => trans('api.resource_created', ['resource' => trans('global.user')]),
        ])->setStatusCode(201);

    }


    public function getShow(Request $request, $id){

        $includes = $this->getIncludes($request);

        $user = $this->repo->with($includes)
            ->findOrFail($id);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function patchUpdate(Request $request, $id){

        $user = $this->repo->findOrFail($id);

        $this->validate($request, [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|confirmed|min:6|max:255'
        ]);

        $details = ['first_name', 'last_name', 'email'];
        foreach($details as $detail){
            if($request->get($detail, null) !== null){
                $user->fill([$detail => $request->get($detail)]);
            }
        }

        if($request->get('password', null) !== null){
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'message' => trans('api.resource_updated', ['resource' => trans('global.user')]),
        ])->setStatusCode(200);
    }

    public function deleteDestroy($id){

        $user = $this->repo->findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.user')]),
        ])->setStatusCode(200);
    }

    public function patchRolesUpdate($id, Request $request){
        $user = $this->repo->findOrFail($id);

        $this->validate($request, [
            'roles' => 'required|array'
        ]);

        $roles = Role::whereIn('name', $request->get('roles', []))->get();
        foreach($roles as $role){
            $user->assignRole($role);
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.user')]),
        ])->setStatusCode(200);
    }

    public function putUsersUpdate($id, Request $request){

        $user = $this->repo->findOrFail($id);

        $this->validate($request, [
            'roles' => 'required|array'
        ]);

        // fetch an id list array of the permissions we need
        $roles = Role::whereIn('name', $request->get('roles', []))->get();
        $ids = [];
        foreach($roles as $role){
            $ids[] = $role->id;
        }

        // sync to current user
        $user->roles()->sync($ids);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.user')]),
        ])->setStatusCode(200);
    }

    public function deleteRolesDestroy($id, $roleid){

        $user = $this->repo->findOrFail($id);

        $role = Role::findOrFail($roleid);

        if(!$user->hasRole($role->name)){
            abort(404);
        }

        $user->roles()->detach($role->id);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

    public function deleteRolesDestroyAll($id){

        $user = $this->repo->findOrFail($id);

        $user->roles()->sync([]);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

}