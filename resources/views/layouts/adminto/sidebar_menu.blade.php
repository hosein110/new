<div class="modal fade bs-example-modal-sm"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style=" top:30%;display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="mySmallModalLabel"> خروج </h4>
            </div>
            <div class="modal-body">
                <a href="{{url('logout')}}"><i class="fa fa-book"></i>
                    <span>    {{trans('admin_panel.logout')}}</span></a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="user-box">

        <img src="{{url(auth()->user()->image_path)}}" alt="user-img" title="{{auth()->user()->fullname}}"
             class="img-circle img-thumbnail img-responsive " width="60px">
        <div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>

    <h5><a href="#">{{auth()->user()->fullname}}</a><br/><a href="#">{{auth()->user()->email}}</a> </h5>
    <ul class="list-inline">


        <li>
            <a href="{{asset('admin/user/profile')}}">
                <i class="zmdi zmdi-edit"></i>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="zmdi zmdi-settings"></i>
            </a>
        </li>


            <a  href="{{route('getLogout')}}"  > <i class="zmdi zmdi-power"></i> </a>


    </ul>
</div>
<div id="sidebar-menu">
    <ul>

        @can('dashboard')
        <li>
            <a href="{{url('admin/home')}}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span> {{trans('admin_panel.dashboard')}} </span>
            </a>
        </li>
        @endcan



        @can('analyzes')
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="zfa fa-location-arrow"></i> <span class="menu-arrow"></span><span>  آنالیز سایت </span> </a>
                <ul class="list-unstyled">
                    <li>  <a href="{{url('admin/home/analyzes')}}" class="waves-effect">  <span> نمودار ها</span>  </a>   </li>
                    <li>  <a href="{{url('admin/home/analyzes_keywords')}}" class="waves-effect">  <span>  کلمات کلیدی </span>  </a>   </li>
                    <li>  <a href="{{url('admin/home/analyzes_links')}}" class="waves-effect">  <span> لینک ها</span>  </a>   </li>



                </ul>
            </li>
        @endcan


        @can('location_list')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="zfa fa-location-arrow"></i> <span class="menu-arrow"></span><span>  مکانها </span> </a>
            <ul class="list-unstyled">
                <li><a href="{{route('create_location')}}">  جدید </a></li>
                <li><a href="{{route('admin_location_list',['type'=>'all'])}}">  لیست همه مکانها</a></li>
                <li><a href="{{route('admin_location_list',['type'=>'confirm'])}}">     تایید شده</a></li>
                <li><a href="{{route('admin_location_list',['type'=>'not_verified'])}}">     تایید نشده</a></li>
                <li><a href="{{route('admin_location_list',['type'=>'report'])}}">     گزارشات</a></li>

            </ul>
        </li>
        @endcan

        @can('post_list')
        <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="zmdi zmdi-collection-text"></i> <span class="menu-arrow"></span><span>  پست ها </span> </a>
            <ul class="list-unstyled">
              <li><a href="{{route('admin_post_list',['type'=>'report'])}}"> گزارش </a></li>

            </ul>
        </li>
        @endcan

        @can('users_list')
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i>
                    <span> {{trans('admin_panel.users')}}</span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{url('admin/user/new_user')}}">{{trans('admin_panel.new_user')}}</a></li>
                    <li><a href="{{url('admin/user/users_list')}}">{{trans('admin_panel.users_list')}}</a></li>
                    <li><a href="{{url('admin/user/app_report_list')}}">app_report_list</a></li>
                    </li>


                </ul>
            </li>
        @endcan

        @can('roles')
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user"></i><span
                            class="label label-warning pull-right">7</span><span>  {{trans('admin_panel.roles')}}</span> </a>
                <ul class="list-unstyled">
                    <li><a href="{{url(route('new_role'))}}">{{trans('admin_panel.new_role')}}</a></li>
                    <li><a href="{{url(route('setPermission'))}}">{{trans('admin_panel.set_permission')}}</a></li>

                </ul>
            </li>
        @endcan


        @can('categories')
            <li>
                <a href="{{url('admin/categories/list')}}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i> <span> {{trans('admin_panel.categories')}} </span>
                </a>
            </li>
        @endcan




    </ul>
    <div class="clearfix"></div>
</div>