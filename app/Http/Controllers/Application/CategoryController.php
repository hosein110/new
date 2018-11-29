<?php

namespace App\Http\Controllers\Application;

use App\Category;
use App\Sub_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{


//    http://yourdomain.com/api/Application/category/select_category/0/1   return location categories  with posts count
// but   http://yourdomain.com/api/Application/category/select_category/1/0 retern post categories
    public function select_category($type, $hasWith = 1)
    {
        if ($hasWith)
            return Category::where('status', 1)->where('type', $type)->select('id', 'title', 'image_path')->withCount('posts')->get();
        else
            return Category::where('status', 1)->where('type', 1)->select('id', 'title', 'image_path')->withCount('sub_category')->get();


    }


    public function select_sub_category($category_id)
    {
            return Sub_category::where('category_id', $category_id)
                ->select('id', 'title', 'image_path')->get();

    }

    public function categories_posts()
    {

        //  return Category::with('posts:id');
        return $a = Category::select('id', 'title')->with(['posts' => function ($q) {
            $q->select("id",
                "category_id"
            );
            return $q->with('images')->limit(2);

        }])->where(['status' => 1, 'type' => 1])->paginate(10);



        return view('home', compact('a'));
    }

}
