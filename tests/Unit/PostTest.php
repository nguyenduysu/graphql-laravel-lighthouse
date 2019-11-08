<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
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

    public function testQueryPost()
    {
        $faker = \Faker\Factory::create();

        $post = \App\Post::create([
            'user_id' => rand(1,10),
            'title' => $faker->sentence,
            'content' => $faker->sentence
        ]);

        $this->graphQL('
            {
                post(id:'.$post->id.') {
                    id
                    title
                    content
                    author {
                        id
                    }
                    
                }
            }
            ')->assertJson([
                    'data' => [
                        'post' => [
                            'id' => $post->id,
                            'title' => $post->title,
                            'content' => $post->content,
                            'author' => [
                                'id' => $post->user_id
                            ]
                        ]
                    ]
                ]);
    }

    public function testQueriesPosts()
    {
//        $userA = factory(User::class)->create(['name' => 'A']);
//        $userB = factory(User::class)->create(['name' => 'B']);
//        $userC = factory(User::class)->create(['name' => 'C']);

//        $postA = factory(Post::class)->create(['user_id' => 17]);
//        $postB = factory(Post::class)->create(['user_id' => 18]);
//        $postC = factory(Post::class)->create(['user_id' => 19]);

        $faker = \Faker\Factory::create();
        for($i = 0; $i < 3; $i ++) {
            $post = \App\Post::create([
                'user_id' => rand(1, 10),
                'title' => $faker->sentence,
                'content' => $faker->sentence
            ]);
        }

        $response = $this->graphQL('
                posts(first: 10) {
                    data {
                        title
                    }       
                }
            '
        );

        $titles = $response->json("data.posts.*.title");

        $this->assertCount(3, $titles);

    }
}
