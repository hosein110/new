@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>  گزارشات کاربران اپلیکیشن </title>

@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">


                <div class="table-rep-plugin">
                    <div class="table-wrapper">
                        <div class="btn-toolbar">
                            <div class="btn-group focus-btn-group">

                            </div>
                            <div class="btn-group dropdown-btn-group pull-right">
                                <form method="get" action="" class="input-group" style="width: 250px;">

                                    <input type="text" name="keyword" class="form-control input-sm pull-right"
                                           placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-default"><i
                                                    class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" data-pattern="priority-columns">

                            <table id="tech-companies-1" class="table  table-striped">
                                <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>User Info</th>
                                    <th>version_app</th>
                                    <th>department</th>
                                    <th>Time</th>

                                    {{--<th>Managment</th>--}}

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{$report->id}}</td>
                                        <td>

                                            {{$report->user->id}}<br>
                                            {{$report->user->fullname}}<br>
                                            {{$report->user->email}}<br>
                                            {{$report->user->mobile}}<br>

                                        </td>
                                        <td>{{$report->version_app}}</td>
                                        <td>{{$report->department}}</td>
                                        <td>{{$report->created_at}}</td>




                                        <td>
                                            {{--<a href="{{route('active_user',['id'=>$user->id,'status'=>$user->status])}}"> {{active($user->status)}}</a>--}}
                                            {{--<a href="{{route('edit_user_form',['id'=>$report->id])}}"><span class="btn btn-info btn-xs >"> edit</span></a>--}}

                                        </td>
                                    </tr>


                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>





        {{$reports->appends($_GET)->links()}}
    </div>
@stop