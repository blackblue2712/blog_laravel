@extends('layouts.index')

@section('content')
<!-- Page Content -->
<div class="container">
    @include('layouts.slide')
    <div class="row">
        @include('layouts.menu')
        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#337AB7; color:white;">
                    <h4><b>Tìm kiếm: {{$tukhoa}}</b></h4>
                </div>
                <?php
                    function changeColor($str, $keyword){
                        return str_replace($keyword, "<span style='color: lightblue'>$keyword</span>", $str);
                    }
                ?>
                @foreach($tintuc as $tt)
                    <div class="row-item row">
                        <div class="col-md-3">

                            <a href="#">
                                <br>
                                <img width="200px" height="200px" class="img-responsive" src="upload/tintuc/{{$tt->Hinh}}" alt="">
                            </a>
                        </div>

                        <div class="col-md-9">
                            <h3>{!!changeColor($tt->TieuDe, $tukhoa)!!}</h3>
                            <p>{!!changeColor($tt->TomTat, $tukhoa)!!}</p>
                            <a class="btn btn-primary" href="#">Xem thêm<span class="glyphicon glyphicon-chevron-right"></span></a>
                        </div>
                        <div class="break"></div>
                    </div>
                @endforeach
                <!-- Pagination -->
                <div class="row text-center">
                    {{$tintuc->links()}}
                </div>
                <!-- /.row -->

            </div>
        </div> 

    </div>

</div>
<!-- end Page Content -->
@endsection