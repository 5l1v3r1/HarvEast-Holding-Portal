<?php

use App\Tag;
use App\Article;
use App\Comment;
use Illuminate\Database\Seeder;

class ArticleTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag1 = factory(Tag::class)->create();
        $tag2 = factory(Tag::class)->create();
        $tag3 = factory(Tag::class)->create();

        
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create();
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['city_id' => null, 'department_id' => null]);
        $articles[] = factory(Article::class)->create(['is_anchored'=> 1]);
        foreach ($articles as $key => $article) {
            $article->tags()->attach($tag1);
            $article->tags()->attach($tag2);
            $article->tags()->attach($tag3);
        }

        factory(Comment::class, 500)->create();
    }
}
