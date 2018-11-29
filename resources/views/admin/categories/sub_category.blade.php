@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title> Sub categories </title>

    <!-- Editatable  Css-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('template/adminto/assets/plugins/magnific-popup/dist/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/adminto/assets/plugins/jquery-datatables-editable/datatables.css') }}" />
    <link href="{{ asset('template/adminto/assets/plugins/custombox/dist/custombox.min.css' ) }}" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel ">

                <div class="panel-heading">
                    <div class="pull-left">
                        <h4>زیر دسته بندی</h4>
                    </div>

                    <div class="pull-right">
                        <a href="#custom-modal" class="btn btn-success btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal"
                           data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> افزودن دسته بندی </a>

                    </div>

                </div>
                <br> <br>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <div class="editable-responsive">
                        <table class="table table-striped" id="datatable-editable">
                            <thead>
                            <tr>
                                <th>ایدی</th>
                                <th>عنوان</th>
                                <th>وضعیت</th>
                                <th>اقدامات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sub_categories as $sub_category)
                            <tr class="gradeX">
                                <td>{{ $sub_category->id }}</td>
                                <td>{{ $sub_category->title }}</td>
                                <td>
                                    <select  id="mySelect" name="status" disabled>
                                        <option  value="1" @if($sub_category->status==1) selected @endif>فعال</option>
                                        <option  value="0" @if($sub_category->status==0) selected @endif>غیر فعال</option>
                                    </select>
                                </td>
                                <td class="actions">
                                    <a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>
                                    <a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>
                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- end: panel body -->
            @stop
@section('footer')
    <!-- Modal -->
    <div id="custom-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.close();">
            <span>&times;</span><span class="sr-only">بستن</span>
        </button>
        <h4 class="custom-modal-title">افزودن دسته بندی</h4>
        <div class="custom-modal-text text-left">
            <form method="POST" action="{{route('sub_categories_create')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">نام</label>
                    <input type="text" class="form-control" name="title" placeholder="نام را وارد کنید">
                    <input type="hidden" class="form-control" name="category_id" value="{{ $category }}">
                </div>
                <div class="form-group ">
                    <label for="image_path"> تصویر </label>
                    <input type="file" name="image_path" class="dropify"/>
                </div>
                <button type="submit" class="btn btn-default waves-effect waves-light">ذخیره کردن</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">لغو</button>
            </form>
        </div>
    </div>


    <script>
        //file upload script
        $('.dropify').dropify({
            messages: {
                'default': 'یک فایل را به اینجا بکشید و رها کنید یا اینجا کلیک کنید',
                'replace': 'برای جایگزینی یک فایل را بکشید و رها کنید یا اینجا کلیک کنید',
                'remove': 'پاک کردن',
                'error': 'خطایی رخ داده است.'
            },
            error: {
                'fileSize': 'اندازه فایل بزرگ است. (حداکثر 1 مگابایت)'
            }
        });
    </script>
    <!-- Modal-Effect -->
    <script src="{{ asset('template/adminto/assets/plugins/custombox/dist/custombox.min.js' ) }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/custombox/dist/legacy.min.js' ) }}"></script>
    <!-- file uploads js -->

    <!-- Editable js -->
    <script src="{{ asset('template/adminto/assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/tiny-editable/mindmup-editabletable.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/tiny-editable/numeric-input-example.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/pages/datatables.editable.init.js') }}"></script>
    <script>
        $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    </script>
@stop