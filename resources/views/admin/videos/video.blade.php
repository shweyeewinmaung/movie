@extends('admin.layouts.master')

@section('stylesheet')
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@2.0.9/dist/videojs-contrib-quality-levels.min.js"></script>
<style type="text/css">
.search-bar input{
  width: 200px!important;
}
.page-item.active .page-link {
  
  color: #ccc;
    background-color: #2f5a6f;
  border-color: #fff
}
.page-item.disabled .page-link {
    color: #000;  
    background-color: #496a77;   
}
</style>

@endsection
@section('content')

  <div class="row ">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Videos
        </h3>
        
        @foreach($videos as $video)
            <div class="row mt-5">
                <div class="video" >
                    <div class="title">
                        <h4>
                            {{$video->title}}
                        </h4>
                    </div>
                    @if($video->processed)
                    <h1>{{$video->stream_path}}</h1>
                  <!--   /img/uploads/{{$video->stream_path}} -->
                   <!--   <video  height="300"  controls>
                                    <source src="{{asset('img/uploads/'.$video->path)}}" >
                                </video> -->

                                 <video id='hls-example{{$video->id}}' oncontextmenu="return false;"  class="video-js vjs-default-skin" width="400" height="300" controls>
                        <source src="{{asset('img/uploads/'.$video->stream_path)}}">
                      </video>    
                      <script>
                            var options =
                            {
                              controls : true,
                              plugins: {
                                httpSourceSelector:
                                {
                                  default: 'auto'
                                }
                              }
                            };
                            var player = videojs('hls-example'+{{$video->id}}, options);
                            player.httpSourceSelector();
                            </script>         
                      
                    @else
                        <div class="alert alert-info w-100">
                             Video is currently being processed and will be available shortly
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 <script>
  var options =
  {
    controls : true,
    plugins: {
      httpSourceSelector:
      {
        default: 'auto'
      }
    }
  };
  var player = videojs('hls-example', options);
  player.httpSourceSelector();
  </script>
 @endsection