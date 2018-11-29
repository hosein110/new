<?php

namespace App\Http\Controllers\admin;

use App\Analyze;
use App\Location;
use App\LocationInfo;
use App\Post;
use App\PostReport;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function siteMap()
    {


        $header = '<?xml version="1.0" encoding="utf-8"?>
<!--Created using XmlSitemapGenerator.org - Free HTML, RSS and XML sitemap generator-->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $footer = '</urlset>';

        $URL = "http://vilanserver.com";
        $body = "";

        $now = Carbon::now();
        $users = User::get(['username']);
        $locations = Location::get(['slug']);
        $posts = Post::get(['slug']);

        foreach ($users as $user) {
            $body .= "<url>
                    <loc>" . $URL . "/profile/" . $user->username . "</loc>
                    <lastmod>" . $now . "</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.0</priority>
                    </url>\n";
        }


        foreach ($locations as $location) {
            $body .= "<url>
                    <loc>" . $URL . "/location/" . $location->slug . "</loc>
                    <lastmod>" . $now . "</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.0</priority>
                    </url>\n";
        }


        foreach ($posts as $post) {
            $body .= "<url>
                    <loc>" . $URL . "/post/" . $post->slug . "</loc>
                    <lastmod>" . $now . "</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.0</priority>
                    </url>\n";
        }

        $file = $header . $body . $footer;

        file_put_contents('sitemap.xml', $file);
    }

    public function analyzes()
    {
        return view('admin.home.analyzes');
    }
    public function analyzes_keywords()
    {
        $keyword = Input::get('keyword', '');
        $date = Input::get('date', '');
      $keywords=Analyze::select('keyword',DB::raw('count(keyword) as keyword_count'))
            ->orderBy('keyword_count','DESC')
            ->groupBy('keyword')
            ->SearchKeyword($keyword,$date)
            ->paginate(20);

        return view('admin.home.keywords_list', compact('keywords'));
    }

    public function analyzes_links()
    {
        $keyword = Input::get('keyword', '');
        $date = Input::get('date', '');
          $links=Analyze::select('this_url',DB::raw('count(this_url) as visit_count'))
              ->orderBy('visit_count','DESC')
              ->groupBy('this_url')
              ->Search($keyword,$date)
              ->paginate(20);

        return view('admin.home.links_list', compact('links'));
    }

    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastmonth = Carbon::now()->subDays(30);
        $lastweek = Carbon::now()->subDays(7);

        $lastyear = Carbon::now()->subDays(365);

        $summary['today_user_count'] = User::where('created_at', '>', $today)->count();

        $summary['yesterday_user_count'] = User::where('created_at', '<', $today)->where('created_at', '>', $yesterday)->count();
        $summary['last_week_user_count'] = User::where('created_at', '>', $lastweek)->count();
        $summary['last_month_user_count'] = User::where('created_at', '>', $lastmonth)->count();
        $summary['last_year_user_count'] = User::where('created_at', '>', $lastyear)->count();

        return view('admin.home.home', compact('summary'));
    }


    public function analyzes_summary($site)
    {
        $lastmonth = Carbon::now()->subDays(30);
        $result['receive_user']=DB::select("SELECT created_at as y , COUNT(*) as a  FROM `analyzes` WHERE created_at > '{$lastmonth}' && base_url='{$site}'  GROUP by DATE_FORMAT(created_at, '%Y/%m/%d' )");
        $result['total_receive']=count(Analyze::all()->where('created_at','>',$lastmonth)->where('base_url',$site));
        $total = Analyze::count();
        $result['os'] = Analyze::select(DB::raw('ROUND(count(id) *100/' . $total . ',1) as value'), 'os as label')->groupBy('os')->get();
        $result['browser'] = Analyze::select(DB::raw('ROUND(count(id) *100/' . $total . ',1) as value'), 'browser as  label')->groupBy('browser')->get();
        $result['total'] = $total;
        return $result;
    }


    public function summary()
    {
        $statement = DB::statement("SET @running_total=0");
        $summary['posts_per_user'] = DB::table('users_posts')
            ->select(DB::raw(' user_count as today_user_count,post_count as today_post_count , date,  @running_total :=@running_total+ user_count AS total_user'))
            //  ->limit(30)
            // ->orderBy('date', 'DESC')
            ->get();


        $summary['posts_per_user']->map(function ($query) {
            //  $query->date = str_replace('/', '-', $query->date);
            if ($query->today_post_count > 0) {
                $query->avrage_post = number_format((float)$query->today_post_count / $query->total_user, 2, '.', '');
            } else {
                $query->avrage_post = 0;
            }
            return $query;
        });
        return $summary;
    }
}
