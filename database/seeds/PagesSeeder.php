<?php

use Illuminate\Database\Seeder;

use App\Modules\Pages\Models\Page;

use App\Models\Utils\SeoText;
use App\Models\Utils\StickyFile;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
    
        DB::table('files')->truncate();
        DB::table('pages')->truncate();
        DB::table('seo_texts')->truncate();
    
        $this->pages();
        $this->files();
        $this->seo();
    }
    
    
    public function seo() {
        SeoText::create(array(
            'title' => 'Shake.CMS - лучшая система управления контентом!',
            'keywords' => 'Shake, CMS, управление, контент',
            'description' => 'Shake.CMS - удобная, дружелюбная, красивая система управления сайтом!',
            'parent_id' => 2,
            'parent_type' => 'Page',
        ));
    }
    
    public function pages() {
        Page::create(array(
            'active' => 1,
            'slug' => 'pervaya-stranica',
            'title' => 'Первая страница',
            'content' => '<p>Эта страница посвящается всем кто делаем свою CMS!</p>',
            'template' => 'default',
            'position' => 2,
        ));
        
        Page::create(array(
            'active' => 1,
            'slug' => 'glavnaya',
            'title' => 'Главная',
            'content' => '<p>Эта страница тоже посвящается всем кто делаем свою CMS!</p>',
            'template' => 'home',
            'is_home' => 1,
            'position' => 1,
            'file' => '/upload/images/page/2016_01/1_113.png'
        ));
        
        Page::create(array(
            'active' => 1,
            'slug' => 'qwe',
            'title' => 'Страница второго уровня',
            'template' => 'default',
            'position' => 1,
            'page_id' => 2,
        ));
        
        Page::create(array(
            'active' => 0,
            'slug' => 'qwee',
            'title' => 'Страница второго уровня (неактивная)',
            'template' => 'default',
            'position' => 2,
            'page_id' => 2,
        ));
        
        Page::create(array(
            'active' => 1,
            'slug' => 'qweee',
            'title' => 'Простая страница',
            'template' => 'default',
            'position' => 3,
        ));
        
        Page::create(array(
            'active' => 0,
            'slug' => 'qweeeee',
            'title' => 'Простая страница (неактивная)',
            'template' => 'default',
            'position' => 4,
        ));
        
        Page::create(array(
            'active' => 1,
            'slug' => 'iop',
            'title' => 'Простая страница',
            'template' => 'default',
            'position' => 4,
        ));
    }
    
    public function files() {
        StickyFile::create(array(
            'file' => '/upload/files/test.rar',
            'parent_id' => '2',
            'parent_type' => 'Page',
            'field' => 'images',
        ));
        
        StickyFile::create(array(
            'file' => '/upload/files/test_1.rar',
            'parent_id' => '2',
            'parent_type' => 'Page',
            'field' => 'images',
        ));
        
        StickyFile::create(array(
            'file' => '/upload/images/test_1.png',
            'parent_id' => '2',
            'parent_type' => 'Page',
            'field' => 'images',
        ));
        
        StickyFile::create(array(
            'file' => '/upload/images/test_3.png',
            'parent_id' => '2',
            'parent_type' => 'Page',
            'field' => 'test',
        ));
        
        StickyFile::create(array(
            'file' => '/upload/images/stickyfile/2016_02/test_1.png',
            'parent_id' => '2',
            'parent_type' => 'Page',
            'field' => 'images',
        ));
    }
}
