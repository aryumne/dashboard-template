<?php

namespace App\Console\Commands;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\CorePage;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create(config('app.url'));
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily')->setLastModificationDate(now()));

        $aboutPages = CorePage::where('is_active', 1)->get();
        foreach ($aboutPages as $page) {
            $sitemap->add(Url::create("/kategori/$page->slug")->setPriority(0.9)->setChangeFrequency('monthly')->setLastModificationDate($page->updated_at));
        }
        $categories = Category::where('is_active', 1)->get();
        foreach ($categories as $category) {
            $sitemap->add(Url::create("/kategori/$category->slug")->setPriority(0.8)->setChangeFrequency('weekly')->setLastModificationDate($category->updated_at));
        }

        $posts = Post::where('is_published', 1)->get();
        foreach ($posts as $post) {
            $sitemap->add(Url::create("/artikel/$post->slug")->setPriority(0.7)->setChangeFrequency('weekly')->setLastModificationDate($post->updated_at));
        }

        $tags = Tag::where('is_active', 1)->get();
        foreach ($tags as $tag) {
            $sitemap->add(Url::create("/hashtag/$tag->slug")->setPriority(0.6)->setChangeFrequency('weekly')->setLastModificationDate($tag->updated_at));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        return 'Sitemap generated';
    }
}
