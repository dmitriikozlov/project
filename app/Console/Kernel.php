<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
		
	$schedule->call(function () {
            $text = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		// MAIN PAGE
		$text .= <<< _XML
		<url>
			<loc>http://rnr.com.ua/</loc>
		</url>
_XML;

		// SELECT AND INSERT STATIC PAGES
		$sql = "SELECT p.* 
				FROM `pages` as p
			";
		$query = DB::select($sql);
		foreach($query as $item) {
			$request_url = $item->url;
		$text .= <<< _XML
<url>
	<loc>http://rnr.com.ua/{$request_url}</loc>
</url>
_XML;
		}
		
		// SELECT AND INSERT CATEGORIES
		$sql = "SELECT c.* 
				FROM `categories` as c
				LEFT JOIN `metas` as m
					ON c.meta_id = m.id
				WHERE c.show = 1
				AND (c.meta_id IS NULL OR m.robots = 'index,follow' OR m.robots = 'index,nofollow')
			";
		$query = DB::select($sql);
		foreach($query as $item) {
			$request_url = $item->url;
			$lastmod = mb_substr($item->updated_at, 0, 10);
		$text .= <<< _XML
<url>
	<loc>http://rnr.com.ua/catalog/{$request_url}</loc>
	<lastmod>{$lastmod}</lastmod>
</url>
_XML;
		}
		
		// SELECT AND INSERT PRODUCTS
        $sql = "SELECT c.url AS `category_url`, c.updated_at as `category_updated_at`, 
					   p.url AS `product_url`, p.updated_at as `product_updated_at` 
				FROM `category_products` as cp
				INNER JOIN`categories` as c
					ON cp.category_id = c.id
				INNER JOIN `products` as p
					ON cp.product_id = p.id
				LEFT JOIN `metas` as m
					ON p.meta_id = m.id
				WHERE p.show = 1
				AND (p.meta_id IS NULL OR m.robots = 'index,follow' OR m.robots = 'index,nofollow')
			";
		$query = DB::select($sql);
		
		foreach($query as $item) {
			$request_url = $item->category_url . '/' . $item->product_url;
			$lastmod = mb_substr($item->product_updated_at, 0, 10);
		$text .= <<< _XML
<url>
	<loc>http://rnr.com.ua/catalog/{$request_url}</loc>
	<lastmod>{$lastmod}</lastmod>
</url>
_XML;
		}
		
		// END
		$text .= '</urlset>';
		@unlink(public_path('sitemap.xml'));
		@file_put_contents(public_path('sitemap.xml'), $text, LOCK_EX);
    })->daily();
	
    }
}
