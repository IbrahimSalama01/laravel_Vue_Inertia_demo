<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ibrahim',
            'email' => 'ibrahimsalama100@outlookc.com',
        ]);
        User::factory(5)->create();
        $this->call(PostSeeder::class);
        Comment::factory(500)->create();

    }
}
