<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 29/02/16
 * Time: 13:46
 */

namespace App\Tests;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolesTest extends \TestCase
{

    public function testListAllRolesWithoutPermission(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $this->json('get', '/api/roles', [
            'api_token' => $user->api_token
        ])->assertResponseStatus(401);

    }

    public function testListAllRoles(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('get', '/api/roles', [
            'api_token' => $user->api_token
        ])->seeJsonStructure([
            'current_page',
            'data',
            'from',
            'to',
            'total'
        ])->assertResponseStatus(200);


    }

    public function testListFilterRoles(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('get', '/api/roles', [
            'api_token' => $user->api_token,
            'include' => 'permissions,users',
            'q' => ['label:like:Administrator'],
        ])->seeJsonStructure([
            'current_page',
            'data',
            'from',
            'to',
            'total'
        ])->assertResponseStatus(200);


    }

    public function testCreateRoleFailed(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/roles', [
            'api_token' => $user->api_token,
            'name' => 'testrole with spaces',
            'label' => 'A Test Role'
        ])->seeJson([
            'status' => 'failed'
        ])->seeJsonStructure([
            'errors'
        ])->assertResponseStatus(422);

        $this->dontSeeInDatabase('roles', ['name' => 'testrole with spaces', 'label' => 'A Test Role']);
    }

    public function testCreateRole(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/roles', [
            'api_token' => $user->api_token,
            'name' => 'testrole',
            'label' => 'A Test Role'
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_created', ['resource' => trans('global.role')])
        ])->seeJsonStructure([
            'role'
        ])->assertResponseStatus(201);

        $this->seeInDatabase('roles', ['name' => 'testrole', 'label' => 'A Test Role']);
    }

    public function testCreateRoleWithPermissions(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/roles', [
            'api_token' => $user->api_token,
            'name' => 'testrole',
            'label' => 'A Test Role',
            'permissions' => [
                'view.admin'
            ]
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_created', ['resource' => trans('global.role')])
        ])->seeJsonStructure([
            'role'
        ])->assertResponseStatus(201);

        $this->seeInDatabase('roles', ['name' => 'testrole', 'label' => 'A Test Role']);
    }

    public function testShowRole(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = factory(Role::class)->create();

        $this->json('get', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
        ])->seeJsonStructure([
            'role',
        ])->assertResponseStatus(200);
    }

    public function testUpdateRole(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = factory(Role::class)->create();

        $this->json('patch', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
            'label' => 'A Test Role',
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.role')])
        ])->seeJsonStructure([
            'role',
        ])->assertResponseStatus(200);
    }

    public function testUpdateRoleWithPermissions(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = factory(Role::class)->create();

        //admin wont have any roles, as by default there super users so checks always return true
        $this->assertFalse($role->hasPermission('update.application'));

        $this->json('patch', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
            'label' => 'A Test Role',
            'permissions' => [
                'update.application'
            ]
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.role')])
        ])->seeJsonStructure([
            'role',
        ])->assertResponseStatus(200);

    }

    public function testCannotUpdateRoleAdmin(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = Role::where('name', 'administrator')->first();

        $this->json('patch', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
            'label' => 'A Test Role',
            'permissions' => [
                'update.application'
            ]
        ])->seeJson([
            'status' => 'failed',
            'message' => trans('api.resource_update_failed', ['resource' => trans('global.role')])
        ])->assertResponseStatus(422);

    }

    public function testDeleteRole(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = factory(Role::class)->create();

        $this->json('delete', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.role')])
        ])->assertResponseStatus(200);

    }

    public function testCannotDeleteRoleAdmin(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $role = Role::where('name', 'administrator')->first();

        $this->json('delete', '/api/roles/' . $role->id, [
            'api_token' => $user->api_token,
        ])->seeJson([
            'status' => 'failed',
            'message' => trans('api.resource_delete_failed', ['resource' => trans('global.role')])
        ])->assertResponseStatus(422);

    }

}