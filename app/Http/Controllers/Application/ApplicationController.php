<?php

namespace App\Http\Controllers\Application;


use App\Category;
use App\City;
use App\Location;
use App\Possibility;

use App\Http\Controllers\Controller;
use App\Post;
use App\Report;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;

class ApplicationController extends Controller
{


    public function sit_home_page($catrgory_id = 0)
    {
        $result['users'] = User::where('id', 3)->get(['id', 'fullname', 'bio', 'image_path']);
        $result['categories'] = Category::where('type', 1)->get(['id', 'title', 'image_path']);


        $result['categories_posts'] = Category::with(['posts' => function ($q) use ($catrgory_id) {
            return $q
//                ->where('category_id', $catrgory_id)
                ->with('image')->inRandomOrder()->limit(4);
        }])
            //->inRandomOrder()

            ->where('type', 1)
            ->where(function ($q) use ($catrgory_id) {

            if ($catrgory_id == 0)
                return $q->where('id','<>', $catrgory_id)->get();

            else
                return $q->where('id', $catrgory_id)->get();
        })

            ->limit(4)->get(['id', 'title', 'image_path']);


        $result['locations'] = Location::where('is_confirm', 1)
            ->with(['user'=>function($q){
                return $q->select('id','username','image_path');
            }])

            ->with(['image'=>function($q){
                return $q->select('location_id','image_path');
            }])

            ->select('id','name','user_id')
            ->withCount('likes')
            ->orderBy('id', 'DESC')->limit(4)->get();

        return $result;
    }


    public function possibilities($type)
    {
        return Possibility::where('type', $type)->where('status', 1)->get();
    }


    public function app_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'version_app' => 'required',
            'content' => 'required',
            'department' => 'required',


        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $report = Report::create($request->all());
        if (!$report) {
            return app_response('0', 'error on inserted report');
        } else {
            return app_response('1', 'report inserted successfully ');
        }
    }


    public function state_location_list()
    {
        return State::select('id', 'name', 'image_path')->withCount('locations')->get();


    }

    public function all_state_list()
    {


        return State::select(['id', 'name', 'image_path'])->get();
    }

    public function all_city_list($state_id)
    {
        return City::select(['id', 'name', 'state_id', 'image_path'])->where('state_id', $state_id)->get();
    }

}
