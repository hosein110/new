<?php

namespace App\Http\Controllers\Application;

use App\Category;
use App\Http\Controllers\Controller;
use App\Location;
use App\LocationComment;
use App\LocationImage;
use App\LocationInfo;
use App\LocationLike;
use App\LocationPin;
use App\LocationRate;

use App\LocationReport;
use App\Post;
use App\User;
use App\WorkTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;
use function PHPSTORM_META\type;


class LocationController extends Controller
{

    public function location_comment($location_id)
    {


        $page = Input::get('page', '1');
        $value = Cache::remember('location_comment:' . $location_id . ':page=' . $page, 100, function () use ($location_id) {

            return LocationComment::with(['me' => function ($q) {
                return $q->select('' .
                    'id', 'username', 'image_path');
            }])->with(['him' => function ($q) {
                return $q->select('' .
                    'id', 'username', 'image_path');
            }])->where('location_id', $location_id)
                ->orderBy('id', 'DESC')
                ->paginate(20);
        });

        return $value;


//        $page = Input::get('page', '1');
//        $value = Cache::remember('location_comment:' . $location_id . ':page=' . $page, 100, function () use ($location_id) {
//
//            return LocationComment::where('location_id', $location_id)->paginate(50);
//        });
//        return $value;
    }

    public function location_comment_add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'comment' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        } else {

            $comment = LocationComment::create([
                'user_id' => $request->user_id,
                'location_id' => $request->location_id,
                'comment' => $request->comment
            ]);
            if (!$comment) {

                return app_response(0, "error in  inserting location comment", 4);
            } else {
                $this->delete_cache('*location_comment:' . $request->location_id . '*');
                $this->delete_cache("*location_list*");
                $this->delete_cache("*location_show*");
                return app_response(1, "comment inserting successfully");
            }
        }
    }

    public function location_comment_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'comment_id' => 'required',
            'comment' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $comment = LocationComment::where('id', $request->comment_id)
                ->where('user_id', $request->user_id)
                ->update(['comment' => $request->comment]);
            if ($comment != 1) {
                return app_response(0, "error in  inserting location comment");
            }
            $this->delete_cache('*location_comment:' . $request->location_id . '*');

            return app_response(1, "comment inserting successfully");

        }
    }

    public function location_comment_replay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'comment_id' => 'required',
            'reply_user_id' => 'required',
            'comment' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $comment = LocationComment::create([
                'user_id' => $request->user_id,
                'location_id' => $request->location_id,
                'reply_id' => $request->comment_id,
                'reply_user_id' => $request->reply_user_id,
                'comment' => $request->comment
            ]);
            if (!$comment) {
                return app_response(0, "error in  inserting location comment");
            } else {
                $this->delete_cache("*location_show*");
                $this->delete_cache('*location_comment:' . $request->location_id . '*');
                $this->delete_cache("*location_list*");
                return app_response(1, "comment inserting successfully");
            }
        }
    }

    public function location_list($user_id)
    {

        $page = Input::get('page', '1');
        $state_id = Input::get('state_id', '0');
        $category_id = Input::get('category_id', '0');
        $orderBY = Input::get('orderBy', 'null');
        $latitude = Input::get('lat', 'null');
        $longitude = Input::get('long', 'null');

        $value = Cache::remember('location_list:' . $user_id . ':' . $orderBY . ':' . $latitude . ':' . $longitude . ':state_id:' . $state_id . ':category_id:' . $category_id . ':page=' . $page, 100, function () use ($user_id, $orderBY, $latitude, $longitude, $state_id, $category_id) {


            $result = Location::leftjoin('location_rates', 'locations.id', '=', 'location_rates.location_id')
                ->leftjoin('states', 'locations.state_id', '=', 'states.id')
                ->leftjoin('cities', 'locations.city_id', '=', 'cities.id')
                ->leftjoin('posts', 'posts.location_id', '=', 'locations.id')
                ->leftjoin('location_possibility', 'location_possibility.location_id', '=', 'locations.id')
                ->select(
                    'locations.id as id',
                    'locations.name as location_name',
                    'locations.tel as tel',
                    'locations.price as price',
                    'states.name as state',
                    'cities.name as city',

                    DB::raw("ifnull(cast(avg(location_rates.rate) as decimal(6,2)),0) as avg_rate "),
                    DB::raw("ifnull(cast(avg(posts.ptotal) as decimal(6,2)),0) as avg_ptotal ")

                )
                ->with(array("posts.user" => function ($q) {

                    return $q->distinct()->select('id', 'image_path');
                }))
                ->with('work_time')
                ->with('possibilities')
                ->with('images')
                ->withCount('likes')
                ->OrderByKeyword($orderBY)
                ->SearchByState($state_id)
                ->SearchByCategory($category_id)
                ->Distance($latitude, $longitude)
                ->groupBy("locations.id")
                ->paginate(5);


            $result->map(function ($query) use ($user_id) {


                $array = [];
                $x = 0;


                foreach ($query->posts as $user) {

                    $x++;
                    if (!in_array($user->user, $array)) {
                        if ($x < sizeof($query->posts)) {
                            array_push($array, $user->user);
                        }
                        $x++;

                    }
                }
                $query['users'] = $array;
                unset($query['posts']);
                return $query;
            });


            return $result;
        });

        return $value;
    }

    public function location_add(Request $request)
    {


//       file_put_contents('TEST.txt', $request->has_work_time);

        $validator = Validator::make($request->all(), [

//           'name' => 'required|unique:locations|max:255',
            'name' => 'required|max:255',
            'user_id' => 'required',
            'category_id' => 'required',
            'content' => 'required|max:256',
            'price' => 'required',
            'tel' => 'required',
            'state_id' => 'required',

            'city_id' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'images' => 'required',
            'version_app' => 'required',
            'possibilities' => 'required',
            'has_work_time' => 'required',


        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }


        $location = Location::create(
            [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
//                'content' => $request->content,
                'price' => $request->price,
                'tel' => $request->tel,
                'slug' => str_random(15),
                'name' => $request->name,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'lat' => $request->lat,
                'longitude' => $request->long,
                'version_app' => $request->version_app
            ]

        );

        if ($request->has_work_time == 1) {


            $validator1 = Validator::make($request->all(), [
                'sunday' => 'required',
                'monday' => 'required',
                'tuesday' => 'required',
                'wednesday' => 'required',
                'thursday' => 'required',
                'friday' => 'required',
                'saturday' => 'required',
            ]);


            if ($validator1->fails()) {
                //  Location::where('id', $location->id)->delete();
                //  return app_response(0, 'Error work time', $validator->errors());

            } else {
                WorkTime::create([
                    'location_id' => $location->id,
                    'sunday' => $request->sunday,
                    'monday' => $request->monday,
                    'tuesday' => $request->tuesday,
                    'wednesday' => $request->wednesday,
                    'thursday' => $request->thursday,
                    'friday' => $request->friday,
                    'saturday' => $request->saturday,

                ]);
            }


            // return app_response(1111111, 'TTTTTTTTT');
        }


        if (isset($request->possibilities)) {
            $location->possibilities()->attach($request->possibilities);
        }

        if (isset($request->info)) {
            $infos = json_decode($request->info);


            for ($i = 0; $i < sizeof($infos); $i++)
//            foreach (json_decode($request->info) as $item) {

                LocationInfo::create([
                    'location_id' => $location->id,
                    'title' => $infos[$i]->title,
                    'description' => $infos[$i]->description,

                ]);
//            }

        }


        $images = UPLOAD_IMAGE($request, 'images', 'images/location', 'w.png', 80, 'bottom-left', 80, 100);

        for ($i = 0; $i < sizeof($images['image_path']); $i++) {
            LocationImage::create([
                'location_id' => $location->id,
                'image_path' => $images['image_path'][$i],
                'resize_path' => $images['resize_path'][$i],
                'watermark_path' => $images['watermark_path'][$i],
                'sort' => $i + 1
            ]);
        }

        $this->delete_cache("*location_list*");
        return app_response(1, "location inserted successfully");
    }

    public function location_update(Request $request)
    {
        $this->validate($request,
            [
                'user_id' => 'required',
                'location_id' => 'required',
                'category_id' => 'required',
                'content' => 'required|max:256',
                'price' => 'required',
                'tel' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'images' => 'required',
            ]
        );

        $location_update = Location::where('id', $request->location_id)->update(
            [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
//                'content' => $request->content,
                'price' => $request->price,
                'tel' => $request->tel,
                'name' => $request->name,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'lat' => $request->lat,
                'longitude' => $request->long
            ]
        );
        if (!$location_update) {
            return app_response(0, "error update location");
        }
        if (isset($request->possibilities)) {
            $location = Location::where('id', $request->location_id)->first();
            $location->possibilities()->detach();
            $location->possibilities()->attach($request->possibilities);
        }
        if (isset($request->info)) {
            foreach ($request->info as $item) {
                $update = LocationInfo::where('location_id', $location->id)->update([
                    'title' => $item['title'],
                    'description' => $item['description']
                ]);
                if (!$update) {
                    return app_response('0', 'Location Info update error');
                }
            }
        }
        // if not send saturday $request = public place
        if (isset($request->saturday)) {
            $update = WorkTime::where('location_id', $request->location_id)->update([
                'sunday' => $request->sunday,
                'monday' => $request->monday,
                'tuesday' => $request->tuesday,
                'wednesday' => $request->wednesday,
                'thursday' => $request->thursday,
                'friday' => $request->friday,
                'saturday' => $request->saturday,
            ]);
            if (!$update) {
                return app_response('0', 'work time update error');
            }
        }
        if ($request->hasfile('images')) {
            $count = 0;
            foreach ($request->file('images') as $image) {
                $count++;
                $name = $image->getClientOriginalName();
                $rand = str_random(10) . "_";
                $image->move(public_path() . '/images/', $rand . $name);
                $image_path = '/images/' . $rand . $name;

                $location_image = LocationImage::where('location_id', $request->location_id)->where('sort', $count)->update([
                    'image_path' => $image_path
                ]);
                if (!$location_image) {
                    LocationImage::Create([
                        'location_id' => $request->location_id,
                        'image_path' => $image_path,
                        'sort' => $count
                    ]);
                }
            }
        }
        $this->delete_cache("*location_list*");

        return app_response(1, "location inserted successfully");
    }

    public function location_show($user_id, $location_id)
    {

        $value = Cache::remember('location_show:' . $location_id . ':' . $user_id, 100, function () use ($user_id, $location_id) {

            // return  Post::with('user')->where('location_id',$location_id)->get();
            $result = Location::leftjoin('users', 'users.id', '=', 'locations.user_id')
                ->leftjoin('location_likes', 'locations.id', '=', 'location_likes.location_id')
                ->leftjoin('location_comments', 'locations.id', '=', 'location_comments.location_id')
                ->leftjoin('location_rates', 'locations.id', '=', 'location_rates.location_id')
                ->leftjoin('states', 'locations.state_id', '=', 'states.id')
                ->leftjoin('cities', 'locations.city_id', '=', 'cities.id')
                ->leftjoin('posts', 'posts.location_id', '=', 'locations.id')
                ->select(
                    'locations.id as id',
                    'locations.name as location_name',
                    'locations.lat as lat',
                    'locations.longitude as long',
                    'locations.tel as tel',
                    'locations.price as price',
                    'states.name as state',
                    'cities.name as city',
                    DB::raw("ifnull(cast(avg(posts.ptotal) as decimal(6,2)),0) as avg_ptotal "),
                    DB::raw("count(DISTINCT(location_likes.id)) as likes_count"),
                    DB::raw("count(DISTINCT(location_comments.id)) as comments_count"),
                    DB::raw("count(DISTINCT(posts.user_id)) as people_posted"),
                    DB::raw("ifnull(cast(avg(location_rates.rate) as decimal(6,2)),0) as avg_rate ")
                )
                ->with('images')
                ->with('transfers')
                ->with('entertainments')
                ->with(array("posts.user" => function ($q) {

                    return $q->distinct()->select('id', 'image_path');
                }))
                ->with(array("rate" => function ($q) use ($user_id) {
                    // return $q;
                    return $q->where('location_rates.user_id', $user_id)->select('rate', 'location_id', 'user_id');
                }))
                ->with(array("transfers" => function ($q) {
                    return $q->where('possibilities.type', 0);
                }))
                ->with(array("entertainments" => function ($q) {
                    return $q->where('possibilities.type', 1);
                }))
                ->with('infos')
                ->with('work_time')
                ->with(array("likes" => function ($q) use ($user_id) {
                    return $q->where('location_likes.is_like', 1)->where('location_likes.user_id', $user_id);
                }))
                ->with(array("pins" => function ($q) use ($user_id) {
                    return $q->where('location_pins.is_pin', 1)->where('location_pins.user_id', $user_id);
                }))
                ->where('locations.id', $location_id)
                ->groupBy("locations.id")
                ->get();

//        return Location::distinct()->where()->get();

            $result->map(function ($query) use ($user_id) {


                $query['user_rate'] = 0;
                if (isset($query->rate)) {
                    if (sizeof($query->rate) > 0) {
                        $query['user_rate'] = $query->rate->rate;
                    }
                }
                $array = [];
                $x = 0;


                foreach ($query->posts as $user) {

                    $x++;
                    if (!in_array($user->user, $array)) {
                        if ($x < sizeof($query->posts) && is_array($query->posts)) {
                            array_push($array, $user->user);
                        }
                        $x++;

                    }
                }


                $query['users'] = $array;

                $query['is_liked'] = 0;
                $query['is_pined'] = 0;
                $query['is_owner'] = 0;

                if ($query->user_id == $user_id) {
                    $query['is_owner'] = 1;
                }

                if (sizeof($query->likes) > 0) {
                    $query['is_liked'] = 1;
                }
                if (sizeof($query->pins) > 0) {
                    $query['is_pined'] = 1;
                }

                return $query;
            });
            if (sizeof($result) > 0) {
                unset($result[0]['likes']);
                unset($result[0]['pins']);
                unset($result[0]['posts']);
//            unset($result[0]['rate']);
                $result[0]['users']=User::limit(20)->get(['image_path','id','last_seen','username']);
                return $result[0];
            } else {
                return app_response(0, 'Omid location id ro dorost befrest khaheshan');
            }
        });


        return $value;
    }

    public function location_like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'is_like' => 'required',

        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $like = LocationLike::updateOrCreate(['user_id' => $request->user_id, 'location_id' => $request->location_id],
            ['user_id' => $request->user_id, 'location_id' => $request->location_id, 'is_like' => $request->is_like]);
        if (!$like) {
            return app_response(0, "fail ");
        }
        $this->delete_cache("*location_show:" . $request->location_id . "*");
        $this->delete_cache("*location_list*");
        return app_response(1, "your like was successfully");
    }

    public function location_rate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'rate' => 'required',

        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $rate = LocationRate::updateOrCreate(['user_id' => $request->user_id, 'location_id' => $request->location_id],
            ['user_id' => $request->user_id, 'location_id' => $request->location_id, 'rate' => $request->rate]);

        if (!$rate) {
            return app_response(0, "fail ");
        }
        $this->delete_cache("*location_show:" . $request->location_id . "*");
        $this->delete_cache("*location_list*");
        return app_response(1, "your rate was successfully");
    }

    public function location_pin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'is_pin' => 'required',

        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $pin = LocationPin::updateOrCreate(['user_id' => $request->user_id, 'location_id' => $request->location_id],
            ['user_id' => $request->user_id, 'location_id' => $request->location_id, 'is_pin' => $request->is_pin]);

        if (!$pin) {
            return app_response(0, "fail ");
        }
        $this->delete_cache("*location_show:" . $request->location_id . "*");
        $this->delete_cache("*location_list*");
        return app_response(1, "your pin was successfully");
    }

    public function location_categories()
    {

        $value = Cache::remember('location_categories', 100, function () {
            $result = Category::leftjoin('locations', 'categories.id', '=', 'locations.category_id')
                ->leftjoin('posts', 'locations.id', '=', 'posts.location_id')
                ->leftjoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->select(
                    'categories.id as id',
                    'categories.title as title',
                    'categories.image_path as image_path',
                    DB::raw("count(posts.id) as count_post"),
                    DB::raw('count(post_views.mac) as count_view')

                )
                ->where('categories.type', 0)
                ->where('categories.status', 1)
                ->groupBy('categories.id')
                ->get();


            return $result;
        });
        return $value;

    }

    public function location_report(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'location_id' => 'required',
            'report_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $result = LocationReport::updateOrCreate(
                ['user_id' => $request->user_id, 'location_id' => $request->location_id],
                ['user_id' => $request->user_id, 'location_id' => $request->location_id, 'report_type_id' => $request->report_type_id]
            );
            if (!$result) {
                return app_response(0, "error in  inserting location Report");
            } else {
                return app_response(1, "report inserting successfully");
            }
        }

    }

    public function location_search($location_name)
    {
        $orderBY = Input::get('orderBy', 'null');
        $latitude = Input::get('lat', 'null');
        $longitude = Input::get('long', 'null');
        $page = Input::get('page', '1');
        $value = Cache::remember('location_search:' . $location_name . ':' . $orderBY . ':' . $latitude . ':' . $longitude . ':page:' . $page, 100, function () use ($location_name, $orderBY, $latitude, $longitude) {

            $result = Location::leftjoin('location_rates', 'locations.id', '=', 'location_rates.location_id')
                ->leftjoin('states', 'locations.state_id', '=', 'states.id')
                ->leftjoin('cities', 'locations.city_id', '=', 'cities.id')
                ->leftjoin('posts', 'posts.location_id', '=', 'locations.id')
                ->select(
                    'locations.id as id',
                    'locations.name as location_name',
                    'locations.tel as tel',
                    'locations.price as price',
                    'states.name as state',
                    'cities.name as city',
                    DB::raw("ifnull(cast(avg(location_rates.rate) as decimal(6,2)),0) as avg_rate "),
                    DB::raw("ifnull(cast(avg(posts.ptotal) as decimal(6,2)),0) as avg_ptotal ")
                )
                ->where('locations.name', 'like', "%" . $location_name . "%")
                ->with('work_time')
                ->with(array("posts.user" => function ($q) {
                    return $q->select('id', 'image_path');
                }))
                ->with('images')
                ->OrderByKeyword($orderBY)
                ->Distance($latitude, $longitude)
                ->groupBy(['locations.id'])
                ->paginate(20);

            $result->map(function ($query) {

                $array = [];
                $x = 0;

                foreach ($query->posts as $user) {

                    if ($x < 3) {
                        array_push($array, $user->user);
                    }
                    $x++;

                }

                $query['users'] = $array;

                return $query;


            });
            $res_count = count($result);
            for ($i = 0; $i < $res_count; $i++) {
                unset($result[$i]['posts']);
            }
            return $result;
        });
        return $value;
    }
}
