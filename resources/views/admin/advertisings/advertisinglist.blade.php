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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  ADVERTISING LIST </div>
     <div class="card-body">
       <a href="{{route('ads.create')}}"><button type="submit" class="btn btn-light" style="float: left" ><i class="icon-plus"></i> Add New</button></a>
      
    
     	 
     	
      <form action="{{route('ads.searchdate')}}" style="float: right;" method="get">
       {{csrf_field()}}
        <div class="table-responsive">
         <table class="table align-items-center table-flush table-borderless">
        <!--   <tr>
            <td style="border-top: none">
              Search with Name
            </td >
            <td style="border-top: none">
              <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="">
         
            </td >
            <td style="border-top: none">
             
              <button type="submit" class="btn btn-light"  ><i class="icon-magnifier"></i> Search</button></td>
          </tr> -->
           <tr>
            <!-- <td style="border-top: none; padding-right: .1rem; padding-left:.1rem;">
              Search with Date
            </td > -->
            <td style="border-top: none; padding-right: .1rem; padding-left:.1rem;">
              <input type="date" class="form-control" placeholder="Enter keywords" name="searchdate" value="{{$searchdate}}">
         
            </td >
            <td style="border-top: none; padding-right: .1rem; padding-left:.1rem;">
             
              <button type="submit" class="btn btn-light"  ><i class="icon-magnifier"></i> Search</button></td>
          </tr>
         </table>
       </div>
        
                
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
     @if($advertisingslistsall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in Advertising List</label>
         <!--        <input type="text" class="form-control" placeholder="Name" name="name">
              -->  
              </div>
            </div>
            
          </div>
      @else
     
     	<!--------------div table start---->
     	<div class="table-responsive">
     		
                 <table class="table align-items-center table-flush table-borderless">
                  <thead>
                   <tr>
                   	 <th>No.</th>
                     <th>Picture</th>
                     <th>Company Name</th>
                     <th>From</th>
                     <th>To</th>
                     <th>Time (Seconds)</th>
                     <th>Type</th>
                    
                     
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                   	@foreach($advertisingslists as $key=>$advertisingslist)
                   	<tr>
                   		<td>{{$advertisingslists->firstItem() +$key}}</td>
                   			<?php $avator = DB::table('media')->where('id', $advertisingslist->advertisingfile_id)->first();?>
                   		<td>
                   			 @if($avator->mime_type== 'video/mp4')
                          <video  controls height="150px">
                            <source src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" type="video/mp4">
                           </video>
                            @else
                           <img src="{{asset('img/ads/'.$avator->id.'/'.$avator->file_name)}}" height="149px" class="image">
                         @endif

                   		</td>
                   		<td>{{$advertisingslist->company_name}}</td>
                   		<td>{{$advertisingslist->from_date}}</td>
                   		<td>{{$advertisingslist->to_date}}</td>
                   		<td>{{$advertisingslist->display_time}}</td>
                   		<td>{{$advertisingslist->display_type}}</td>

                   		
                   		<td>
                   			<a href="{{route('ads.edit',['id'=>$advertisingslist->id])}}"><button type="submit" class="btn btn-light" style="float: left" ><i class="icon-event"></i></button></a>
                   		</td>
                   		<td>
                   			   <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$advertisingslist->id}}" title="Delete"><i class="icon-close"></i></button>
                   			    <!-- Modal -->
     <div class="modal fade" id="delete{{$advertisingslist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i>  ADVERTISING DELETE FOR {{$advertisingslist->company_name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('ads.delete',['id'=>$advertisingslist->id])}}" method="post">
                   <input type="hidden" name="_token" value="{{csrf_token()}}">
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

        </div><!--- modal-content end -->
      </div><!-----modal-dialog end-------->
     </div><!----modal fade end --->
     <!---------modal end --->
                   		</td>
                   	</tr>
                   	@endforeach
                   </tbody>
                   
           </table>
          </div> <!--------------div table end ----->
         @endif
        </div><!-----card body end-----> 
      <div class="card-body" >
      <p style="float: right;">TOTAL {{$advertisingslistsall->count()}} </p>   
       {{ $advertisingslists->appends(Request::only('searchdate'))->links() }} 
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
 
$(document).ready(function() {

    $('select[name="category_id"]').on('change', function(){
        var category_id = $(this).val();
        var APP_URL = {!! json_encode(url('/')) !!};       
        //alert(APP_URL);
        if(category_id) {

            $.ajax({
              url: APP_URL+'/admin/MovieNameList/subcategory/get/'+category_id,
                type:"GET",
                dataType:"json",
                beforeSend: function(){

                    $('#loader').css("visibility", "visible");
                },

                success:function(data) {
                     
                    $('select[name="subcategory_id"]').empty();

                    $.each(data, function(key, value){
                        
                        $('select[name="subcategory_id"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="subcategory_id"]').empty();
        }

    });

});

 </script>
 @endsection