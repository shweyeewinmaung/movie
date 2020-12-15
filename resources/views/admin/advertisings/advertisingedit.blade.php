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


  .alerttext{
    color:red;
  }

  @media (min-width: 576px) {
     .modal-dialog {
    max-width: 850px;
    }
  .search-bar input{
  width: 480px!important;
  }
  img.image{
      width: 50px;
      height: 50px
    }
     img.image1{
      width: 150px;
      height: 150px
    }
    img.image2{
       width: 800px;
      height: 500px
    }
}
@media (max-width: 575px) {
  .search-bar input{
  width: 200px!important;
  }
   img.image{
      width: 40px;
      height: 40px
    }
     img.image1{
      width: 50px;
      height: 50px
    }
    img.image2{
       width: 250px;
      height: 200px
    }
}
</style>
@endsection
@section('content')

  <div class="row ">
     <div class="col-lg-12" ><!--  <div class="col-lg-12 col-xl-12"> -->
     	 
     	  @if(session('status'))
         <div class="row alert alert-info" id="alert">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <label style="color:white;margin-top: .5rem;">{{session('status')}} <br></label>

                
              </div>
            </div>           
          </div>
        @endif

        @foreach($errors->all() as $error)
        
              <div class="form-group">
                <label class="alerttext">{{$error}} <br></label>                
              </div>
          
        @endforeach
    <div class="card">
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  ADVERTISING EDIT FOR {{$advertising->company_name}} </div>
     <div class="card-body">
       <a href="{{route('ads.list')}}"><button type="submit" class="btn btn-light" style="float: left" ><i class="fa fa-backward"></i> BACK TO ADVERTISING LIST</button></a>
      
    
     </div>
    <!----card body start------>
     <div class="card-body">
     
     	<form method="POST" action="{{route('ads.update',['id'=>$advertising->id])}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">  

                  <div class="row">
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Advertising File (*) </label><br>
                          <a href="{{route('avator.indexedit',['id'=>$advertising->id])}}"><button type="button" class="btn btn-light" ><i class="icon-plus"></i> CHOOSE FILE</button></a>
                       </div>
                     </div> 
                     <div class="col-md-8 pr-md-1">
                       <div class="form-group">
                         @if($avator != null)
                          <input type="hidden" name="advertisingfile" value="{{$avator->id}}">
                          @if($avator->mime_type== 'video/mp4')
                          <video  controls height="149px">
                            <source src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" type="video/mp4">
                           </video>
                            @else
                           <img src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" height="149px">
                         @endif
                          @endif
                       </div>
                     </div>  
                  </div>      
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Company Name (*) </label>
                         <input type="text" class="form-control" placeholder="Name" name="company_name" value="{{$advertising->company_name}}">
                        
                       </div>
                     </div>  
                  </div>
                
                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-calendar"></i> From Date  (*) </label>
                         <input type="date" name="from_date" class="form-control" value="{{$advertising->from_date}}">

                       </div>
                     </div>  
                  </div> 
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-calendar"></i> To Date (*) </label>
                         <input type="date" name="to_date" class="form-control" value="{{$advertising->to_date}}">
                       </div>
                     </div>  
                  </div>
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-clock-o"></i> Display Time (Seconds) (*) </label> 
                         <input type="number" name="display_time" class="form-control" value="{{$advertising->display_time}}">
                        
                       </div>
                     </div>  
                  </div> 
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> Display Type (1 or 2 Only) (*) </label>
                         <input type="number" name="display_type" class="form-control" min="1" max="2" value="{{$advertising->display_type}}">
                         
                       </div>
                     </div>  
                  </div> 
                  
                
                 
		          <div class="form-group" align="center">
                 <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
		            <button class="btn btn-light" type="submit" ><i class="icon-event"></i> UPDATE</button>
		          </div>
                </form>
     
         
      </div><!-----card body end-----> 
      <div class="card-body" >
     
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 <!-- <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script> -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript">
 /*CKEDITOR.replace( 'outline', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
   CKEDITOR.replace( 'outlineedit', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});*/
 $(document).ready(function(){ 
    
    $("#alert").fadeOut(3000);
 
});


 </script>
 @endsection