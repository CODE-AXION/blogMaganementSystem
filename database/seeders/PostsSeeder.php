<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Post;


class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Create 10 users
         $users = User::factory()->count(10)->create();

         // For each user, create 5 posts and have 3 other random users like each post
        foreach ($users as $user) {
            
            $posts = $user->posts()->saveMany(Post::factory()->count(5)->make());

            foreach ($posts as $post) {

                $likingUsers = $users->except($user->id)->random(3);

                foreach ($likingUsers as $likingUser) {

                    $post->likes()->create([
                        'user_id' => $likingUser->id,
                    ]);
                }
            }
        }
        
        // \DB::table('posts')->insert([

        //     [
        //         'id' => 1,
        //         'name' => 'Whats new in PHP 8.2? (7 features for you)',
        //         'description' =>'A comprehensive guide to the latest features and improvements — Lets say you developed a web application using PHP 7.0. Over time, new versions of PHP have been released, each with new features and',
        //         'user_id' => 1,
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Why Vue.js is The Top Choice for Freelance Web Development',
        //         'description' =>'Are you a freelance web developer whos tired of sifting through countless frameworks, libraries, and tools just to find the right one',
        //         'user_id' => 1,
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'ReactJs vs VueJs: Which One Should You Choose in 2023',
        //         'description' => 'by Abhimanyu Magapu JavaScript has become the most popular and widely used scripting language for creating web',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Hello Laravel Livewire',
        //         'description' => 'Officially : “Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.” What does it mean ? Creating UI usin',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'nextTick in vue.js for beginners',
        //         'description' => 'It is the useful feature provided by vue.js. The nextTick() method is used to call callback function after the next update cycle of the DOM. It synchronise the DOM changes basically. nextTick()',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 6,
        //         'name' => 'Cleaning Up Laravel Controllers: A Guide to Streamlined Code with Practical Examples',
        //         'description' => 'Introduction Laravel is a popular PHP framework that makes it easy for developers to create powerful and maintainable web applications.',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 7,
        //         'name' => 'Learn How to Create a New Slug in Laravel 9 and Livewire with This Guide',
        //         'description' => 'Explanation of Laravel Livewire: Laravel Livewire is a full-stack framework for building dynamic, responsive user interfaces us.',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 8,
        //         'name' => 'Add Docker to an existing Laravel 10 project',
        //         'description' => 'If you are using Windows Docker (without WSL) or have an existing Laravel 10 project, and you want to configure a Docker environment to your project please follow this steps. Create Dockerfile',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 9,
        //         'name' => ' Les Cover Some Powerful Feature to be Vue Jedi Master.',
        //         'description' => 'Vue.js is a popular JavaScript framework for building user interfaces that have gained much traction in recent years.',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 10,
        //         'name' => 'Add Docker to an existing Laravel 10 project',
        //         'description' => 'If you are using Windows Docker (without WSL) or have an existing Laravel 10 project, and you want to configure a Docker environment to your project please follow this steps. Create Dockerfile',
        //         'user_id' => 2,
        //     ],
        //     [
        //         'id' => 10,
        //         'name' => 'Creating Reusable Components with the Composition API & Composables',
        //         'description' => 'Hello, I would like to share with you the article of the presentation on “Creating Reusable Components with the Composition API &',
        //         'user_id' => 2,
        //     ],
           
        // ]);
    }
}
