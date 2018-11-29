<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(UsersSeeder::class);
   //      $this->call(LocationSeeder::class);
 //   $this->call(PostSeeder::class);
    //   $this->call(LocationImageSeeder::class);
  //  $this->call(PostImageSeeder::class);


//        factory(\App\LocationLike::class,3000)->create();
//        factory(\App\LocationPin::class,3000)->create();
//      factory(\App\LocationRate::class,3000)->create();
//
//      factory(\App\PostView::class,3000)->create();
//      factory(\App\PostStar::class,3000)->create();
//        factory(\App\PostRate::class,3000)->create();
//        factory(\App\PostLike::class,3000)->create();
    }
}
