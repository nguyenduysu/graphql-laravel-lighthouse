<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testLogin()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
        ]);

        $response =  $this->graphQL('
            {
                login(email:"'.$user->email. '", password: "secret") {
                    token
                    type
                }
            }
        ');

        $token = $response->json('data.*.token');

        $this->assertNotNull($token);

        $user->delete();
    }

    public function testCreateUser()
    {
        $user = factory(User::class)->create();

        // generate token when user login success
        $this->actingAs($user);

        $response = $this->graphQL('
                mutation {
                    createUser(name: "TestUser", email: "testUser@test.com", password: "secret") {
                        name
                        email
                    }
                }
        ');
        $email = $response->json('data.*.email');
        $this->assertSame(
            [
                'testUser@test.com'
            ],
            $email
        );

        $user->delete();

        $userEdited = User::where('email', 'testUser@test.com');
        if(isset($userEdited)) {
            $userEdited->delete();
        }
    }

    public function testDeleteUser() {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->graphQL('
            mutation {
                deleteUser(id: '. $user->id .')
            }
        ');
        $data = $response->json('data.*');
        $this->assertSame(
            [
            'Success'
            ],
            $data
        );
    }

    public function testEditUser() {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->graphQL('
            mutation {
                editUser(email: "'.$user->email.'", password: "newPassword", passwordConfirm: "newPassword")
            }
        ');

        $data = $response->json('data.*');
        $this->assertSame(
            [
                'Success'
            ],
            $data
        );

        $user->delete();
    }

    public function testQueryUser()
    {
        $user = factory(User::class)->create(['name' => 'UserTest1']);

        $response = $this->graphQL('
            {
                user(id: '.$user->id.') {
                    id
                    name
                    email
                }
            }
        ');

        $name = $response->json("data.*.name");

        $this->assertSame(['UserTest1'], $name);

        $user->delete();
    }

    public function testQueryUsers()
    {
        $userA = factory(User::class)->create(['email' => 'A@test.com']);
        $userB = factory(User::class)->create(['email' => 'B@test.com']);
        $userC = factory(User::class)->create(['email' => 'C@test.com']);

        $response = $this->graphQL('
                {
                    allUsers {
                        id
                        name
                        email
                    }
                }
            ');
        $data = $response->json("data.*.*.email");

        $this->assertContains(
            'A@test.com',
            $data
        );
        $this->assertContains(
            'B@test.com',
            $data
        );
        $this->assertContains(
            'C@test.com',
            $data
        );

        $userA->delete();
        $userB->delete();
        $userC->delete();
    }

    public function testQueryUsersPaginate()
    {
        $userA = factory(User::class)->create(['email' => 'A@test.com']);
        $userB = factory(User::class)->create(['email' => 'B@test.com']);
        $userC = factory(User::class)->create(['email' => 'C@test.com']);

        $first = 3;
        $response = $this->graphQL('
            {
                users(first: '.$first.') {
                    data {
                        id
                        name
                        email
                    }
                }
            }
        ');
        $users = $response->json('data.*.data.*');

        $this->assertCount(3, $users);

        $userA->delete();
        $userB->delete();
        $userC->delete();
    }
}
