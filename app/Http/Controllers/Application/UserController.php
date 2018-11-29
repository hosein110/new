<?php

namespace App\Http\Controllers\Application;

use App\Follow;

use App\Header;
use App\Location;
use App\LocationPin;
use App\Message;
use App\MessageSetting;

use App\Notification;
use App\Post;
use App\PostStar;
use App\Report;
use App\User;

use App\UserChat;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Laravel\Passport\Client;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{


    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'sms_verify' => 'required|min:4|max:4',
            'password' => 'required|min:6|confirmed',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $res = User::where('sms_verify', $request->sms_verify)
            ->where('mobile', $request->mobile)
            ->update(['password' => bcrypt($request->password)]);
        if (!$res) {
            return app_response(0, 'خطا در تغییر رمز ! مجددا تلاش کنید.');
        } else {
            $res = User::where('sms_verify', $request->token)->update(['sms_verify' => 0]);
            return app_response(1, 'your password change successfully');
        }
        //   return redirect(route('index'));
    }

    public function check_sms_verify(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'sms_verify' => 'required|min:4|max:4',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $res = User::where('sms_verify', $request->sms_verify)->where('mobile', $request->mobile)->count();
        if ($res->sms_verify != 0 && strlen($res->sms_verify) == 4) {
            return app_response(1, 'code is correct go to next step');
        }
        return app_response(0, 'code is incorrect enter correct code');
    }

    public function recover_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',

        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }

        $message = rand(1000, 9999);
        $result = User::where('mobile', $request->mobile)
            ->update(['sms_verify' => $message]);
        if ($result) {

            SEND_SMS($request->number, $message);
            return app_response(1, 'we sent number with  sms   for you');
        } else {
            return app_response(0, 'user not found');


        }


    }

// when receive LOGOUT request from application  user`s  token be deactivate.
//وقتی درخواست خروج از حساب کاربری از طرف اپلیکیشن میاد توکن کاربر غیر فعال میشه.
    public function app_logout()
    {
        JWTAuth::invalidate();
        return app_response(1, 'Logged out Successfully.');

    }

// ابتدا بررسی میشه که فیلد نام کاربری و گذرواژه از طریق متد پست ارسال شده یا خیر
// .در صورتی که هر کدوم از فیلد ها ارسال نشده بودن وضعیت صفر و پیغام خطای مناسب رو توی پاسخ فرستاده میشه.
    public function app_login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {

            $credentials3['email'] = $credentials2['username'] = $credentials1['mobile'] = $request->username;
            $credentials1['password'] = $credentials2['password'] = $credentials3['password'] = $request->password;

            if ($token = JWTAuth::attempt($credentials1)) {
                $user = JWTAuth::toUser($token);
                return app_response(1, 'Login success full', [], ['token' => $token, 'id' => $user->id, 'image_path' => $user->image_path]);
            }
            if ($token = JWTAuth::attempt($credentials2)) {

                $user = JWTAuth::toUser($token);
                return app_response(1, 'Login success full', [], ['token' => $token, 'id' => $user->id, 'image_path' => $user->image_path]);
            }

            if ($token = JWTAuth::attempt($credentials3)) {
                $user = JWTAuth::toUser($token);
                return app_response(1, 'Login success full', [], ['token' => $token, 'id' => $user->id, 'image_path' => $user->image_path]);

            }


            return app_response(0, 'username or password incorrect');


        }
    }

    public function app_first_check_register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'fullname' => 'required',
            'register_type' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            return response()->json(['status' => 1]);
        }
    }

    public function app_second_check_register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'mobile' => 'required|unique:users',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $this->send_sms($request->mobile, $request->username);

            return response()->json(['status' => 1, "message" => 'SMS Sent']);
        }
    }

    public function app_final_register(Request $request)
    {

//      return  $result1 = UploadImageWithThumbnail($request->file('image'), "/uploads/images/stories");

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'mobile' => 'required|unique:users',
            'email' => 'unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'fullname' => 'required',
            'register_type' => 'required',
            'sms' => 'required',
            'version_app' => 'required'
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            $smsText = $this->get_sms($request->mobile, $request->username);

            if (in_array($request->sms, $smsText->toArray()) && strlen($request->sms) == 4) {

                $image = UPLOAD_IMAGE($request, 'image', 'images/users');
                if ($image == null) {
                    $image['image_path'][] = 'images/users/profile.png';

                }
                $result = User::create([
                    'fullname' => $request->fullname,
                    'username' => $request->username,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'image_path' => $image['image_path'][0],

                    'register_type' => $request->register_type,
                    'version_app' => $request->version_app,
                    'password' => bcrypt($request->password),
                ]);
                if ($result) {
                    MessageSetting::create(['user_id' => $result->id]);
                    $token = JWTAuth::attempt($request->only('username', 'password'));

                    $user = JWTAuth::toUser($token);
                    return app_response(1, 'Register success full', '', ['token' => $token, 'id' => $user->id]);


                } else

                    return app_response(0, 'error creating user');

            } else {
                return app_response(0, 'SMS is not correct');
            }
        }
    }

    public function send_sms($mobile, $username)
    {
        $sms = rand(1000, 9999);
        $res = Message::create(['mobile' => $mobile, 'username' => $username, 'sms' => $sms]);
        if ($res) {
            return SEND_SMS($mobile, $sms);
        }
    }

    public function get_sms($mobile, $username)
    {
        return Message::where('mobile', $mobile)->where('username', $username)->get(['sms'])->pluck('sms');
    }

    public function following(Request $request)
    {
        $user_id = getUserId($request);

        $page = Input::get('page', '1');
        $value = Cache::remember('following:' . $user_id . ':page=' . $page, 100, function () use ($user_id) {

            $following = Follow::where('user_id', $user_id)->where('accept',1)->get(['follower_id'])->pluck('follower_id');
            $result = User::whereIn('id', $following)
                ->select(['id', 'fullname', 'image_path'])
                ->paginate(12);

            return $result;
        });
        return $value;
    }

    public function follower(Request $request)
    {

        $user_id = getUserId($request);
        $page = Input::get('page', '1');
        $value = Cache::remember('follower:' . $user_id . ':page=' . $page, 100, function () use ($user_id) {
            $follower = Follow::where('follower_id', $user_id)->get(['user_id', 'accept']);
            $result = User::whereIn('id', $follower->pluck('user_id'))
                ->select(['id', 'username', 'fullname', 'image_path', 'last_seen'])
                ->paginate(2);

            $following = Follow::where('user_id', $user_id)->get(['follower_id']);
            $follower_id = $following->pluck('follower_id');


            $result->map(function ($query) use ($follower_id, $follower, $result) {

                $query['accept'] = $follower->pluck('accept', 'user_id')[$query->id];

                if (in_array($query->id, $follower_id->toArray())) {
                    $query['is_follow'] = 1;


                } else {
                    $query['is_follow'] = 0;


                }

                return $query;

            });


            return $result;
        });
        return $value;
    }

    public function follow(Request $request)
    {


        $user_id = getUserId($request);

        $validator = Validator::make($request->all(), [

            'follower_id' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }


        if (is_public($request->follower_id)) {

            $result = Follow::updateOrCreate(['user_id' => $user_id, 'follower_id' => $request->follower_id], ['user_id' => $user_id, 'follower_id' => $request->follower_id, 'accept' => 1]);
            if ($result) {
                Notification::updateOrCreate(['user_id' => $user_id, 'other_user_id' => $request->follower_id], ['user_id' => $user_id, 'other_user_id' => $request->follower_id, 'type' => 0]);
                // type 0 yani user follow shavande public boode va faghat behesh migim ke to ro follow kardan
            }
        } else {

            $result = Follow::updateOrCreate(['user_id' => $user_id, 'follower_id' => $request->follower_id], ['user_id' => $user_id, 'follower_id' => $request->follower_id]);
            if ($result) {
                Notification::updateOrCreate(['user_id' => $user_id, 'other_user_id' => $request->follower_id], ['user_id' => $user_id, 'other_user_id' => $request->follower_id, 'type' => 1]);
                // type 1 yani user follow shavande private boode va user mitoone accept ya reject kone .
            }
        }

        if (!$result) {
            return app_response(0, "error follow");

        }

        $this->delete_cache('*following:' . $user_id . "*");
        $this->delete_cache('*follower:' . $request->follower_id . "*");
        return app_response(1, "following is successfully");

    }

    public function unfollow(Request $request)
    {

        $user_id = getUserId($request);

        $validator = Validator::make($request->all(), [

            'follower_id' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $result = Follow::where(['user_id' => $user_id, 'follower_id' => $request->follower_id])->delete();
        if (!$result) {
            return app_response(0, "error unfollow");

        }
        $this->delete_cache('*following:' . $user_id . "*");
        $this->delete_cache('*follower:' . $request->follower_id . "*");
        return app_response(1, "unfollowing is successfully");

    }

    public function reject_follow(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'follower_id' => 'required',
            'notification_id' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }


        $result = Follow::where(['user_id' => $request->user_id, 'follower_id' => $request->follower_id])->delete();
        if (!$result) {
            return app_response(0, "error reject_follow");

        }

        Notification::where('id', $request->notification_id)->delete();
        return app_response(1, "reject_follow is successfully");

    }

    public function accept_follow(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'notification_id' => 'required',
            'follower_id' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $result = Follow::where(['user_id' => $request->follower_id, 'follower_id' => $request->user_id])->update(['accept' => 1]);
        if (!$result) {


            return app_response(0, "error accept_follow");

        }
        Notification::where('id', $request->notification_id)->update(['read' => 1]);
        Notification::create(['user_id' => $request->user_id, 'other_user_id' => $request->follower_id, 'read' => 0, 'type' => 2]);
        $this->delete_cache('following:' . $request->user_id);
        $this->delete_cache('follower:' . $request->follower_id);

        $this->delete_cache('*following:' . $request->follower_id . "*");
        $this->delete_cache('*follower:' . $request->user_id . "*");
        return app_response(1, "accept_follow is successfully");

    }

    public function message_setting($user_id)
    {
        $value = Cache::remember('message_setting:' . $user_id, 100, function () use ($user_id) {
            return MessageSetting::where('id', $user_id)
                ->first(['receive_news', 'remember_email', 'product_email', 'research_email']);
        });
        return $value;
    }

    public function update_message_setting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'receive_news' => 'int',
            'remember_email' => 'int',
            'product_email' => 'int',
            'research_email' => 'int',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $message = MessageSetting::where('id', $request->user_id)->update($request->all());
            if ($message) {

                $this->delete_cache('*message_setting:' . $request->user_id . "*");
                return app_response(1, 'your setting has updated successfully');
            } else {
                return app_response(0, 'error on setting updated');
            }
        }
    }

    public function user_privacy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'user_privacy' => 'int'
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $user = User::select('is_public')->where('id', $request->user_id)->update(['is_public' => $request->user_privacy]);
            if ($user) {
                return app_response(1, 'your setting has updated successfully');
            } else {
                return app_response(0, 'error on setting updated');
            }
        }
    }

    public function get_privacy(Request $request)
    {

        return User::select('is_public')->find(getUserId($request));

    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'user_id' => 'required',
        ]);


        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        }
        $user_id = $request->user_id;
        $fullname = $request->fullname;

//        $result = Cache::remember('search_users:' . $user_id . ':' . $fullname, 100, function () use ($fullname) {
//
//            return User::where('fullname', 'like', "%" . $fullname . "%")
//                ->select(['id', 'username', 'fullname', 'image_path', 'last_seen'])
//                ->paginate(20);
//        });


        $result = User::where('fullname', 'like', "%" . $fullname . "%")
            ->select(['id', 'username', 'fullname', 'image_path', 'last_seen'])
            ->paginate(20);
        $following = Cache::remember('search_followings:' . $user_id, 100, function () use ($user_id) {

            return Follow::where('user_id', $user_id)->get(['follower_id', 'accept']);
        });

        $follower = Cache::remember('search_followers:' . $user_id, 100, function () use ($user_id) {

            return Follow::where('follower_id', $user_id)->get(['user_id', 'accept']);
        });


        $following_id = $follower->pluck('user_id');
        $follower_id = $following->pluck('follower_id');


        $result->map(function ($query) use ($follower_id, $following_id) {

            //   $query['accept'] = $follower->pluck('accept', 'user_id')[$query->id];

            $query = Cache::remember('search_map:' . $follower_id . ':' . $following_id, 100, function () use ($query, $follower_id, $following_id) {

                if (in_array($query->id, $follower_id->toArray())) {

                    $query['is_follow'] = 1;
                    if (in_array($query->id, $following_id->toArray())) {
                        $query['is_follow'] = 3;
                    }

                } else {
                    if (in_array($query->id, $following_id->toArray()))
                        $query['is_follow'] = 2;
                    else
                        $query['is_follow'] = 0;
                }


                return $query;
            });
            return $query;
        });


        return $result;


//        $result = User::with(['followers' => function ($q) use ($user_id) {
//            return $q->where('user_id', $user_id);
//        }])->where('fullname', 'like', "%" . $request->fullname . "%")
//            ->select(['id', 'username', 'fullname', 'image_path','bio'])
//            ->paginate(20);
//        $result->map(function ($query) use ($user_id) {
//
//
//            if (sizeof($query->followers) > 0) {
//                if ($query->followers['user_id'] = $user_id)
//                    $query['is_follow'] = 1;
//                else
//                    $query['is_follow'] = 0;
//
//            } else {
//                $query['is_follow'] = 0;
//
//            }
//             unset($query->followers);
//            return $query;
//
//        });
//
//        return $result;
    }

    public function change_password(Request $request)
    {

        //  return bcrypt($request->current_password);
        //  password_confirmation
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);

        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {

            $user = User::find($request->user_id);
            if ($user) {
                if (Hash::check($request->current_password, $user->password)) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                    return app_response(1, "password changed successfully");

                }

                return app_response(0, "current_password incorrect");


            }

            return app_response(0, "  UserId does not Exist");


        }

    }

    public function show_field_profile($user_id)
    {
        $result = Cache::remember('show_field_profile:' . $user_id, 100, function () use ($user_id) {
            return User::where('id', $user_id)->first(['fullname', 'username', 'bio', 'image_path', 'mobile', 'email']);
        });
        return $result;
    }

    public function modify_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'fullname' => 'required'
        ]);

        if ($validator->fails()) {
            return app_response(0, '', $validator->errors());
        } else {
            if(isset($request->image)){
            $images = UPLOAD_IMAGE($request, 'image', 'images/users');
            $array = ['fullname' => $request->fullname, 'bio' => $request->bio];
            $array1 = [];
            if (sizeof($images) > 0) {
                $array1 = ['image_path' => $images['image_path'][0]];
            }
            $result = User::where('id', $request->user_id)->update(array_merge($array, $array1));
            }else{
                $array = ['fullname' => $request->fullname, 'bio' => $request->bio];;
                $result = User::where('id', $request->user_id)->update($array);
            }
        }
        if ($result)
            return app_response(1, "Profile changed successfully");
        else
            return app_response(0, "Error Updating  ");
    }


    public function post_star_list(Request $request)
    {


        $user_id = getUserId($request);

        $star = PostStar::where('user_id', $user_id)->where('is_star', 1)->get();

        return Post::whereIn('id', $star->pluck('post_id'))
            ->select(
                'id',
                'caption'

            )
            ->with('image')
            ->paginate(10);

    }

    public function locations_pin(Request $request)
    {
        $user_id = getUserId($request);

        $pin = Cache::remember('locations_pin_pins12345:' . $user_id, 100, function () use ($user_id) {

            return LocationPin::where('user_id', $user_id)->where('is_pin', 1)->get();
        });

        $location = Cache::remember('locations_pin_locations12354:' . $user_id, 100, function () use ($pin) {

            return Location::whereIn('locations.id', $pin->pluck('location_id'))
                ->leftjoin('states', 'locations.state_id', '=', 'states.id')
                ->leftjoin('cities', 'locations.city_id', '=', 'cities.id')
                ->select(
                    'locations.id as id',
                    'locations.name as name',
                    'states.name as state',
                    'cities.name as city'
                )
                ->with('posts.image')
                ->with('image')
                ->paginate(10);
        });

        return $location;
    }

    public function profile(Request $request)
    {

        $user_id = getUserId($request);
        $page = Input::get('page', '1');

        $user = Cache::remember('profile_user:' . $user_id, 100, function () use ($user_id) {
            return User::select('id', 'image_path', 'fullname', 'bio')
                ->where('id', $user_id)
                ->withCount('posts')
                ->first();
        });
        $user['following_count'] = Cache::remember('profile_following_count:' . $user_id, 100, function () use ($user_id) {
            return Follow::where('user_id', $user_id)->where('accept',1)->count();
        });
        $user['follower_count'] = Cache::remember('profile_follower_count:' . $user_id, 100, function () use ($user_id) {
            return Follow::where('follower_id', $user_id)->count();
        });
        $user['notification_count'] = Cache::remember('profile_notification_count:' . $user_id, 100, function () use ($user_id) {
            return Notification::where('other_user_id', $user_id)->where('read', 0)->count();
        });
        $user['post'] = Cache::remember('profile_post:' . $user_id . ":page=" . $page, 100, function () use ($user_id) {
            return Post::where('user_id', $user_id)->select('id')->with('image')->orderBy('id', 'DESC')->paginate(18);
        });


        return $user;
    }

    public function my_notifications(Request $request)
    {
        $user_id = getUserId($request);
        $page = Input::get('page', '1');

        return Cache::remember('my_notifications_:' . $user_id . ":page=" . $page, 100, function () use ($user_id) {

            return Notification::leftjoin('users', 'users.id', '=', 'notifications.user_id')
                ->where('other_user_id', $user_id)
                ->where('read', 0)
                ->paginate(10, ['notifications.id as id', 'image_path', 'fullname', 'user_id']);

        });
    }

    public function get_profile($other_user_id, Request $request)
    {

        $user_id = getUserId($request);


        $user = Cache::remember('get_profile:' . $user_id . ':' . $other_user_id, 100, function () use ($user_id, $other_user_id) {
            return User::select('id', 'image_path', 'fullname', 'bio')
                ->where('id', $other_user_id)
                ->first();
        });

        $check_follow = Follow::where('user_id', $user_id)->where('follower_id', $other_user_id)->first();
//
        $user['follow_status'] = 0;
        if (isset($check_follow)) {
            if ($check_follow->accept == 1) {
                $user['follow_status'] = 2;

            } else {
                $user['follow_status'] = 1;

            }
        }

        $user['following_count'] = Cache::remember('get_profile_following_count:' . $user_id . ':' . $other_user_id, 100, function () use ($user_id, $other_user_id) {
            return Follow::where('user_id', $other_user_id)->count();
        });

        $user['follower_count'] = Cache::remember('get_profile_follower_count:' . $user_id . ':' . $other_user_id, 100, function () use ($user_id, $other_user_id) {
            return Follow::where('follower_id', $other_user_id)->count();
        });

        $following = Cache::remember('get_profile_following:' . $user_id . ':' . $other_user_id, 100, function () use ($user_id, $other_user_id) {
            return Follow::where('user_id', $user_id)
                ->where('follower_id', $other_user_id)
                ->where('accept', 1)
                ->count();
        });

        $user['posts_count'] = Post::where('user_id', $other_user_id)->count();

        if (!is_public($other_user_id)) {

            if ($following) {
                $user['can_visit'] = 1;
                $user['post'] = Post::where('user_id', $other_user_id)->select('id')->with('image')->orderBy('id', 'DESC')->paginate(3);

            } else {
                $user['can_visit'] = 0;
                $user['post'] = null;
            }


        } else {
            $user['can_visit'] = 1;
            $user['post'] = Post::where('user_id', $other_user_id)->select('id')->with('image')->orderBy('id', 'DESC')->paginate(3);

        }


        return $user;
    }

    public function report($user_id)
    {
        return Cache::remember('report:' . $user_id, 100, function () use ($user_id) {

            return Report::where('user_id', $user_id)->paginate(5);
        });
    }

    public function chat_list($user_id)
    {


        $header = Header::where('sender_id', $user_id)->orWhere('receiver_id', $user_id)
            ->with(['sender' => function ($q) {
                return $q->select('id', 'username', 'image_path', 'last_seen');
            }])
            ->with(['receiver' => function ($q) {
                return $q->select('id', 'username', 'image_path', 'last_seen');
            }])
            ->withCount(['messages' => function ($q) use ($user_id) {
                return $q->where('seen', 0)->where('sender_id', '<>', $user_id);
            }])
            ->with(['messages' => function ($q) {
                return $q->select('header_id', 'message')->orderBy('id', 'DESC')->get();
            }])
            ->paginate(20);


        $header->map(function ($query) use ($user_id) {
            $query['last_message'] = $query->messages['message'];

            if ($query->sender_id == $user_id) {

                $query['user'] = $query->receiver;

            } else {
                $query['user'] = $query->sender;

            }


            unset($query->receiver);
            unset($query->sender);
            unset($query->messages);
            return $query;
        });


        return $header;
//        return UserChat::where('header_id', $header->id)->with(['sender' => function ($q) {
//            return $q->select('id', 'username', 'image_path');
//        }])->get();
    }

    public function message_list($header_id = 0, $receiver_id = 0, Request $request)
    {
        $sender_id = getUserId($request);

        if ($header_id == 0) {
            $header = Header::where(['sender_id' => $sender_id, 'receiver_id' => $receiver_id])
                ->orWhere(['receiver_id' => $request->sender_id, 'sender_id' => $receiver_id]
                )->first();
            $count = $header->count();
            if ($count!=0){
                $header_id = $header->id;
            }else{
                return response()->json([
                   'data'=>null,
                   'status'=>'0',
                   'message'=>'شما تاریخچه چت با این کاربر را ندارید'
                ]);
            }
        }

        return UserChat::where('header_id', $header_id)->with(['sender' => function ($q) {
            return $q->select('id', 'username', 'image_path');
        }])->orderBy('id', 'DESC')->paginate(20);


    }

    public function send_message(Request $request)
    {

        $header = Header::where(['sender_id' => $request->sender_id, 'receiver_id' => $request->receiver_id])
            ->orWhere(['receiver_id' => $request->sender_id, 'sender_id' => $request->receiver_id]
            )->first();
        if (!isset($header)) {
            $header = Header::create(['sender_id' => $request->sender_id, 'receiver_id' => $request->receiver_id]);
        }
        $result = UserChat::create([
            'message' => $request->message,
            'header_id' => $header->id,
            'sender_id' => $request->sender_id,
            'seen' => 1,

        ]);

        if ($result)
            return app_response(1, 'Message insert successfully');
        else
            return app_response(0, 'Error insert Message');

    }


}
