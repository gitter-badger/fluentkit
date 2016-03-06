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

class UsersTest extends \TestCase
{

    public function testListAllUsersWithoutPermission(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $this->json('get', '/api/users', [
            'api_token' => $user->api_token
        ])->assertResponseStatus(401);

    }

    public function testListAllUsers(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('get', '/api/users', [
            'api_token' => $user->api_token
        ])->seeJsonStructure([
            'current_page',
            'data',
            'from',
            'to',
            'total'
        ])->assertResponseStatus(200);


    }

    public function testListFilterUsers(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('get', '/api/users', [
            'api_token' => $user->api_token,
            'include' => 'roles',
            'q' => ['email:like:valid@email.com'],
        ])->seeJsonStructure([
            'current_page',
            'data',
            'from',
            'to',
            'total'
        ])->assertResponseStatus(200);


    }

    public function testCreateUserFailed(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/users', [
            'api_token' => $user->api_token,
            'first_name' => 'firstname',
            'last_name' => 'last name'
        ])->seeJson([
            'status' => 'failed'
        ])->seeJsonStructure([
            'errors'
        ])->assertResponseStatus(422);

        $this->dontSeeInDatabase('users', ['first_name' => 'firstname', 'last_name' => 'last name']);
    }

    public function testCreateUser(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/users', [
            'api_token' => $user->api_token,
            'first_name' => 'testfirst',
            'last_name' => 'testlast',
            'email' => 'new@email.com',
            'password' => 'testing',
            'password_confirmation' => 'testing'
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_created', ['resource' => trans('global.user')])
        ])->seeJsonStructure([
            'user'
        ])->assertResponseStatus(201);

        $this->seeInDatabase('users', ['first_name' => 'testfirst', 'last_name' => 'testlast', 'email' => 'new@email.com']);
    }

    public function testCreateUserWithRoles(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $this->json('post', '/api/users', [
            'api_token' => $user->api_token,
            'first_name' => 'testfirst',
            'last_name' => 'testlast',
            'email' => 'new@email.com',
            'password' => 'testing',
            'password_confirmation' => 'testing',
            'roles' => [
                'administrator'
            ]
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_created', ['resource' => trans('global.user')])
        ])->seeJsonStructure([
            'user'
        ])->assertResponseStatus(201);

        $this->seeInDatabase('users', ['first_name' => 'testfirst', 'last_name' => 'testlast', 'email' => 'new@email.com']);
    }

    public function testShowUser(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $u = factory(User::class)->create();

        $this->json('get', '/api/users/' . $u->id, [
            'api_token' => $user->api_token,
        ])->seeJsonStructure([
            'user',
        ])->assertResponseStatus(200);
    }

    public function testUpdateUser(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $u = factory(User::class)->create();

        $this->json('patch', '/api/users/' . $u->id, [
            'api_token' => $user->api_token,
            'first_name' => 'A New Name',
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.user')])
        ])->seeJsonStructure([
            'user',
        ])->assertResponseStatus(200);
    }

    public function testUpdateUserWithRoles(){
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $u = factory(User::class)->create();

        //admin wont have any roles, as by default there super users so checks always return true
        $this->assertFalse($u->hasRole('administrator'));

        $this->json('patch', '/api/users/' . $u->id . '/roles', [
            'api_token' => $user->api_token,
            'roles' => [
                'administrator'
            ]
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_updated', ['resource' => trans('global.user')])
        ])->assertResponseStatus(200);

    }

    public function testDeleteUser(){

        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $user->assignRole('administrator');

        $u = factory(User::class)->create();

        $this->json('delete', '/api/users/' . $u->id, [
            'api_token' => $user->api_token,
        ])->seeJson([
            'status' => 'success',
            'message' => trans('api.resource_deleted', ['resource' => trans('global.user')])
        ])->assertResponseStatus(200);

    }

}