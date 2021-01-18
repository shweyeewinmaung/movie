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
.modal-content {
	background: #351515!important;
}
@media (min-width: 576px) {
  .modal-dialog {
    max-width: 850px;
    }
}

  .alerttext{
    color:red;
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
     <div class="card-header" align="center"><i class="fa fa-home"></i>   CONTACT US </div>
     <div class="card-body">
       
        <div class="card-body">
                <form method="post" action="{{route('contact.update',['id'=>$contact->id])}}" >
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-phone"></i> Phone</label>
                         <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{$contact->phone}}">
                          @if ($errors->has('phone'))
                           <label class="alerttext">{{ $errors->first('phone') }}</label>
                          @endif
                       </div>
                     </div> 

                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-envelope"></i> Email</label>
                         <input type="email" class="form-control" placeholder="Email" name="email" value="{{$contact->email}}">
                          @if ($errors->has('email'))
                           <label class="alerttext">{{ $errors->first('email') }}</label>
                          @endif
                       </div>
                     </div> 


                  </div> 
		          <div class="form-group" align="center">
		           <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal" type="reset">Cancel</button> -->
               <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
		           <button class="btn btn-light" type="submit" ><i class="icon-lock"></i> Update </button>
		          </div>
                </form>
        </div><!-----card body end-----> 
    
    
     </div>
   
      
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript">
 $(document).ready(function(){ 
    
    $("#alert").fadeOut(3000);
 
});
 
 </script>
 @endsection