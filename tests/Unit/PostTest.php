<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
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
        $post->delete();
    }

    public function testQueriesPosts()
    {
        $first = 3;
        $response = $this->graphQL('
                {
                    posts(first: '.$first.') {
                        data {
                            id
                            title
                        }                 
                    }
                }
            ');

        $posts = $response->json('data.*.data.*');
//        dd($posts);
        $this->assertCount(3, $posts);
    }
}
