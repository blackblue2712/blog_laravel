<div class="row carousel-holder">
    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 0?>
                @foreach($slide as $sl)
                    @if($i == 0)
                        <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="active"></li>
                    @else
                        <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="active"></li>
                    @endif
                <?php $i++?>
                @endforeach
            </ol>
            <div class="carousel-inner">
                <?php $i = 0?>
                @foreach($slide as $sl)
                    @if($i == 0)
                        <div class="item active">
                            <img class="slide-image" src="upload/slide/{{$sl->Hinh}}" alt="{{$sl->Ten}}">
                        </div>
                        <?php $i++ ?>
                    @else
                        <div class="item">
                            <img class="slide-image" src="upload/slide/{{$sl->Hinh}}" alt="{{$sl->Ten}}">
                        </div>
                    @endif
                @endforeach
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
</div>