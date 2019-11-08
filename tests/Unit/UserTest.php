<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

//    public function testCreateUser()
//    {
//        $user = factory(User::class)->create();
//        $response = $this->postGraphQL([
//            'query' => '
//            mutation createUser($name: String!, $email: String!, $password: String! @bcrypt) {
//                createUser(name: $name, email: $email, password: @password) {
//                    id
//                    name
//                    email
//                }
//            }
//        ',
//            'variables' => [
//                'name' => 'testing',
//                'email' => 'testing@test.com',
//                'password' => 'secret'
//            ],
//        ]);
//    }
}
