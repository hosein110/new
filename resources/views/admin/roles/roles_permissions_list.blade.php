{{--<div class="row">--}}
    {{--<div class="list-group col-md-4 col-md-offset-3">--}}

        {{--@foreach($AllRoles as $role)--}}

            {{--<a href="#" class="list-group-item active"> {{$role->name}}</a>--}}
            {{--@foreach($role->permissions as $permission)--}}

                {{--<a href="#" class="list-group-item "> {{$permission->name}}</a>--}}


            {{--@endforeach--}}

        {{--@endforeach--}}

    {{--</div>--}}
{{--</div>--}}


<div class="row">

    <div class="col-md-5 col-md-offset-0">
    <ul class="list-group  ">
        <a href="#" class="list-group-item active"> Roles</a>

        @foreach($AllRoles as $role)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                  {{$role->label}}<br>{{$role->name}}

                <span class="badge badge-primary badge-pill btn btn-danger btn-sm "> <a  class="text text-white" href="{{route('deleteRole',['id'=>$role->id])}}"   >حذف</a></span>
                <span class="badge badge-primary badge-pill btn btn-info btn-sm "> <a class="text text-white" href="{{route('edit_role',['id'=>$role->id])}}"    >ویرایش</a></span>

            </li>

        @endforeach

    </ul>

</div>
<div class="col-md-5 col-md-offset-0">
    <ul class="list-group">
        <a href="#" class="list-group-item active"> Permissions</a>
        @foreach($permissions as $permission)







                <li class="list-group-item d-flex justify-content-between align-items-center">
                {{$permission->label}}<br>{{$permission->name}}
                    <span class="badge badge-primary badge-pill btn btn-danger btn-sm "><a class="text text-white" href="{{route('deletePermission',['id'=>$permission->id])}}"   >حذف</a></span>
                    <span class="badge badge-primary badge-pill btn btn-info btn-sm"><a   class="text text-white" href="{{route('edit_permission',['id'=>$permission->id])}}"    >ویرایش</a></span>
                </li>



        @endforeach
    </ul>

    </div>
</div>
</div>


