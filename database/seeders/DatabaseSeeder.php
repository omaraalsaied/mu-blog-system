<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(2)->create();
        // Post::factory(2)->create();
        // PostImage::factory(2)->create();


        \App\Models\Comment::factory()->create([
            'body' => 'Test Comment',
            'user_id' => 3,
            'post_id' => 37,
        ]);
    }
}
