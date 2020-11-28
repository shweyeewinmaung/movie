@extends('admin.layouts.master')

@section('stylesheet')
<style type="text/css">
/*.search-bar input{
	width: 200px!important;
	margin-left: 1%;
}*/
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

  .alerttext{
    color:red;
  }

  @media (min-width: 576px) {
     .modal-dialog {
    max-width: 850px;
    }
  .search-bar input{
  width: 320px!important;
  }
  .search-bar
  {
  	margin-left: 0px;
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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  MOVIE NAMES  </div>
     <div class="card-body">
      
      
     	<form class="search-bar" action="{{route('moviesearchlist.search')}}" method="get">
     	 {{csrf_field()}}
     	 <div class="table-responsive">
     	  <table class="table align-items-center table-flush table-borderless" style="width: 80%">
            <tbody>
               <tr>
               	<td style="border-top:none;"><label><i class="fa fa-server"></i> Category</label><br>
               	  <select class="form-control" name="category_id">
               	  	        @if($categorydata == null)               	  	       
                            <option selected value="" >All</option>
               	  	        @else
               	  	          <option selected value="{{$categorydata->id}}" >{{$categorydata->name}}</option>
                            <option  value="" >All</option>
                              
               	  	        @endif
		                    
		                   @foreach($categories as $category)

		                   @if($categorydata == null || $categorydata->id != $category->id)
		                    <option value="{{$category->id}}" >{{$category->name}}</option>
		                    @endif 
		                   @endforeach
		               </select>
               	</td>
               	<td style="border-top:none;text-align: left;"><label><i class="fa fa-server"></i> SubCategory</label><br>
               		 <select class="browser-default custom-select dropdown-primary form-control" name="subcategory_id">
               		 	 @if($subcategorydata == null)
               		 	   <option selected value="" >All</option>
               		 	 @else
               	  	        <option selected value="{{$subcategorydata->id}}" >{{$subcategorydata->name}}</option>
               	  	     @endif
               		 </select>
               	</td>
               	<td style="border-top:none;">
               		<label></label><br>
               		<button type="submit" class="btn btn-light" ><i class="icon-magnifier"></i> Search</button>
               	</td>
               </tr>
              
           </tbody>
           </table>
          </div>    	  
     
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
      @if($moviesearchlistsall->count() <= 0 )
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in Movie Name List</label>
         <!--        <input type="text" class="form-control" placeholder="Name" name="name">
              -->  
              </div>
            </div>
            
          </div>
      @elseif($moviesearchlists == null )
     <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <!-- <label>There is no data in Movie Name List</label> -->
         <!--        <input type="text" class="form-control" placeholder="Name" name="name">
              -->  
              </div>
            </div>
            
          </div>
      @else
         @if($categorydata == null)
        
          @if($subcategorydata == null)
           <form class="search-bar" style="float: right;" action="{{route('moviesearchmovielist.search',['category_id'=>0,'subcategory_id'=>0])}}" method="get">
          @endif
         @else
          @if($subcategorydata == null)
          <form class="search-bar" style="float: right;" action="{{route('moviesearchmovielist.search',['category_id'=>$categorydata->id,'subcategory_id'=>0])}}" method="get">
            @else
            <form class="search-bar" style="float: right;" action="{{route('moviesearchmovielist.search',['category_id'=>$categorydata->id,'subcategory_id'=>$subcategorydata->id])}}" method="get">
          @endif
         
         @endif
        
       {{csrf_field()}}
        @if($searchmovie == null)
         <input type="text" class="form-control" placeholder="Enter Movie Name" name="searchmovie" value="">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>
        @else
         <input type="text" class="form-control" placeholder="Enter Movie Name" name="searchmovie" value="{{$searchmovie}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>
        @endif
               
         </form>

     	<!--------------div table start---->
     	<div class="table-responsive" style="margin-top: 5%">
     		
                 <table class="table align-items-center table-flush table-borderless">
                  <thead>
                   <tr>
                   	 <th>No.</th>
                     <th>Picture.</th>
                     <th>Name</th>
                     <th>Category</th>
                     <th>SubCategory</th>
                     <th>Episode</th>
                    
                     <th>Status</th>

                     <th>View</th>
                     
                   </tr>
                   </thead>
                   <tbody>
                    @foreach($moviesearchlists as $key=>$moviesearchlist)
                    <tr>
                     <td>{{$moviesearchlists->firstItem() +$key}}</td>
                     <td>
                       @if($moviesearchlist->movie_file)
                           <button type="button" class="btn" data-toggle="modal" data-target="#myimage{{$moviesearchlist->id}}"> <img class="image" src="{{asset('/public/images/movienames/'.$moviesearchlist->movie_file)}}" alt=""></button>
                       @else
                           <button type="button" class="btn" data-toggle="modal" data-target="#myimage{{$moviesearchlist->id}}"> <img src="//placehold.it/1000x600" class="img-responsive image"></button>
                          
                       @endif
                       
                            <div id="myimage{{$moviesearchlist->id}}" class="modal fade" tabindex="-1" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="{{asset('/public/images/movienames/'.$moviesearchlist->movie_file)}}" class="image2">
                                    </div>
                                </div>
                              </div>
                            </div>
                     </td>
                     <td>{{$moviesearchlist->name}}</td>                     
                     <td>{{$moviesearchlist->categories->name}}</td>
                     <td>{{$moviesearchlist->subcategories->name}}</td>
                      <td style="text-align: center;">
                        @if($moviesearchlist->episode == '1')
                        <i class="fa fa-check" aria-hidden="true" style="color:#689ac6"></i>
                        @else
                        <i class="fa fa-times" aria-hidden="true" style="color:#e18585"></i>
                        @endif
                      </td>
                     
                      <td>{{$moviesearchlist->status}}</td>
                      <td>
                        @if($moviesearchlist->episode == '1')
                         <a href="{{route('movieepisodelist',['moviename_id'=>$moviesearchlist->id])}}">
                          <button type="submit" class="btn btn-light"><i class="zmdi zmdi-eye"></i> </button>
                          </a>
                        @else
                        <a href="{{route('moviesinglelist',['moviename_id'=>$moviesearchlist->id])}}">
                          <button type="submit" class="btn btn-light"><i class="zmdi zmdi-eye"></i> </button>
                          </a>
                        @endif
                       
                        
                        </td>
                 </tr>

                    @endforeach
                   </tbody>
           </table>
          </div> <!--------------div table end ----->
          
      
       {{ $moviesearchlists->appends(Request::all())->links() }} 
      
          @endif
           <p style="float: right;">TOTAL {{$moviesearchlistsall->count()}} </p> 
        </div><!-----card body end-----> 
       
        
      
      
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
 
$(document).ready(function() {

    $('select[name="category_id"]').on('change', function(){
        var category_id = $(this).val();
        var APP_URL = {!! json_encode(url('/')) !!};       
         
        if(category_id) {

            $.ajax({
              url: APP_URL+'/admin/MovieListSearch/subcategory/get/'+category_id,
                type:"GET",
                dataType:"json",
                beforeSend: function(){

                    $('#loader').css("visibility", "visible");
                },

                success:function(data) {
                     
                    $('select[name="subcategory_id"]').empty();
                    $('select[name="subcategory_id"]').append('<option value="">All</option>');
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