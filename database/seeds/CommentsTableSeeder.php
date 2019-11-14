<?php
//database/seeds/CommentsTableSeeder.php
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        \App\Post::all()->each(function ($post) use ($faker) {
            foreach (range(1, 5) as $i) {
                \App\Comment::create([
                    'user_id' => rand(1,11),
                    'post_id' => $post->id,
                    'reply'   => $faker->sentence,
                ]);
            }
        });
    }
}
