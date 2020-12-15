@extends('admin.layouts.master')

@section('stylesheet')
<style type="text/css">
#loadingDiv{
  position:absolute;
  top:0px;
  right:0px;
  width:100%;
  height:100%;  
  background-image:url("{{ asset('/loading.gif') }}");
  /*background-image: url("{{ asset('assets/img/background.png') }}") */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  display: none;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
/********************/
/* The container */
.checkcontaioner {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.checkcontaioner input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;

}

/* On mouse-over, add a grey background color */
/*.container:hover {
background-color: #ccc;

}*/
input ~ .checkmark {
  background-color: #ccc;
  display: block;
}

/* When the checkbox is checked, add a blue background */
.checkcontaioner input:checked ~ .checkmark {
  background-color: #2196F3;

}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkcontaioner input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkcontaioner .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

/********************/
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

     	  @if(session('errorstatus'))
         
           <div class="form-group">
                <label class="alerttext">{{session('errorstatus') }}<br></label>                
              </div>
        @endif

        @foreach($errors->all() as $error)
        
              <div class="form-group">
                <label class="alerttext">{{$error}} <br></label>                
              </div>
          
        @endforeach

    <div class="card">
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  MEDIA LIBRARY FOR ADVERTISING {{$advertising->company_name}} </div>
    
     <div class="card-body">
       <button type="button" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#store"><i class="icon-plus"></i> Add New</button>
       <!-- Modal -->
     <div class="modal fade" id="store" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="icon-user"></i> <i class="fa fa-server"></i> MEDIA FILE UPLOAD 
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="POST" action="{{route('avator.store')}} " enctype="multipart/form-data" id="formnameupload">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> File (*) </label>
                        <input type="file" class="form-control" name="avator">
                          @if ($errors->has('avator'))
                           <label class="alerttext">{{ $errors->first('avator') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div>
            
		          <div class="form-group" align="center">
                 <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
		            <button class="btn btn-light" type="submit" ><i class="icon-lock"></i> SAVE</button>
		          </div>
                </form>
        </div><!-----card body end-----> 
        <!----------------->
        </div><!--modal-body end-->
    <div id="loadingDiv"></div> 
        </div><!--- modal-content end -->
      </div><!-----modal-dialog end-------->
     </div><!----modal fade end --->
     <!---------modal end --->
     <a href="{{route('ads.edit',['id'=>$advertising->id])}}"><button type="submit" class="btn btn-light" style="float: right;" ><i class="fa fa-backward"></i> BACK TO ADVERTISING EDIT FOR {{$advertising->company_name}}</button></a>
     	 
     	 
     </div>
    <!----card body start------>
     <div class="card-body">
     
     	<div class="container">
	       <div class="row">
		    @foreach($avators as $avator)
		  
             <div class="col-md-3 pr-md-1">
        	  <div class="card-group">
		       <div class="card">
		    	@if($avator->mime_type== 'video/mp4') 
		    	   <video  controls height="149px">
                    <source src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" type="video/mp4">
                   </video>
                @else
                <img src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" height="149px">
 
		    	@endif 
		    	<div class="card-body">
		    		@if($advertising->advertisingfile_id == $avator->id)
		    		<label class="checkcontaioner" style="float: left">
					  <input type="checkbox" onclick="onlyOne(this)" name="check" value="{{$avator->id}}" checked="">
					  <span class="checkmark"></span>
					</label>
		    		@else
		    		<label class="checkcontaioner" style="float: left">
					  <input type="checkbox" onclick="onlyOne(this)" name="check" value="{{$avator->id}}">
					  <span class="checkmark"></span>
					</label>
		    		@endif
		    		
					<a href="{{route('avator.selectedit',['id'=>$advertising->id,'avator_id'=>$avator->id])}}">
					  <button type="submit" class="btn-light" ><i class="fa fa-plus"></i>Add</button>
					</a>
                      <!--------delete start--------------------------->
					  <button type="submit" class="btn-light" style="float: right" data-toggle="modal" data-target="#delete{{$avator->id}}" title="Delete"><i class="fa fa-trash"></i></button>
					   <!-- Modal -->
				     <div class="modal fade" id="delete{{$avator->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
				      <div class="modal-dialog modal-dialog-scrollable" role="document">
				        <div class="modal-content">
				          <div class="card-header" align="center">
				            <i class="icon-user"></i> <i class="fa fa-server"></i> MEDIA LIBRARY FILE DELETE FOR {{$avator->file_name}}
				            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
				          </div><!--- card-header -->          
				            
				            <div class="modal-body">
				             <!----------------->
				              <div class="card-body">
				                <form action="{{route('avator.destroy',['id'=>$avator->id])}}" method="post">
				                   <input type="hidden" name="_token" value="{{csrf_token()}}">
				                   <!-- Modal body -->			                        
				                         
				                          <div class="row">
				                     <div class="col-md-12 pr-md-1">
				                       <div class="form-group" align="center">
				                         <label ><i class="icon-close"></i> Are you sure to delete?</label>
				                        
				                       </div>
				                      </div>
				                      </div>

				                        
				                       
				                          <div class="form-group" align="center">
				                           <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
				                           <button class="btn btn-light" type="submit" ><i class="icon-close"></i> Confirm</button>
				                          </div>
				                        
				                  </form>              
				              </div><!-----card body end-----> 
				            
				             <!----------------->
				            </div><!--modal-body end-->

				            <!-- <div class="modal-footer">
				              
				            </div> -->
				           
				        </div><!--- modal-content end -->
				      </div><!-----modal-dialog end-------->
				     </div><!----modal fade end --->
				     <!---------modal end --->

					<!-------------delete end---------------------->
		    	</div>

          
		    
		  </div>

		</div>

           
        </div>
        @endforeach
	</div>
	{{$avators->links() }}
 </div><!-----container end-----> 
  
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
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript">

 $(document).ready(function(){ 
    
    $("#alert").fadeOut(3000);
 
});
 $('#formnameupload').submit(function() {
    $('#loadingDiv').show();
   
});
 	function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('check')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

 </script>
 @endsection