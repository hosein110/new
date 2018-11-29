<?php

namespace App\Http\Controllers\admin;

use App\Comment;
use App\Permission;
use App\Report;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{

    public function getLogout()
    {
          Auth::logout();

          return back();

    }

    public function showProfile()
    {


        $users = User::find(auth()->id());
        return view('admin.users.profile', compact('users'));
    }

    public function modifyProfile(Request $request)
    {

        $array = ['fullname' => $request->fullname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'language' => $request->language,

        ];
        $array1 = [];
        if ($request->file('file')) {
            //   delete_file(base_path() . '/public' . $request->profile_img);
            $IMGpath = '/uploads/images/users';
            $imageName = str_random(10) . "_" . $request->file('file')->getClientOriginalName();
            $path = base_path() . '/public' . $IMGpath;
            $request->file('file')->move($path, $imageName);
            $array1 = ['image_path' => $IMGpath . "/" . $imageName];
        }


        User::where("id", auth()->id())->update(array_merge($array, $array1));
        flash()->success('Message', 'Your Profile changed successfully');
        return back();

    }


    public function modifyUser($id, Request $request)
    {
        $this->validate($request, ['fullname' => 'required', 'email' => 'required']);


        $user = User::find($id);
        $user->roles()->sync($request->roles);
        flash()->success("Message", "Permission set Successfully");
        return back();
    }


    public function showUserForm()
    {

        $AllRoles = Role::get();
        return view('admin.users.new_user', compact('AllRoles'));
    }


    public function editForm($id)
    {

        $users = User::with('roles.permissions')->find($id);
        $AllRoles = Role::with('permissions')->get();
        $AllPermissions = DB::table('permissions')->get();

        //$users = DB::table('users')->find($id);
        return view('admin.users.edit_user', compact('users', 'AllRoles', 'AllPermissions'));
    }

    public function showUsersList()
    {

        $keyword = Input::get('keyword', '');
//        $users = User::SearchByKeyword($keyword)->get();
//

        $users = User::SearchByKeyword($keyword)->with('roles.permissions')->orderBy('users.id', 'desc')->where('users.is_administrator', 1)->paginate(20);
        return view('admin.users.users_list', compact('users'));
    }


    protected function save(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|min:10',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);


        $user = User::create(
            [
                'fullname' => $request->name,
                'email' => $request->email,
                'username' => rand(100000,99999999),
                'mobile' => $request->mobile,
                'is_administrator' => 1,

                'password' => bcrypt($request->password)

            ]
        );


        $users = new User();
        $users->id = $user->id;

        $users->roles()->sync([$request->role]);


        if ($user) {
            flash()->success("TITLE", "User Created Successfully");
        } else {
            flash()->error("error", "   error !! user dose not created  ");
        }
        return back();
    }

    public function app_report_list()
    {
        $reports= Report::with(['user'=>function($q){
          return $q->select('id','fullname','email','mobile');
      }])
          ->paginate(12);
       return view('admin.users.app_report_list',compact('reports'));
    }

}
