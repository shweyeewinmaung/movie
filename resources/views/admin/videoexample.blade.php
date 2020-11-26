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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  VIDEO EXAMPLE </div>
     <div class="card-body">      
    
    
      </div>
    <!----card body start------>
     <div class="card-body">
      
     </div><!-----card body end-----> 
     <div class="card-body" >
      <form method="POST" action="{{route('videoexample.save')}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
              
                  
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> PICTURE</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="movie_file">
                          
                       </div>
                     </div>  
                  </div>
                    
                
                
                 
              <div class="form-group" align="center">
                <button class="btn btn-light" type="submit" ><i class="icon-lock"></i> SAVE</button>
              </div>
                </form>
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 
 </script>
 @endsection