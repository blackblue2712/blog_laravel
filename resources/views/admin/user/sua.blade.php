@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User
                        <small>{{$user->name}}</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                    @if( count($errors) > 0 )
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                        </div>
                    @endif

                    @if(session('thongbao'))
                        <div class="alert alert-success">{{session('thongbao')}}</div>
                    @endif
                    @if(session('loi'))
                        <div class="alert alert-danger">{{session('loi')}}</div>
                    @endif
                    <form action="admin/user/sua/{{$user->id}}" method="POST">
                        <div class="form-group">
                            <label>User name</label>
                            <input class="form-control" name="name" placeholder="Nhập username" value="{{$user->name}}" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Nhập email" value="{{$user->email}}" readonly="readonly" />
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="changePassword" id="changePassword"> Đổi password
                            </label>

                            <input type="password" class="form-control password" name="password" placeholder="Nhập mật khẩu" disabled="" />
                        </div>
                        <div class="form-group">
                            <label>Nhập lại password</label>
                            <input type="password" class="form-control password" name="passwordAgain" placeholder="Nhập lại mật khẩu" disabled="" />
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <label class="radio-inline">
                                @if($user->quyen == 0)
                                    <input name="quyen" value="0" checked="" type="radio">Thường
                                @else
                                    <input name="quyen" value="0" type="radio">Thường
                                @endif
                            </label>
                            <label class="radio-inline">
                                @if($user->quyen == 1)
                                    <input name="quyen" value="1" checked="" type="radio">Admin
                                @else
                                    <input name="quyen" value="1" type="radio">Admin
                                @endif
                            </label>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-default">Sửa</button>
                        <button type="reset" class="btn btn-default">Làm mới</button>
                    <form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#changePassword').change(function(){
                if( $(this).is(':checked') ){
                    $('.password').removeAttr('disabled');
                }else{
                    $('.password').attr('disabled', '');
                }
            });
        });
    </script>

@endsection