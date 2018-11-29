<?php


Route::namespace('Application')->group(function () {

    Route::group(['middleware' => 'web'], function () {

    });



    Route::get('/application/sit_home_page/{category_id?}', 'ApplicationController@sit_home_page')->name('sit_home_page');


    Route::post('/app_first_check_register', 'UserController@app_first_check_register')->name('app_first_check_register');
    Route::post('/app_second_check_register', 'UserController@app_second_check_register')->name('app_second_check_register');
    Route::post('/app_final_register', 'UserController@app_final_register')->name('app_final_register');
    Route::post('/login', 'UserController@app_login')->name('app_login');


    Route::post('/recover_password', 'UserController@recover_password')->name('recover_password');
    Route::post('/reset_password', 'UserController@reset_password')->name('reset_password');
    Route::post('/check_sms_verify', 'UserController@check_sms_verify')->name('check_sms_verify');


    Route::group(['middleware' => 'jwt.auth'], function () {


     //   Route::post('/test', 'UserController@test')->name('test');


        Route::group(['prefix' => '/application'], function () {

            Route::get('/{type}/possibilities', 'ApplicationController@possibilities')->name('possibilities');
            Route::post('/app_report', 'ApplicationController@app_report')->name('app_report');

            Route::get('/state_location_list', 'ApplicationController@state_location_list')->name('state_location_list');


            Route::get('/all_state_list', 'ApplicationController@all_state_list')->name('all_state_list');
            Route::get('/all_city_list/{state_id}', 'ApplicationController@all_city_list')->name('all_city_list');


        });
        Route::group(['prefix' => '/category'], function () {


            Route::get('/select_sub_category/{category_id}', 'CategoryController@select_sub_category')->name('select_sub_category');

            Route::get('/select_category/{type}/{hasWith}', 'CategoryController@select_category')->name('select_category');
            Route::get('/categories_posts/', 'CategoryController@categories_posts')->name('categories_posts');

        });
        Route::group(['prefix' => '/user'], function () {
            Route::get('/locations_pin', 'UserController@locations_pin')->name('locations_pin');
            Route::get('/post_star_list', 'UserController@post_star_list')->name('post_star_list');
            Route::get('/app_logout', 'UserController@app_logout')->name('app_logout');
            Route::get('/refresh_token', 'UserController@refresh_token')->name('refresh_token');


            Route::get('/get_privacy', 'UserController@get_privacy')->name('get_privacy');


            Route::post('/message_setting/update', 'UserController@update_message_setting')->name('update_message_setting');
            Route::post('/privacy', 'UserController@user_privacy')->name('user_privacy');


            // post user id for this request and

            Route::get('/message_setting/{user_id}', 'UserController@message_setting')->name('message_setting');
            Route::post('/message_setting/update', 'UserController@update_message_setting')->name('update_message_setting');
            Route::post('/privacy', 'UserController@user_privacy')->name('user_privacy');
            Route::get('/follower', 'UserController@follower')->name('follower');
            Route::get('/following', 'UserController@following')->name('following');

            Route::post('/follow', 'UserController@follow')->name('follow');
            Route::post('/unfollow', 'UserController@unfollow')->name('unfollow');
            Route::post('/reject_follow', 'UserController@reject_follow')->name('reject_follow');
            Route::post('/accept_follow', 'UserController@accept_follow')->name('accept_follow');


            Route::get('/report/{user_id}', 'UserController@report')->name('report');

            Route::post('/search', 'UserController@search')->name('search');
            Route::post('/change_password', 'UserController@change_password')->name('change_password');

            Route::get('/show_field_profile/{user_id}', 'UserController@show_field_profile')->name('show_field_profile');
            Route::get('/profile', 'UserController@profile')->name('profile');
            Route::get('/my_notifications', 'UserController@my_notifications')->name('my_notifications');

            Route::post('/modify_profile', 'UserController@modify_profile')->name('modify_profile');
            Route::get('/get_profile/{other_user_id}', 'UserController@get_profile')->name('get_profile');


            Route::get('/message_list/{header_id}/{receiver_id}', 'UserController@message_list')->name('message_list');
            Route::get('/chat_list/{user_id}', 'UserController@chat_list')->name('chat_list');
            Route::post('/send_message', 'UserController@send_message')->name('send_message');





        });
        Route::group(['prefix' => '/posts'], function () {
            //location like


            Route::get('/home_page/{user_id}', 'PostController@home_page')->name('home_page');


            Route::get('/list/{location_id}', 'PostController@post_list')->name('post_list');
            Route::get('/related_post/{location_id}', 'PostController@related_post')->name('related_post');

            Route::post('/add', 'PostController@post_add')->name('post_add');
            Route::post('/like', 'PostController@post_like')->name('post_like');
            Route::post('/star', 'PostController@post_star')->name('post_star');

            Route::post('/wish_list', 'PostController@post_wish_list')->name('post_wish_list');

            Route::post('/rate', 'PostController@post_rate')->name('post_rate');
            Route::get('/{user_id}/{post_id}/show', 'PostController@post_show')->name('post_show');
            Route::get('/{post_id}/show/price', 'PostController@post_price_show')->name('post_price_show');


            Route::get('/{post_id}/comments', 'PostController@post_comment')->name('post_comment');
            Route::post('/comments/add', 'PostController@post_comment_add')->name('post_comment_add');
            Route::post('/comments/update', 'PostController@post_comment_update')->name('post_comment_update');
            Route::post('/comments/reply', 'PostController@post_comment_replay')->name('post_comment_replay');

            Route::post('/report', 'PostController@post_report')->name('post_report');

        });
        Route::group(['prefix' => '/locations'], function () {

            Route::get('/list/{user_id}', 'LocationController@location_list')->name('location_list');
            Route::post('/add', 'LocationController@location_add')->name('location_add');
            Route::get('/{user_id}/{location_id}/show', 'LocationController@location_show')->name('location_show');
            //location image
            Route::get('/{user_id}/{location_id}/image', 'LocationController@location_images')->name('location_image');
            //location comments
            Route::get('/{location_id}/comments', 'LocationController@location_comment')->name('location_comment');
            Route::post('/comments/add', 'LocationController@location_comment_add')->name('location_comment_add');
            Route::post('/comments/update', 'LocationController@location_comment_update')->name('location_comment_update');
            Route::post('/comments/reply', 'LocationController@location_comment_replay')->name('location_comment_replay');
            //location like
            Route::post('/like', 'LocationController@location_like')->name('location_like');
            //location rate
            Route::post('/rate', 'LocationController@location_rate')->name('location_rate');
            //location pin
            Route::post('/pin', 'LocationController@location_pin')->name('location_pin');


            Route::get('/{user_id}/{location_id}/possibility', 'LocationController@location_possibility')->name('location_possibility');
            //location info
            Route::get('/{user_id}/{location_id}/info', 'LocationController@location_info')->name('location_info');
            //location report
            Route::post('/report', 'LocationController@location_report')->name('location_report');

            //location location_categories
            Route::get('/location_categories', 'LocationController@location_categories')->name('location_categories');

            Route::get('/search/{location_name}', 'LocationController@location_search')->name('location_search');
            Route::post('/update', 'LocationController@location_update')->name('location_update');

        });


    });


});