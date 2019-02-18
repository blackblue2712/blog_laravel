@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tin tức
                        <small>{{$tintuc->TieuDe}}</small>
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
                    <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Thể loại</label>
                            <select class="form-control" name="TheLoai" id="TheLoai">
                                @foreach($theloai as $tl)
                                    @if($tl->id == $tintuc->loaitin->idTheLoai)
                                        <option selected value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @else
                                        <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Loại tin</label>
                            <select class="form-control" name="LoaiTin" id="LoaiTin">
                                @foreach($loaitin as $lt)
                                    @if($lt->id == $tintuc->idLoaiTin)
                                        <option selected value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @else
                                        <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}" />
                        </div>
                        <div class="form-group">
                            <label>Tóm tắt</label>
                            <input class="form-control" name="TomTat" placeholder="Nhập phần tóm tắt" value="{{$tintuc->TomTat}}" />
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea id="demo" class="form-control ckeditor" name="NoiDung" placeholder="Nhập nội dung">{{$tintuc->NoiDung}}</textarea> 
                        </div>
                         <div class="form-group">
                            <label>Hình ảnh</label>
                            <p><img width="400" src="upload/tintuc/{{$tintuc->Hinh}}"></p>
                            <input type="file" name="Hinh">
                        </div>
                        <div class="form-group">
                            <label>Nổi bật</label>
                            <label class="radio-inline">
                                @if($tintuc->NoiBat == 0)
                                    <input checked name="NoiBat" value="0" checked type="radio">Không
                                @else
                                    <input name="NoiBat" value="0" checked type="radio">Không
                                @endif
                            </label>
                            <label class="radio-inline">
                                @if($tintuc->NoiBat == 1)
                                    <input checked name="NoiBat" value="1" checked type="radio">Có
                                @else
                                    <input name="NoiBat" value="1" checked type="radio">Có
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bình luận
                        <small>Danh sách</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr align="center">
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Nội dung</th>
                            <th>Ngày đăng</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tintuc->comment as $cm)
                            <tr class="odd gradeX" align="center">
                                <td>{{$cm->id}}</td>
                                <td>{{$cm->user->name}}</td>
                                <td>{{$cm->NoiDung}}</td>
                                <td>{{$cm->create_at}}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{$tintuc->id}}/{{$cm->id}}"> Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            $('#TheLoai').change(function(){
                var idTheLoai = $(this).val();
                $.get('admin/ajax/loaitin/' + idTheLoai, function(data){
                    $('#LoaiTin').html(data);
                });
            });
        })
    </script>
@endsection