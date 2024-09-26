<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(30)->create();
        /* $posts = [
            ["title" => 'Post 1', 'content' => 'Texto 1 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 1],
            ["title" => 'Post 2', 'content' => 'Texto 2 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 2],
            ["title" => 'Post 3', 'content' => 'Texto 3 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 3],
            ["title" => 'Post 4', 'content' => 'Texto 4 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 4],
            ["title" => 'Post 5', 'content' => 'Texto 5 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 5],
            ["title" => 'Post 6', 'content' => 'Texto 6 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 6],
            ["title" => 'Post 7', 'content' => 'Texto 7 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 7],
            ["title" => 'Post 8', 'content' => 'Texto 8 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 8],
            ["title" => 'Post 9', 'content' => 'Texto 9 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 9],
            ["title" => 'Post 10', 'content' => 'Texto 10 dfalkjfdoiasfoiasjdodfjdsofjoidsf', 'author_id' => 10],
        ]; */

        //DB::table('posts')->insert($posts);
    }
}
