<?php
namespace App\Tests;

use App\Models\User;

class RegisterTest extends \TestCase
{

    public function createApplication(){

        $app = parent::createApplication();

        //we must do this to test the routes or they will fail
        config()->set('user.allow_registration', true);

        return $app;
    }
    
    /**
     * A basic email validation login test.
     *
     * @return void
     */
    public function testInvalidRegisterEmail()
    {
        $this->json('post', '/register', [
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
    public function testInvalidRegisterPassword()
    {
        $this->json('post', '/register', [
            'email' => 'valid@email.com',
            'password' => ''
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A basic password required validation login test.
     *
     * @return void
     */
    public function testInvalidRegisterEmailExists()
    {
        $user = factory(User::class)->create();

        $this->json('post', '/register', [
            'email' => $user->email,
            'password' => 'testing',
            'password_confirmation' => 'testing'
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * A basic password failed validation register test.
     *
     * @return void
     */
    public function testInvalidRegisterPasswordFailed()
    {
        $this->json('post', '/register', [
            'email' => 'valid@email.com',
            'password' => 'testing123',
            'password_confirmation' => 'testing',
        ])->seeJson([
            'status' => 'failed'
        ])->assertResponseStatus(422);
    }

    /**
     * Test if loggedin cannot view register page.
     *
     * @return void
     */
    public function testCannotViewRegisterIfLoggedIn()
    {
        $user = factory(User::class)->create([
            'email' => 'valid@email.com',
            'password' => bcrypt('testing')
        ]);

        $this->actingAs($user)->visit('/')->visit('/register')->seePageIs('/');
    }


    /**
     * Test valid registration.
     *
     * @return void
     */
    public function testValidRegister()
    {
        $this->json('post', '/register', [
            'first_name' => 'test',
            'last_name' => 'ing',
            'email' => 'valid@email.com',
            'password' => 'testing',
            'password_confirmation' => 'testing'
        ])->seeJson([
            'status' => 'success',
            'location' => '/'
        ]);
    }
}
