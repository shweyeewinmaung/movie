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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  MOVIE NAME LIST </div>
     <div class="card-body">
       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#store"><i class="icon-plus"></i> Add New</button>
       <!-- Modal -->
     <div class="modal fade" id="store" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="icon-user"></i> <i class="fa fa-server"></i> MOVIE NAME ENTRY 
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="POST" action="{{route('moviename.store')}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div>
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> Category</label>
                         <select class="form-control" name="category_id">
		                   <option selected value="" >Click here to choose</option>
		                   @foreach($categories as $category)
		                    <option value="{{$category->id}}" >{{$category->name}}</option>   
		                   @endforeach
		               </select>
                    @if ($errors->has('category_id'))
                      <label class="alerttext">{{ $errors->first('category_id') }}</label>
                    @endif
                       </div>
                     </div>  
                  </div> 
                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> Sub Category</label>
                         <select class="browser-default custom-select dropdown-primary form-control" name="subcategory_id">                      
                         </select>
                          @if ($errors->has('subcategory_id'))
                            <label class="alerttext">{{ $errors->first('subcategory_id') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div> 
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> PICTURE</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="movie_file">
                          @if ($errors->has('movie_file'))
                      <label class="alerttext">{{ $errors->first('movie_file') }}</label>
                    @endif
                       </div>
                     </div>  
                  </div>
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                          
                         <input type="checkbox" name="episode" class="form-group">
                         <span class="form-group">Tick the checkbox if there is more than one episode</span>
                       </div>
                     </div>  
                  </div> 
                   <!--  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         
                         <input type="checkbox" name="season" class="form-group">
                         <span class="form-group">Tick the checkbox if there is more than one season</span>
                       </div>
                     </div>  
                  </div>  -->
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> Outline</label>
                          <textarea class="form-control" id="outline" name="outline"></textarea>
                           @if ($errors->has('outline'))
                            <label class="alerttext">{{ $errors->first('outline') }}</label>
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
 
        </div><!--- modal-content end -->
      </div><!-----modal-dialog end-------->
     </div><!----modal fade end --->
     <!---------modal end --->
    
     	 
     	<form class="search-bar" style="float: right" action="{{route('moviename.search')}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
      @if($movienamelistsall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in Movie Name List</label>
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
                     <th>Name</th>
                     <th>Category</th>
                     <th>SubCategory</th>
                     <th>Episode</th>
                     <th>Status</th>
                     
                     <th>View</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                    @foreach($movienamelists as $key=>$movienamelist)
                    <tr>
                      <td>{{$movienamelists->firstItem() +$key}}</td>
                      <td>                      
                           <img class="image" src="{{asset('/images/movienames/'.$movienamelist->movie_file)}}" alt="">
                      </td>
                      <td>{{$movienamelist->name}}</td>
                      <td>{{$movienamelist->categories->name}}</td>
                      <td>{{$movienamelist->subcategories->name}}</td>
                      <td style="text-align: center;">
                        @if($movienamelist->episode == '1')
                        <i class="fa fa-check" aria-hidden="true" style="color:#689ac6"></i>
                        @else
                        <i class="fa fa-times" aria-hidden="true" style="color:#e18585"></i>
                        @endif
                      </td>
                      <td>{{$movienamelist->status}}</td>

                      <td>
                          <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#view{{$movienamelist->id}}"><i class="zmdi zmdi-eye"></i> </button>
                            <!-- Modal -->
     <div class="modal fade" id="view{{$movienamelist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i> MOVIE NAME DETAIL FOR {{$movienamelist->name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->
          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
               <div class="row">
                   
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Name - {{$movienamelist->name}}</label><br>
                         <label class="form-group"><i class="fa fa-server"></i> Category - {{$movienamelist->categories->name}}</label><br>
                          <label class="form-group"><i class="fa fa-server"></i> Sub Category - {{$movienamelist->subcategories->name}}</label><br>
                           <label class="form-group"><i class="fa fa-server"></i> Edpisode - @if($movienamelist->episode == '1')
                                                            Yes
                                                            @else
                                                            No
                                                            @endif

                       </label>   <br> 
                        <label class="form-group"><i class="fa fa-server"></i> Status - {{$movienamelist->status}}
                       </label>                       
                       </div>
                     </div> 
                       <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                           <img class="image1" src="{{asset('/images/movienames/'.$movienamelist->movie_file)}}" alt="">
                         </div>
                     </div>  
                  </div> 
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"> <i class="fa fa-server"></i> Outline -{!! $movienamelist->outline !!}</label>
                         
                       </div>
                     </div>  
                  </div> 
              <div class="form-group" align="center">
                <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>                
              </div>
            
        </div><!-----card body end-----> 
        <!----------------->
        </div><!--modal-body end-->
 
        </div><!--- modal-content end -->
      </div><!-----modal-dialog end-------->
     </div><!----modal fade end --->
     <!---------modal end --->
     </td>
                      <td>
                        <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#edit{{$movienamelist->id}}" title="Edit"><i class="icon-event"></i></button>
                          <!-- Modal -->
     <div class="modal fade" id="edit{{$movienamelist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i> MOVIE NAME UPDATE FOR {{$movienamelist->name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->
          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="POST" action="{{route('moviename.update',['id'=>$movienamelist->id])}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name" value="{{$movienamelist->name}}">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div>
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Category</label>
                         <select class="form-control" name="category_id">
                       <option selected value="{{$movienamelist->category_id}}" class="form-group">{{$movienamelist->categories->name}}</option>
                       @foreach($categories as $category)
                          @if($category->id != $movienamelist->category_id)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif                           
                       @endforeach
                      
                   </select>
                    @if ($errors->has('category_id'))
                      <label class="alerttext">{{ $errors->first('category_id') }}</label>
                    @endif
                       </div>
                     </div>  
                  </div> 
                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label ><i class="fa fa-server"></i> Sub Category</label>
                         <select class="form-control" name="subcategory_id">
                         <option value="{{$movienamelist->subcategory_id}}">{{$movienamelist->subcategories->name}}</option>                      
                         </select>
                          @if ($errors->has('subcategory_id'))
                            <label class="alerttext">{{ $errors->first('subcategory_id') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div> 
                
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                          <label ><i class="fa fa-server"></i> Status</label>
                         <select class="form-control" name="status">
                          @if($movienamelist->status == "Ongoing")
                         <option  selected value="Ongoing">{{$movienamelist->status}}</option>
                          <option  value="Finished">Finished</option>
                          @elseif($movienamelist->status == "Finished")
                         <option selected value="Finished">{{$movienamelist->status}}</option> 
                         <option   value="Ongoing">Ongoing</option>                     
                         </select>
                         @else
                          <option  selected ></option>
                           <option value="Ongoing">Ongoing</option>
                          <option  value="Finished">Finished</option> 
                          @endif                     
                         </select>
                       </div>
                     </div>  
                  </div> 

                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         @if($movienamelist->episode == '1')
                         <input type="checkbox" name="episode" class="form-group" checked="">
                         @else
                         <input type="checkbox" name="episode" class="form-group">
                         @endif
                         <span class="form-group">Tick the checkbox if there is more than one episode</span>
                       </div>
                     </div>  
                  </div> 
                   
                    <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> PICTURE</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="movie_file">
                          @if ($errors->has('movie_file'))
                      <label class="alerttext">{{ $errors->first('movie_file') }}</label>
                    @endif
                       </div>
                     </div> 
                      <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                        <img class="image1" src="{{asset('/images/movienames/'.$movienamelist->movie_file)}}" alt="">
                          @if ($errors->has('movie_file'))
                      <label class="alerttext">{{ $errors->first('movie_file') }}</label>
                    @endif
                       </div>
                     </div>   
                  </div>
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> Outline</label>
                          <textarea class="form-control" id="outlineedit" name="outlineedit">{{$movienamelist->outline}}</textarea>
                           @if ($errors->has('outline'))
                            <label class="alerttext">{{ $errors->first('outline') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div> 
                
                 
              <div class="form-group" align="center">
                 <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
                <button class="btn btn-light" type="submit" ><i class="icon-lock"></i> UPDATE</button>
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
                      <td>
                        <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$movienamelist->id}}" title="Delete"><i class="icon-close"></i></button>
                         <!-- Modal -->
     <div class="modal fade" id="delete{{$movienamelist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i> MOVIE NAME DELETE FOR {{$movienamelist->name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('moviename.delete',['id'=>$movienamelist->id])}}" method="post">
                   <input type="hidden" name="_token" value="{{csrf_token()}}">

                      
                        <!-- Modal body -->
                        <div class="modal-body">
                         
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
                      </td>
                    </tr>
                    @endforeach
                   </tbody>
           </table>
          </div> <!--------------div table end ----->
           @endif
        </div><!-----card body end-----> 
      <div class="card-body" >
       <p style="float: right;">TOTAL {{$movienamelistsall->count()}} </p>   
       {{ $movienamelists->appends(Request::only('search'))->links() }} 
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script type="text/javascript">
  CKEDITOR.replace( 'outline', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
   CKEDITOR.replace( 'outlineedit', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
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