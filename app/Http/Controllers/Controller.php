<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function delete_cache($cacheKey)
    {
        $redis = Cache::getRedis();
           $a_keys = $redis->keys($cacheKey);

        if ($a_keys != null) {
            for ($i = 0; $i < sizeof($a_keys); $i++) {
                \Redis::del($a_keys[$i]);
            }
        }
    }





}
