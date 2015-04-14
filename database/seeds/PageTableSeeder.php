<?php
/**
 * Created by PhpStorm.
 * User: xuguanfeng
 * Date: 2015/04/03
 * Time: 16:50
 */
use Illuminate\Database\Seeder;
use App\Http\Models\Admin\Page;

class PageTableSeeder extends Seeder {

    public function run()
    {
        DB::table('pages')->delete();

        for ($i=0; $i < 10; $i++) {
            Page::create([
                'title'   => 'Title '.$i,
                'slug'    => 'first-page',
                'body'    => 'Body '.$i,
                'user_id' => 1,
            ]);
        }
    }

}