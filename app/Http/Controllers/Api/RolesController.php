<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 21:55
 */

namespace App\Http\Controllers\Api;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected $allowedWheres = [
        'name',
        'label',
    ];

    protected $allowedIncludes = [
        'permissions',
        'users',
    ];

    public function __construct(){
        parent::__construct();

        $this->middleware('can:view.roles', ['only' => ['getIndex', 'getShow']]);
        $this->middleware('can:create.roles', ['only' => 'postCreate']);
        $this->middleware('can:update.roles', ['only' => ['patchUpdate', 'patchPermissionsUpdate', 'putPermissionsUpdate', 'deletePermissionsDestroy', 'deletePermissionsDestroyAll']]);
        $this->middleware('can:delete.roles', ['only' => 'deleteDestroy']);
    }

    public function getIndex(Request $request){

        $includes = $this->getIncludes($request);
        $where = $this->getWhereQuery($request);
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'asc');
        $per_page = $this->getPerPage($request);

        return Role::with($includes)
            ->where($where)
            ->orderBy($sort, $order)
            ->paginate($per_page)
            ->appends($request->query());
    }

    public function postCreate(Request $request){

        $this->validate($request, [
            'name' => 'required|string|alpha_dash|unique:roles,name',
            'label' => 'required|string',
            'permissions' => 'array'
        ]);

        //fetch all permissions requested, if all dont exist bail as we cant create relationships here
        $permissions = Permission::whereIn('name', $request->get('permissions', []))->get();
        if($permissions->count() != count($request->get('permissions', []))){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_create_failed', ['resource' => trans('global.role')]),
                'errors' => [
                    'permissions' => [
                        trans('api.resource_create_failed_relationship', ['relationship' => trans('global.permission')])
                    ]
                ]
            ]);
        }

        //new up a role and assign permissions
        $role = Role::create($request->only(['name', 'label']));

        foreach($permissions as $permission){
            $role->givePermissionTo($permission);
        }

        $role->save();

        return response()->json([
            'status' => 'success',
            'role' => $role,
            'message' => trans('api.resource_created', ['resource' => trans('global.role')]),
        ])->setStatusCode(201);

    }


    public function getShow(Request $request, $id){

        $includes = $this->getIncludes($request);

        $role = Role::with($includes)
            ->findOrFail($id);

        return response()->json([
            'role' => $role,
        ]);
    }

    public function patchUpdate(Request $request, $id){

        $role = Role::findOrFail($id);

        if($role->name == 'administrator'){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_update_failed', ['resource' => trans('global.role')]),
                'errors' => [
                    'name' => [
                        trans('global.role_admin_update_error')
                    ]
                ]
            ])->setStatusCode(422);
        }

        $this->validate($request, [
            'label' => 'sometimes|required|string'
        ]);

        if($request->get('label', false) !== false){
            $role->label = $request->get('label');
        }

        $role->save();

        return response()->json([
            'status' => 'success',
            'role' => $role,
            'message' => trans('api.resource_updated', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

    public function deleteDestroy($id){

        $role = Role::findOrFail($id);

        if($role->name == 'administrator'){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_delete_failed', ['resource' => trans('global.role')]),
                'errors' => [
                    'name' => [
                        trans('global.role_admin_delete_error')
                    ]
                ]
            ])->setStatusCode(422);
        }

        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

    public function patchPermissionsUpdate($id, Request $request){
        $role = Role::findOrFail($id);

        $this->validate($request, [
            'permissions' => 'required|array'
        ]);

        $permissions = Permission::whereIn('name', $request->get('permissions', []))->get();
        foreach($permissions as $permission){
            $role->givePermissionTo($permission);
        }

        $role->save();

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

    public function putPermissionsUpdate($id, Request $request){

        $role = Role::findOrFail($id);

        $this->validate($request, [
            'permissions' => 'required|array'
        ]);

        // fetch an id list array of the permissions we need
        $permissions = Permission::whereIn('name', $request->get('permissions', []))->get();
        $ids = [];
        foreach($permissions as $permission){
            $ids[] = $permission->id;
        }

        // sync to current role
        $role->permissions()->sync($ids);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.role')]),
        ])->setStatusCode(200);
    }

    public function deletePermissionsDestroy($id, $permissionid){

        $role = Role::findOrFail($id);

        $permission = Permission::findOrFail($permissionid);

        if($role->name == 'administrator'){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_delete_failed_relationship', ['relationship' => trans('global.permission')]),
                'errors' => [
                    'name' => [
                        trans('global.role_admin_update_error')
                    ]
                ]
            ])->setStatusCode(422);
        }

        if(!$role->hasPermission($permission->name)){
            abort(404);
        }

        $role->permissions()->detach($permission->id);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.permission')]),
        ])->setStatusCode(200);
    }

    public function deletePermissionsDestroyAll($id){

        $role = Role::findOrFail($id);

        if($role->name == 'administrator'){
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.resource_delete_failed_relationship', ['relationship' => trans('global.permission')]),
                'errors' => [
                    'name' => [
                        trans('global.role_admin_update_error')
                    ]
                ]
            ])->setStatusCode(422);
        }

        $role->permissions()->sync([]);

        return response()->json([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.permission')]),
        ])->setStatusCode(200);
    }

}