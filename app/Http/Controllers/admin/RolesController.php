<?php


namespace App\Http\Controllers\admin;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    private $AllRoles;
    private $permissions;



    public function showNewForm()
    {

        $this->AllRoles = Role::get();
        $this->permissions = Permission::get();
        return view('admin.roles.new_role', array('AllRoles' => $this->AllRoles, 'permissions' => $this->permissions));
    }

    public function createRole(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'label' => 'required']);
        Role::create(['name' => $request['name'], 'label' => $request['label']]);
        flash()->success('Messahe', "Role inserted Successfully");
        return back();
    }

    public function createPermission(Request $request)
    {
        $this > $this->validate($request, ['name1' => 'required', 'label1' => 'required']);
        Permission::create(['name' => $request['name1'], 'label' => $request['label1']]);
        flash()->success('Messahe', "Permission inserted Successfully");
        return back();
    }

    public function showEditRoleForm($id)
    {
        $roles = DB::table('roles')->find($id);


        return view('admin.roles.edit_role', array('roles' => $roles));
    }

    // show edit_permission form
    public function showEditPermissionForm($id)
    {

        $permissions = DB::table('permissions')->find($id);


        return view('admin.roles.edit_permission', array('permissions' => $permissions));
    }

    //edit Permissions table
    public function modifyPermission($id, Request $request)
    {
        Permission::where('id', $id)->update(['name' => $request['name'], 'label' => $request['label']]);
        flash()->success('Message', 'Permission update successfully');

        return redirect(route('new_role'));
    }

    //delete role_permission table
    public function deletePermission($id)
    {

        $permission = Permission::find($id);
        $permission->delete();
        return back();
// Detach all roles from the user...
        //  $user->permissions()->detach();
    }

    // delete user_role table
    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();

// Detach all roles from the user...

        flash()->success("Message", "Permission Delete Successfully");
        return back();
    }

    //edit Roles table
    public function modifyRole($id, Request $request)
    {
        Role::where('id', $id)->update(['name' => $request['name'], 'label' => $request['label']]);
        flash()->success('Message', 'Role update successfully');
        return redirect(route('new_role'));
    }


    // show permission role table
    public function setPermissionForm()
    {
        $this->AllRoles = Role::with('permissions')->get();
          $AllPermissions=  Permission::get();
        return view('admin.roles.setPermission', array('AllRoles' => $this->AllRoles,'AllPermissions'=>$AllPermissions, 'permissions' => $this->permissions));

    }

    public function getAjaxPermission($role_id)
    {

      return  $this->permissions =  Permission::whereHas('roles',function ($query) use ($role_id){$query->where('roles.id',$role_id);})->get();
    }

// update permission_role table
    public function modifyPermissionRole(Request $request)
    {
        $this->validate($request, ['role' => 'required', 'permission' => 'required']);
        $role = new Role;
        $role->id = $request['role'];
        $role->permissions()->sync($request['permission']);
        flash()->success("Message", "Permission set Successfully");
        return back();
    }
}
