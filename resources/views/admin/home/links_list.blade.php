@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title> links list </title>

@endsection
@section('content')
<?php
$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
$date=isset($_GET['date'])?$_GET['date']:'all';


?>
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

                                    <input type="text" name="keyword" class="form-control input-sm pull-right" value="{{$keyword}}"
                                           placeholder="Search">

                                    <select type="text" name="date" class="form-control input-sm pull-right"  >
                                        <option id="all" value="">کل </option>
                                        <option   value="1"> 1 روز پیش </option>
                                        <option value="2"> 2 روز پیش </option>
                                        <option value="3"> 3 روز پیش </option>
                                        <option value="4"> 4 روز پیش </option>
                                        <option value="5"> 5 روز پیش </option>
                                        <option value="6"> 6 روز پیش </option>
                                        <option value="7"> 7 روز پیش </option>
                                    </select>
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
                                    <th>URL</th>
                                    <th>VISIT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $x=0?>
                                @foreach($links as $link)
                                    <tr>

                                        <td> {{++$x}}</td>
                                        <td>{{$link->this_url}}</td>
                                        <td>{{$link->visit_count}}</td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                {{$links->appends($_GET)->links()}}
            </div>
@stop