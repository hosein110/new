<?php

namespace App\Http\Controllers\Application;


use App\Follow;
use App\Http\Controllers\Controller;
use App\LocationPin;
use App\Post;
use App\PostImage;
use App\PostPrice;
use App\PostComment;
use App\PostLike;
use App\PostRate;
use App\PostReport;
use App\PostStar;
use App\PostView;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{


    public function home_page($user_id)
    {
        $page = Input::get('page', '1');
        $value = Cache::remember('home_page_:' . $user_id . ':page=' . $page, 100, function () use ($user_id) {

            $following = Follow::where('user_id', $user_id)->where('accept', 1)->get(['follower_id'])->pluck('follower_id');
            $following[] = $user_id;
            $result = Post::leftjoin('users', 'users.id', '=', 'posts.user_id')
                ->leftjoin('post_rates', 'post_rates.post_id', '=', 'posts.id')
                ->select(
                    'posts.id as id',
                    'posts.location_id as location_id',
                    'posts.user_id as user_id1',
                    'users.fullname as user_name',
                    'users.image_path as user_image'
                //   DB::raw("ifnull(cast(avg(post_rates.rate) as decimal(6,2)),0) as avg_rate ")

                )
                ->with('image')
                ->withCount(['likes' => function ($q) {
                    return $q->where('post_likes.is_like', 1);
                }])
                ->withCount('comments')
                ->withCount('views')
                ->with(array("likes" => function ($q) use ($user_id) {
                    return $q->where('post_likes.is_like', 1)->where('post_likes.user_id', $user_id);
                }))
                ->with(array("stares" => function ($q) use ($user_id) {
                    return $q->where('post_stars.is_star', 1)->where('post_stars.user_id', $user_id);
                }))
                ->with(array("wish_list" => function ($q) use ($user_id) {
                    return $q->where('location_pins.is_pin', 1)->where('location_pins.user_id', $user_id);
                }))
                ->whereIn('posts.user_id', $following->toArray())
                ->groupBy("posts.id")
                ->orderBy("posts.id", "DESC")
                ->paginate(50);


            $result->map(function ($query) use ($user_id) {


                $query['is_liked'] = 0;
                $query['is_stared'] = 0;
                $query['is_wish_listed'] = 0;


                if (sizeof($query->likes) > 0) {
                    $query['is_liked'] = 1;
                }

                if (sizeof($query->stares) > 0) {
                    $query['is_stared'] = 1;
                }
                if (sizeof($query->wish_list) > 0) {
                    $query['is_wish_listed'] = 1;
                }

                unset($query['likes']);
                unset($query['stares']);
                unset($query['wish_list']);
                return $query;
            });


            return $result;
        });
        return $value;
    }

    /// nadarim shayad hazf beshe in method
    public function post_list($location_id)
    {
        $page = Input::get('page', '1');
        $value = Cache::remember('post_list:' . $location_id . ':page=' . $page, 100, function () use ($location_id) {
            $result = Post::leftjoin('users', 'users.id', '=', 'posts.user_id')
                ->leftjoin('post_rates', 'post_rates.post_id', '=', 'posts.id')
                ->leftjoin('post_likes', 'post_likes.post_id', '=', 'posts.id')
                ->leftjoin('post_comments', 'post_comments.post_id', '=', 'posts.id')
                ->leftjoin('post_views', 'post_views.post_id', '=', 'posts.id')
                ->select(
                    'posts.id as id',
                    'users.fullname as user_name',
                    'users.image_path as user_image',
                    DB::raw("ifnull(cast(avg(post_rates.rate) as decimal(6,2)),0) as avg_rate "),
                    DB::raw("count(DISTINCT(post_likes.id)) as count_likes"),
                    DB::raw("count(DISTINCT(post_comments.id)) as count_comment"),
                    DB::raw("count(DISTINCT(post_views.id)) as post_view")
                )
                ->with(['images' => function ($q) {
                    return $q->select('image_path', 'post_images.post_id');
                }])
                ->where('location_id', $location_id)
                ->groupBy("posts.id")
                ->paginate(20);
            return $result;

        });
        return $value;
        return view('welcome', compact('value'));


    }

    public function post_like(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'is_like' => 'required',
        ]);

        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $like = PostLike::updateOrCreate(['user_id' => $request->user_id, 'post_id' => $request->post_id],
            ['user_id' => $request->user_id, 'post_id' => $request->post_id, 'is_like' => $request->is_like]);
        if (!$like) {
            return app_response(0, "fail ");
        }
        $this->delete_cache('*post_list*');
        $this->delete_cache('*home_page*');
        return app_response(1, "your like was successfully");
    }

    public function post_rate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'rate' => 'required',
        ]);

        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $rate = PostRate::updateOrCreate(['user_id' => $request->user_id, 'post_id' => $request->post_id],
            ['user_id' => $request->user_id, 'post_id' => $request->post_id, 'rate' => $request->rate]);

        if (!$rate) {
            return app_response(0, "fail ");
        }
        $this->delete_cache('*post_list*');
        $this->delete_cache('*home_page*');
        return app_response(1, "your rate was successfully");
    }

    public function post_star(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'user_id' => 'required',
            'is_star' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $pin = PostStar::updateOrCreate(['user_id' => $request->user_id, 'post_id' => $request->post_id],
            ['user_id' => $request->user_id, 'post_id' => $request->post_id, 'is_star' => $request->is_star]);

        if (!$pin) {
            return app_response(0, "fail ");
        }
        $this->delete_cache('*post_list*');
        $this->delete_cache('*home_page*');
        return app_response(1, "your pin was successfully");
    }

    public function post_wish_list(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'location_id' => 'required',
            'user_id' => 'required',
            'is_wish_list' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $pin = LocationPin::updateOrCreate(['user_id' => $request->user_id, 'location_id' => $request->location_id],
            ['user_id' => $request->user_id, 'location_id' => $request->location_id, 'is_pin' => $request->is_wish_list]);

        if (!$pin) {
            return app_response(0, "fail ");
        }
        $this->delete_cache('*post_list*');
        $this->delete_cache('*home_page*');
        return app_response(1, "your wish was successfully");
    }


    public function post_price_show()
    {
        return 1;
    }

    public function post_show($user_id, $post_id){


        PostView::updateOrCreate(
            [
                'user_id' => $user_id,
                'post_id' => $post_id
            ],
            [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'mac' => 'my mac',
                'ip' => getIp()
            ]
        );


        $value = Cache::remember('post_show:' . $user_id . ':' . $post_id, 100, function () use ($user_id, $post_id) {

            $result = Post::leftjoin('users', 'users.id', '=', 'posts.user_id')
                ->leftjoin('locations', 'locations.id', '=', 'posts.location_id')
                ->leftjoin('sub_categories', 'sub_categories.id', '=', 'posts.sub_category_id')
                ->with(array('tags' => function ($q) {
                    return $q->select('tags.title', 'tags.image_path');
                }))
                ->with(array('prices' => function ($q) {
                    return $q->select('post_id', 'field', 'description', 'price');
                }))
                ->with(array("wish_list" => function ($q) use ($user_id) {
                    return $q->where('location_pins.is_pin', 1)->where('location_pins.user_id', $user_id);
                }))
                ->with('images')
                ->with('user')
                ->where('posts.id', $post_id)
                ->select('sub_categories.title as tag', 'posts.id' ,'posts.location_id as location_id', 'posts.caption', 'posts.ptotal', 'users.fullname', 'users.image_path as user_image_path', 'locations.name as location_name')
                ->first();


            foreach ($result['tags'] as $item)
                unset($item['pivot']);

            return $result;
        });

        $value['comments'] = PostComment::with(['me' => function ($q) {
            return $q->select('' .
                'id', 'username', 'image_path');
        }])->with(['him' => function ($q) {
            return $q->select('' .
                'id', 'username', 'image_path');
        }])
            ->where('post_id', $post_id)->get();


        $value['is_wish_listed'] = 0;

        if (sizeof($value->wish_list) > 0) {
            $value['is_wish_listed'] = 1;
        }
        $value['is_like'] = PostLike::where('post_id', $post_id)->where('user_id', $user_id)->where('is_like', 1)->count('id');
        $value['is_star'] = PostStar::where('post_id', $post_id)->where('user_id', $user_id)->where('is_star', 1)->count('id');
        $value['count_like'] = PostLike::where('post_id', $post_id)->count('id');
        $value['count_comment'] = PostComment::where('post_id', $post_id)->count('id');
        $value['count_view'] = PostView::where('post_id', $post_id)->count('id');

//        $value['is_wish_listed'] = LocationPin::where('location_pins.is_pin', 1)->where('location_pins.user_id', $user_id)->count();


        return $value;
    }

    public function post_comment($post_id)
    {
        $page = Input::get('page', '1');
        $value = Cache::remember('post_comment:' . $post_id . ':page=' . $page, 100, function () use ($post_id) {

            return PostComment::with(['me' => function ($q) {
                return $q->select('' .
                    'id', 'username', 'image_path');
            }])->with(['him' => function ($q) {
                return $q->select('' .
                    'id', 'username', 'image_path');
            }])->where('post_id', $post_id)
                ->orderBy('id', 'DESC')
                ->paginate(20);
        });

        return $value;
    }

    public function post_comment_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'comment' => 'required|max:255',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $comment = PostComment::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'comment' => $request->comment
            ]);
            if (!$comment) {
                return app_response(0, "error in  inserting Post comment");
            } else {
                $this->delete_cache('*post_list*');
                $this->delete_cache('*home_page*');
                $this->delete_cache('*post_comment:' . $request->post_id . '*');
                return app_response(1, "comment inserting successfully");
            }
        }
    }

    public function post_comment_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'comment_id' => 'required',
            'comment' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $comment = PostComment::where('id', $request->comment_id)
                ->where('user_id', $request->user_id)
                ->update(['comment' => $request->comment]);
            if ($comment != 1) {
                return app_response(0, "error in  Updating Post comment");
            }
            return app_response(1, "comment updated successfully");

        }
    }

    public function post_comment_replay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'comment_id' => 'required',
            'reply_user_id' => 'required',
            'comment' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $comment = PostComment::create([
                'user_id' => $request->user_id,
                'post_id' => $request->post_id,
                'reply_id' => $request->comment_id,
                'reply_user_id' => $request->reply_user_id,
                'comment' => $request->comment
            ]);
            if (!$comment) {
                return app_response(0, "error in  inserting Post comment");
            } else {
                $this->delete_cache('*post_list*');
                $this->delete_cache('*home_page*');
                $this->delete_cache('*post_comment:' . $request->post_id . '*');
                return app_response(1, "comment inserting successfully");
            }
        }
    }

    public function post_add(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'sub_category_id' => 'required',
            'category_id' => 'required',
            'location_id' => 'required',
            'version_app' => 'required',
            'images' => 'required',
//            'caption' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $post = Post::create(
                [
                    'slug' => str_random(15),

                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_category_id,
                    'location_id' => $request->location_id,
                    'caption' => $request->caption,
                    'version_app' => $request->version_app,
                ]
            );
            if (!$post) {
                return app_response(0, "error inserting location");
            }
            if (isset($request->tags)) {
                $post->tags()->attach($request->tags);
            }


            if (isset($request->price)) {
                $price = json_decode($request->price);
                for ($i = 0; $i < sizeof($price); $i++) {
                    PostPrice::create([
                        'post_id' => $post->id,
                        'field' => $price[$i]->field,
                        'description' => $price[$i]->description,
                        'price' => $price[$i]->price
                    ]);
                    $post->ptotal += $price[$i]->price;
                }
                $post->save();
            }

            $images = UPLOAD_IMAGE($request, 'images', 'images/post', 'w.png', 80, 'bottom-left', 80, 100);
            for ($i = 0; $i < sizeof($images['image_path']); $i++) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $images['image_path'][$i],
                    'resize_path' => $images['resize_path'][$i],
                    'watermark_path' => $images['watermark_path'][$i],
                    'sort' => $i + 1
                ]);
            }

            $this->delete_cache('*profile_post*');
            $this->delete_cache('*post_list*');
            $this->delete_cache('*home_page*');
            $this->delete_cache("*location_list:*");
            $this->delete_cache("*location_show:" . $request->location_id . "*");
            return app_response(1, "Post inserted successfully");
        }
    }

    public function post_report(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'report_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $result = PostReport::updateOrCreate(
                ['user_id' => $request->user_id, 'post_id' => $request->post_id],
                ['user_id' => $request->user_id, 'post_id' => $request->post_id, 'report_type_id' => $request->report_type_id]
            );
            if (!$result) {
                return app_response(0, "error in  inserting post Report");
            } else {
                return app_response(1, "report inserting successfully");
            }
        }

    }

    public function related_post($location_id)
    {

        $result = Post::where('location_id', $location_id)
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where('users.is_public', 1)
            ->select('posts.id as id')
            ->with('image')
            ->inRandomOrder()
            ->paginate(4);

        return $result;
    }
}
