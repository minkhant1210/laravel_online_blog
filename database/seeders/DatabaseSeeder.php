<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Min Khant Zaw',
            'email' => 'minkhantzaw1210@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('asdffdsa'), // password
            'remember_token' => Str::random(10),
        ]);

        User::factory(10)->create();
        Category::factory(5)->create();
        Post::factory(20)->create();
        Tag::factory(5)->create();

//        Photo::create([
//           "name" => "adsfljkjawef",
//           "user_id" => 1,
//           "post_id" => 1,
//        ]);
//        Photo::create([
//            "name" => "adsfljkjawef",
//            "user_id" => 1,
//            "post_id" => 1,
//        ]);

        //for post-tag pivot table
        Post::all()->each(function ($post){
            $tadIds = Tag::inRandomOrder()->limit(rand(1,3))->get()->pluck('id');
            $post->tags()->attach($tadIds);
        });


    }
}
