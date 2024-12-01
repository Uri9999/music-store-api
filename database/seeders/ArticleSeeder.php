<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'Tutorial',
            'content' => 'Tutorial',
            'status' => Article::STATUS_PUBLIC,
            'type' => Article::TYPE_TUTORIAL,
            'user_id' => 1
        ]);

        Article::create([
            'title' => 'Policy',
            'content' => 'Policy',
            'status' => Article::STATUS_PUBLIC,
            'type' => Article::TYPE_POLICY,
            'user_id' => 1
        ]);
    }
}
