<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\City;
use App\Location;
use App\LocationImage;
use App\LocationInfo;
use App\LocationReport;
use App\Possibility;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function delete($id,$type)
    {
        $res = Location::find($id)->delete();
        if ($res) {
            flash()->success('message', 'DELETE SuccessFULLY');
            return redirect(route('admin_location_list', ['type' => $type]));
        }
        else{
            flash()->error('message', '  ERROR');
            return back();
        }
    }

    public function admin_confirm_location($id,$type)
    {
        $res = Location::where('id',$id)->update(['is_confirm'=>1]);
        if ($res) {
            flash()->success('message', 'DELETE SuccessFULLY');
            return redirect(route('admin_location_list', ['type' =>$type]));
        }
        else{
            flash()->error('message', '  ERROR');
            return back();
        }
    }

    public function location_report_not_correct($id,$type)
    {
         $res = LocationReport::where('location_id',$id)->delete();
        if ($res) {
            flash()->success('message', 'DELETE SuccessFULLY');
            return redirect(route('admin_location_list', ['type' => $type]));
        }
        else{
            flash()->error('message', '  ERROR');
            return back();
        }
    }

    public function image_delete($id)
    {
     $res=  LocationImage::where('id',$id)->delete();
      if($res)
      {
          return app_response(1,'OK');
      }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = "all")
    {

        $state_id = Input::get('state', '');
        $category_id = Input::get('category', '');

        $categories = Category::where('type', 0)->get();
        $states = State::get();

        $locations = Location::leftjoin('location_reports', 'location_reports.location_id', '=', 'locations.id')
            ->where(function ($q) use ($state_id, $category_id) {
                if ($state_id != "")
                    $q->where('state_id', $state_id);
                if ($category_id != "")
                    $q->where('category_id', $category_id);
                return $q;
            })
            ->select([
                'locations.name as name',
                'locations.id as id',
                DB::raw('count(location_reports.id) as reports_count')
            ])
            ->where(function ($q) use ($type) {
                if ($type == "report")
                    return $q->has('reports');
                elseif ($type == "confirm")
                    return $q->where('is_confirm', 1);
                elseif ($type == "not_verified")
                    return $q->where('is_confirm', 0);
                else
                    return $q;
            })
            ->with('image')
            ->orderBy('locations.id', 'DESC')
            ->orderBy('reports_count', 'DESC')
            ->groupBy('locations.id')
            ->paginate(12);
        return view('admin.locations.list', compact('locations', 'categories', 'states', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = State::all()->pluck('name', 'id');
        $city = City::all()->pluck('name', 'id');
        $transfers = Possibility::where('type', 0)->get();
        $environments = Possibility::where('type', 1)->get();
        $categories = Category::where('type', 1)->get();
        return view('admin.locations.create', compact('state', 'city', 'transfers', 'environments', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'lat' => 'required',
            'longitude' => 'required',
            'category_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'price' => 'required',
            'tel' => 'required',
            'name' => 'required',
            'images' => 'required'

        ]);
        $result = Location::create(
            [
                'is_confirm' => 1,
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'lat' => $request->lat,
                'longitude' => $request->longitude,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'price' => $request->price,
                'tel' => $request->tel,
                'slug' => str_random(15),


            ]
        );
        if (!$result) {
            return app_response('0', 'error');
        }
        if ($request->hasfile('images')) {
            $count = 0;
            foreach ($request->file('images') as $image) {
                $count++;
                $name = $image->getClientOriginalName();
                $rand = str_random(10) . "_";
                $image->move(public_path() . '/images/location/', $rand . $name);
                $image_path = '/images/location/' . $rand . $name;


                LocationImage::Create([
                    'location_id' => $result->id,
                    'image_path' => $image_path,
                    'sort' => $count
                ]);

            }
        }



        $Possibility=array();
        if($request->environment && $request->transfer){
            $Possibility =  array_merge($request->environment,$request->transfer);
        }
        elseif ($request->environment){
            $Possibility = $request->environment;
        }
        elseif ($request->transfer){
            $Possibility = $request->transfer;
        }
        if (sizeof($Possibility)>0){

            $result->possibilities()->attach($Possibility);


        }




        for ($i = 0; $i < 5; $i++) {
            if ($request->title[$i] != null && $request->description[$i] != null)
                LocationInfo::create([
                    'location_id' => $result->id,
                    'title' => $request->title[$i],
                    'description' => $request->description[$i]
                ]);
        }
        flash()->success('message', 'add location successfully');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

  public function edit($id,$type)
    {
    $state = State::all()->pluck('name', 'id');

    $transfers = Possibility::where('type', 0)->get();
    $environments = Possibility::where('type', 1)->get();
    $categories = Category::where('type', 0)->get();
      $location = Location::withCount('reports')->where('id',$id)->first();

    $city = City::all()->where('state_id',$location->state_id)->pluck('name', 'id');

    $location_transfers = array();
    $location_environments = array();
    foreach ($location->possibilities->where('type',1) as $loc_pos){
    array_push($location_environments,$loc_pos->id);
    }
    foreach ($location->possibilities->where('type',0) as $loc_pos){
    array_push($location_transfers,$loc_pos->id);
    }
    return view('admin.locations.edit',compact('state','city','categories','transfers','location','environments','location_environments','location_transfers','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'lat' => 'required',
            'longitude' => 'required',
            'category_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'price' => 'required',
            'tel' => 'required',
            'name' => 'required'

        ]);
        $result = Location::where('id',$id)->update(
            [
                'is_confirm' => 1,
                'name' => $request->name,
                'lat' => $request->lat,
                'longitude' => $request->longitude,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'price' => $request->price,
                'tel' => $request->tel,

            ]
        );
        $location = Location::where('id',$id)->first();
        if (!$result) {
            return app_response('0', 'error');
        }
        if ($request->hasfile('images')) {
            $count = 0;
            foreach ($request->file('images') as $image) {
                $count++;
                $name = $image->getClientOriginalName();
                $rand = str_random(10) . "_";
                $image->move(public_path() . '/images/location/', $rand . $name);
                $image_path = '/images/location/' . $rand . $name;

                LocationImage::Create([
                    'location_id' => $location->id,
                    'image_path' => $image_path,
                    'sort' => $count
                ]);
            }
        }

      // return array_merge($request->environment, $request->transfer);

        $Possibility=array();
           if($request->environment && $request->transfer){
               $Possibility =  array_merge($request->environment,$request->transfer);
               }
               elseif ($request->environment){
                   $Possibility = $request->environment;
               }
               elseif ($request->transfer){
                   $Possibility = $request->transfer;
               }
           if (sizeof($Possibility)>0){
               $location->possibilities()->sync($Possibility);
           }
           else
           {
               $location->possibilities()->detach();
           }


        LocationInfo::where('location_id',$id)->delete();
       for ($i = 0; $i < 5; $i++) {
            if ($request->title[$i] != null && $request->description[$i] != null)

                LocationInfo::create([
                     'location_id'=>$id,
                    'title' => $request->title[$i],
                    'description' => $request->description[$i]
                ]);
        }

        LocationReport::where('location_id',$id)->delete();
        flash()->success('message', 'location updated successfully');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCity($id)
    {
        $city = City::where('state_id', $id)->get();
        return json_encode($city);
    }

    public function category(Request$request){

        return view('/');
    }
}
