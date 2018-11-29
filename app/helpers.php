<?php

use App\Http\Roles;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Redis;


use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\File;


use Intervention\Image\ImageManagerStatic as Image;


function getUsers($request)
{
    $token = $request->header('Authorization');
    return JWTAuth::toUser(str_replace('Bearer ', '', $token));

}

function getUserId($request)
{
    return getUsers($request)->id;
}





function UPLOAD_IMAGE($request, $target, $store_path = 'images', $watermark_path = '', $resizePercentage = 80, $position = 'bottom-left', $resize_percent = 0, $quality = 100)
{

    $i = 0;

    if ($request->hasFile($target)) {
        if (gettype($request->file($target)) == 'object') {
            $images[] = $request->file($target);
        } else {
            $images = $request->file($target);
        }

        foreach ($images as $image) {


            //  $image = $request->file($target);
            $name = $image->getClientOriginalName();
            $rand = str_random(10) . "_";
            $image->move(public_path() . '/' . $store_path . '/', $rand . $name);
            $result['image_path'][$i] = $store_path . '/' . $rand . $name;

            $result['watermark_path'][$i] = '';
            if ($watermark_path != '') {
                $img1 = $img = Image::make(public_path($result['image_path'][$i]));


                $watermark = Image::make(public_path($watermark_path));
//                $watermarkSize = $img->width() - 200; //size of the image minus 20 margins
//                $watermarkSize = $img->width() / 2; //half of the image size
                $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2); //watermark will be $resizePercentage less then the actual width of the image
                $watermark->resize($watermarkSize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->insert($watermark, $position);


                $img->save(public_path() . '/' . $store_path . '/' . $rand . '_watermark_' . $name, $quality);
                $result['watermark_path'][$i] = $store_path . '/' . $rand . '_watermark_' . $name;


                $width = $img1->getWidth() - $img1->getWidth() * $resize_percent / 100;
                $height = $img1->getHeight() - $img1->getHeight() * $resize_percent / 100;
                $img1->resize($width, $height);
                $img1->save(public_path() . '/' . $store_path . '/' . $rand . '_resize_' . $name);
                $result['resize_path'][$i] = $store_path . '/' . $rand . '_resize_' . $name;
            }

            $i++;

        }
        return $result;

    }

    return false;
}



function getOS()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];


    $os_platform = "Unknown OS Platform";

    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }

    }

    return $os_platform;

}

function getBrowser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];


    $browser = "Unknown Browser";

    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }

    }

    return $browser;

}

function getKeyword($url)
{
    $url = urldecode($url);
    $variable = substr($url, 0, strpos($url, "&oq="));
    $whatIWant = substr($variable, strpos($variable, "&q=") + 3);
    return str_replace('+', ' ', $whatIWant);
}

function KKK()
{

    $from_url = @$_SERVER[HTTP_REFERER];

    // $from_url="https://www.google.com/search?num=100&rlz=1C5CHFA_enIR810IR810&biw=1280&bih=690&ei=Gfy5W5y5FcOzwATUiLgY&q=%D8%A2%DB%8C%D8%A7+%D9%85%D9%86%D8%B8%D9%88%D8%B1+%D8%B4%D9%85%D8%A7+%D8%A7%DB%8C%D9%86+&oq=%D8%A2%DB%8C%D8%A7+%D9%85%D9%86%D8%B8%D9%88%D8%B1+%D8%B4%D9%85%D8%A7+%D8%A7%DB%8C%D9%86+&gs_l=psy-ab.3...150380.150380.0.150771.0.0.0.0.0.0.0.0..0.0....0...1c.1.64.psy-ab..0.0.0....0.jI1mJCuozAY";

    $keyword = getKeyword($from_url);

    $this_url = $_SERVER['REQUEST_URI'];
    $domain = $_SERVER['SERVER_NAME'];
    $now = Carbon::now();
    DB::table('analyzes')->insert(
        [
            'from_url' => $from_url,
            'this_url' => $this_url,
            'ip' => getIP(),
            'os' => getOS(),
            'browser' => getBrowser(),
            'domain' => $domain,
            'keyword' => $keyword,
            'created_at' => $now,
        ]
    );
}

function getIP()
{

    $tmp = getenv("HTTP_CLIENT_IP");

    if ($tmp && !strcasecmp($tmp, "unknown"))
        return $tmp;

    $tmp = getenv("HTTP_X_FORWARDED_FOR");
    if ($tmp && !strcasecmp($tmp, "unknown"))
        return $tmp;


    $tmp = getenv("REMOTE_ADDR");
    return $tmp;


}


function CheckHasRedis($key)
{
    if (Redis::exists($key)) {
        $response = json_decode(Redis::get($key), true);

        return $response;
    }

}

function enToAr($string)
{
    return strtr($string, array('0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'));
}

function is_public($user_id)
{
    $user = User::where('id', $user_id)->first(['is_public']);
    return $user->is_public;
}

function LastSeen($request)
{
    $user = JWTAuth::toUser(str_replace('Bearer ', '', $request->headers->get('Authorization')));
    $value = Carbon::now();
    User::where('id', '=', $user->id)->update(['last_seen' => $value]);

    //Redis::set('last_seen_'.$user->id,$value);

// echo \Redis::get('last_seen_'.$user->id);
    // echo $user->id;

}

function flash($title = null, $message = null)
{

    $flash = app('App\Http\Flash');
    if (func_num_args() == 0) {
        return $flash;
    }
    return $flash->info($title, $message);
}

function SEND_SMS($mobile, $message)
{
    // require __DIR__ . '/vendor/autoload.php';

    require __DIR__ . '/../vendor/autoload.php';

    try {
        $api = new \Kavenegar\KavenegarApi("467A4C444D706362632F317451375756696F36635475674835303649784A6162");
        $sender = "10004346";

        $receptor = array($mobile);
        $result = $api->Send($sender, $receptor, $message);
        return $result;
//        if($result){
//            foreach($result as $r){
//                echo "messageid = $r->messageid";
//                echo "message = $r->message";
//                echo "status = $r->status";
//                echo "statustext = $r->statustext";
//                echo "sender = $r->sender";
//                echo "receptor = $r->receptor";
//                echo "date = $r->date";
//                echo "cost = $r->cost";
//            }
//        }
    } catch (\Kavenegar\Exceptions\ApiException $e) {
        // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
        $e->errorMessage();
    } catch (\Kavenegar\Exceptions\HttpException $e) {
        // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
        $e->errorMessage();
    }
}


function app_response($status, $message, $error = ['b' => ''], $data = ['a' => ''])

{

    return response()->json(['status' => $status, 'message' => $message, 'error' => $error, 'data' => $data]);
}


function remove_element(&$array, $value)
{
    if (($key = array_search($value, $array)) !== false) {
        unset($array[$key]);
    }
}