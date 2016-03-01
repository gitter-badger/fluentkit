<?php
namespace App\Tests;

use App\Models\User;

class LoginTest extends \TestCase
{
    /**
     * A basic email validation login test.
     *
     * @return void
     */
    public function testInvalidLoginEmail()
    {
        $this->json('post', '/login', [
            'email' => 'invalidemail',
            'password' => 'apassword'
        ])->seeJson([
            'status' => 'failed'
        ]);
    }

    /**
     * A basic password required validation login test.
     *
     * @return void
     */
    public function testInvalidLoginPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);
        $this->json('post', '/login', [
            'email' => 'valid@email.com',
            'password' => ''
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A basic password failed validation login test.
     *
     * @return void
     */
    public function testInvalidLoginPasswordFailed()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);
        $this->json('post', '/login', [
            'email' => 'valid@email.com',
            'password' => 'testing123'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * Test if loggedin cannot view login page.
     *
     * @return void
     */
    public function testCannotViewLoginIfLoggedIn()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $this->actingAs($user)->visit('/')->visit('/login')->seePageIs('/');
    }


    /**
     * Test valid login.
     *
     * @return void
     */
    public function testValidLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $this->json('post', '/login', [
            'email' => 'valid@email.com',
            'password' => 'testing'
        ])->seeJson([
            'status' => 'success',
            'location' => '/'
        ]);
    }
}
