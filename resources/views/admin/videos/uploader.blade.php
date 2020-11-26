@extends('admin.layouts.master')

@section('stylesheet')
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
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Upload Video
        </h3>
            @if(session('status'))
         <div class="row alert alert-info" id="alert">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <label style="color:white;margin-top: .5rem;">{{session('status')}} <br></label>

                
              </div>
            </div>           
          </div>
        @endif
        <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="video-title">Title</label>
                <input type="text"
                       class="form-control"
                       name="title"
                       placeholder="Enter video title">
                @if($errors->has('title'))
                    <span class="text-danger">
                        {{$errors->first('title')}}
                    </span>
                @endif
            </div>
 
            <div class="form-group">
                <label for="exampleFormControlFile1">Video File</label>
                <input type="file" class="form-control-file" name="video">
 
                @if($errors->has('video'))
                    <span class="text-danger">
                        {{$errors->first('video')}}
                    </span>
                @endif
            </div>
 
            <div class="form-group">
                <input type="submit" class="btn btn-default">
            </div>
 
            {{csrf_field()}}
        </form>
    </div>
    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 
 </script>
 @endsection