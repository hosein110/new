<?php

namespace App\Http\Controllers\admin;



use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
    public function index()
    {
        $target = Input::get('target', '');
        $categories = Category::where(function ($q) use ($target) {
                if ($target != "")
                    $q->where('type', $target);
                return $q;
            })
            ->select(['title','id','image_path','type'])
            ->orderBy('id', 'DESC')
            ->groupBy('id')
            ->paginate(12);

        return view('admin.categories.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
      //
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
            'title' => 'required',
            'type' => 'required',
            'image_path' => 'required',
        ]);
        $name = $request->image_path->getClientOriginalName();
        $rand = str_random(10) . "_";
        $request->image_path->move(public_path() . '/images/categories/', $rand . $name);
        $image_path = '/images/categories/' . $rand . $name;
        $result = Category::create(
            [
                'title' => $request->title,
                'type' => $request->type,
                'image_path' => $image_path,
                'status' => 1
            ]
        );
        if (!$result) {
            return app_response('0', 'error');
        }
        flash()->success('message', 'add category successfully');
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

    public function sub_category_list($category)
    {
        $sub_categories = DB::table('sub_categories')->where('category_id',$category)->get();

        return view('admin.categories.sub_category',compact('sub_categories','category'));
    }

    public function sub_category_store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'image_path' => 'required',
            'category_id' => 'required'
        ]);
        $name = $request->image_path->getClientOriginalName();
        $rand = str_random(10) . "_";
        $request->image_path->move(public_path() . '/images/categories/', $rand . $name);
        $image_path = '/images/categories/' . $rand . $name;
        $result = DB::table('sub_categories')->insert(
            [
                'title' => $request->title,
                'type' => 0,
                'image_path' => $image_path,
                'category_id' => $request->category_id,
                'status' => 1
            ]
        );
        if (!$result) {
            return app_response('0', 'error');
        }
        flash()->success('message', 'دسته بندی با موفقیت ثبت شد');
        return back();
    }
    public function sub_categories_edit(Request $request)
    {
        $data = $request->all();
        $result = DB::table('sub_categories')->where('id',$data['id'])->update(
            [
                'title' => $data['title'],
                'status' => $data['status'],
            ]
        );
        if (!$result) {
            return app_response('0', 'error');
        }
        return $result;
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
}
