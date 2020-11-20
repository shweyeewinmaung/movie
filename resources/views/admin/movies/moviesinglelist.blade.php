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
video {
  width: 100%;
  height: auto;
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
     <div class="card-header" align="center" style="text-transform: uppercase;"><i class="icon-user"></i> <i class="icon-list"></i>  MOVIE LIST IN {{$moviedata->name}}</div>
     <div class="card-body">
       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#store"><i class="icon-plus"></i> Add New Movie</button>
       <!-- Modal -->
     <div class="modal fade" id="store" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center" style="text-transform: uppercase;">
        		<i class="icon-user"></i> <i class="fa fa-server"></i> MOVIE UPLOAD FOR {{$moviedata->name}}
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="POST" action="{{route('moviesingle.store')}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
                  <div class="row">
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Name</label>
                         <input type="hidden" class="form-control"   name="moviename_id"   value="{{$moviedata->id}}">  
                         <input type="text" class="form-control" placeholder="Name" name="name" readonly="" value="{{$moviedata->name}}">                         
                       </div>
                     </div>
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Category</label>
                          <input type="hidden" class="form-control"   name="category_id"   value="{{$moviedata->category_id}}"> 
                         <input type="text" class="form-control" placeholder="Category" name="category" readonly="" value="{{$moviedata->categories->name}}">         
                       </div>
                     </div>  
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> SubCategory</label>
                          <input type="hidden" class="form-control"   name="subcategory_id"   value="{{$moviedata->subcategory_id}}">
                         <input type="text" class="form-control" placeholder="SubCategory" name="subcategory" readonly="" value="{{$moviedata->subcategories->name}}">
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Status</label>
                          <select class="form-control" name="status">
                          @if($moviedata->status == "Ongoing")
                         <option  selected value="Ongoing">{{$moviedata->status}}</option>
                          <option  value="Finished">Finished</option>
                         @else
                         <option selected value="Finished">{{$moviedata->status}}</option> 
                         <option   value="Ongoing">Ongoing</option>@endif                     
                         </select>                       
                       </div>
                     </div>
                      
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Name</label>
                          <input type="text" class="form-control" placeholder="Enter Video Name" name="episode_name" min="1"> 
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Uploade File (*)</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="video_file">
                          
                       </div>
                     </div>  
                  </div>
                   <div class="row" id="subtitle">
                     <div class="col-md-10 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Subtitle</label><br>
                          <button class="btn btn-light"  style="color:white" type="button"  class="form-control" name="add" id="add" onclick="ff()" ><i class="icon-plus"></i>Add More </button>
                        </div>
                     </div>
                     
                  </div>
                 

                  <!-- <div class="row">
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group">                         
                          <input type="text" class="form-control" name="subtitle_name[]" placeholder="Enter Subtitle Name">
                        </div>
                     </div>  
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group"> 
                       	<input type="file" class="form-control"   name="subtitle_file[]"> 
                       </div> 
                     </div>
                     
                       
                  </div> -->
                  
                  <div id="dynamic_field">
                    
                  </div>
                  
                  
		          <div class="form-group" align="center">
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
     <form action="{{route('statusupdate',['moviename_id'=>$moviedata->id])}}" style="float: right;" method="POST">
       {{csrf_field()}}
        <div class="table-responsive">
         <table class="table align-items-center table-flush table-borderless">
          <tr>
            <td style="border-top: none">
              <select class="form-control" name="status" style="width: 140%">
               @if($moviedata->status == "Ongoing")
                 <option  selected value="Ongoing">{{$moviedata->status}}</option>
                 <option  value="Finished">Finished</option>
               @else
                 <option selected value="Finished">{{$moviedata->status}}</option> 
                 <option   value="Ongoing">Ongoing</option>
               @endif                     
        </select>   
            </td >
            <td style="border-top: none"><button type="submit" class="btn btn-light"  ><i class="icon-plus"></i> UPDATE</button></td>
          </tr>
         </table>
       </div>
        
                
         </form>
   </div>
    <!----card body start------>
     <div class="card-body">
       @if($movieslistall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no Moive in List</label>
               
              </div>
            </div>
            
          </div>
      @else
     
     	<!--------------div table start---->
     	<div class="table-responsive">
     		
                 <table class="table align-items-center table-flush table-borderless">
                  <thead>
                   <tr>
                   	 <th>No</th>
                     <th>Name</th>
                     <th>Subtitles</th>                  
                     <th>Play</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                     @foreach($movieslists as $key=>$movieslist) 
                   <tr>
                      <td>{{$movieslists->firstItem() +$key}} </td>
                      <td>
                        @if($movieslist->episode_name == null)
                        Movie
                        @else
                        {{$movieslist->episode_name}}
                        @endif
                        </td>
                    
                     <td> 
                      <ul>
                       @foreach($movieslist->subtitles as $subtitle)
                       <li>{{$subtitle->subtitle_name}}</li>
                      @endforeach
                    </ul>
                     </td>
                     <td>
                     <button type="submit" class="btn btn-light"  data-toggle="modal" data-target="#play"><i class="fa fa-play" aria-hidden="true"></i></button>
                     <!-- Modal -->
                     <div class="modal fade" id="play" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                             <!----------------->
                              <div class="card-body">
                               <video  height="300"  controls>
                                    <source src="{{asset('images/movies/'.$movieslist->video_file)}}" type="video/mp4">
                                </video>
                              </div><!-----card body end-----> 
                            <!----------------->
                            </div><!--modal-body end-->
                     
                            </div><!--- modal-content end -->
                          </div><!-----modal-dialog end-------->
                         </div><!----modal fade end --->
                         <!---------modal end --->    

                      </td>
                     <td>
                       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#edit{{$movieslist->id}}" title="Edit"><i class="icon-event"></i></button>
                        <!-- Modal -->
                      <div class="modal fade" id="edit{{$movieslist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-scrollable" role="document">
                         <div class="modal-content">
                           <div class="card-header" align="center" style="text-transform: uppercase;">
                              <i class="icon-user"></i> <i class="fa fa-server"></i>  MOVIE UPDATE FOR {{$movieslist->episode_name}} FROM {{$moviedata->name}}
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                            </div><!--- card-header -->
          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="POST" action="{{route('moviesingle.update',['moviename_id'=>$moviedata->id,'id'=>$movieslist->id])}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">       
      
                  <div class="row">
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Name</label>
                         <input type="hidden" class="form-control"   name="moviename_id"   value="{{$moviedata->id}}">  
                         <input type="text" class="form-control" placeholder="Name" name="name" readonly="" value="{{$moviedata->name}}">                         
                       </div>
                     </div>
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Category</label>
                          <input type="hidden" class="form-control"   name="category_id"   value="{{$moviedata->category_id}}"> 
                         <input type="text" class="form-control" placeholder="Category" name="category" readonly="" value="{{$moviedata->categories->name}}">         
                       </div>
                     </div>  
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> SubCategory</label>
                          <input type="hidden" class="form-control"   name="subcategory_id"   value="{{$moviedata->subcategory_id}}">
                         <input type="text" class="form-control" placeholder="SubCategory" name="subcategory" readonly="" value="{{$moviedata->subcategories->name}}">
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Status</label>
                          <select class="form-control" name="status">
                          @if($moviedata->status == "Ongoing")
                         <option  selected value="Ongoing">{{$moviedata->status}}</option>
                          <option  value="Finished">Finished</option>
                         @else
                         <option selected value="Finished">{{$moviedata->status}}</option> 
                         <option   value="Ongoing">Ongoing</option>@endif                     
                         </select>                       
                       </div>
                     </div>
                      
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Name</label>
                          <input type="text" class="form-control" placeholder="Enter Video Name" name="episode_name" value="{{$movieslist->episode_name}}"> 
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Uploade File </label>
                         <input type="file" class="form-control" placeholder="Picture"  name="video_file">
                          
                       </div>
                     </div>  
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                        <video  height="300"  controls>
                                    <source src="{{asset('images/movies/'.$movieslist->video_file)}}" type="video/mp4">
                                </video>
                       </div>
                     </div>  
                  </div>
                   <div class="row" id="subtitle">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Subtitle</label> <br>
                          <button class="btn btn-light"  style="color:white" type="button"  class="form-control"  id="addmyf{{$movieslist->id}}" onclick="myfadd{{$movieslist->id}}()" ><i class="icon-plus"></i> Add More</button>
                       <script type="text/javascript">
                         function myfadd{{$movieslist->id}}(){

                          var button = document. getElementById("addmyf{{$movieslist->id}}");
                          
                              i = 0;
                              button. onclick = function() {
                              i += 1;

                              document.getElementById("addmyf{{$movieslist->id}}").value= i;
                              $('#dynamic_fieldmyfmy{{$movieslist->id}}').append('<div class="row" id="row'+i+'"><div class="col-md-5 pr-md-1"><div class="form-group"><input type="text" class="form-control"  name="subtitle_name[]" placeholder="Enter Subtitle Name"></div></div><div class="col-md-5 pr-md-1"><div class="form-group"><input type="file" class="form-control"  name="subtitle_file[]"></div></div><div class="col-md-2 pr-md-1"><div class="form-group"><button type="button" class="btn-remove btn btn-danger"  name="remove" id="'+i+'" ><i class="icon-close"></i></button></div></div></div></div>');
                            $(document).on('click','.btn-remove',function(){

                              var button_id = $(this).attr('id');
                              //alert(button_id);
                              $("#row"+button_id).remove();
                            });
                          };
                        }
                       </script>
                        </div>
                     </div> 
                   </div>
                  @foreach($movieslist->subtitles as $subtitle)
                  <div class="row" id="rowremove{{$subtitle->id}}">
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group">                         
                          <input type="text" class="form-control" name="subtitle_namedb[]" placeholder="Enter Subtitle Name" value="{{$subtitle->subtitle_name}}">
                        </div>
                     </div>  
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group"> 
                        <input type="text" class="form-control" readonly=""  name="subtitle_filedb[]" value="{{$subtitle->subtitle_file}}">
                        <!--   <input type="file" class="form-control" readonly=""  name="subtitle_file[]"> -->
                       </div> 
                     </div>
                     <div class="col-md-2 pr-md-1">
                       <div class="form-group"> 
                     
                      <button type="button" class="btn btn-danger"  id="removemyf" onclick="removerow{{$subtitle->id}}()"><i class="icon-close"></i></button>
                       <script type="text/javascript">
                        function removerow{{$subtitle->id}}(){
                          var button_id = {{$subtitle->id}};
                           $("#rowremove"+button_id).remove();
                          }
                        
                       </script>
                       </div> 
                     </div>                       
                  </div>                    
                  @endforeach                

                <!--   <div class="row">
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group">                         
                          <input type="text" class="form-control" name="subtitle_name[]" placeholder="Enter Subtitle Name">
                        </div>
                     </div>  
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group"> 
                        <input type="file" class="form-control"   name="subtitle_file[]"> 
                       </div> 
                     </div>
                      <div class="col-md-2 pr-md-1">
                       <div class="form-group"> 
                       
                       </div> 
                     </div>  
                       
                  </div> -->
                  
                  <div id="dynamic_fieldmyfmy{{$movieslist->id}}">
                    
                  </div>
                  
                  
              <div class="form-group" align="center">
                <button class="btn btn-light" type="submit" ><i class="icon-event"></i> UPDATE</button>
              </div>
                </form>
        </div><!-----card body end-----> 
        <!----------------->
        </div><!--- modal-content end -->
      </div><!-----modal-dialog end-------->
     </div><!----modal fade end --->
     <!---------modal end --->
                     </td>
                     <td>
                       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$movieslist->id}}" title="Delete"><i class="icon-close"></i></button>
                        <!-- Modal -->
     <div class="modal fade" id="delete{{$movieslist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i>  MOVIE DELETE FOR {{$movieslist->episode_name}} FROM {{$moviedata->name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('moviesingle.delete',['moviename_id'=>$moviedata->id,'id'=>$movieslist->id])}}" method="post">
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
       <p style="float: right;">TOTAL {{$movieslistall->count()}}</p>   
       {{ $movieslists->links() }} 
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
  
  function ff(){
        var button = document. getElementById("add"),

        i = 0;
        button. onclick = function() {
        i += 1;
        document.getElementById("add").value= i;
        $('#dynamic_field').append('<div class="row" id="row'+i+'"><div class="col-md-5 pr-md-1"><div class="form-group"><input type="text" class="form-control"  name="subtitle_name[]" placeholder="Enter Subtitle Name"></div></div><div class="col-md-5 pr-md-1"><div class="form-group"><input type="file" class="form-control"  name="subtitle_file[]"></div></div><div class="col-md-2 pr-md-1"><div class="form-group"><button type="button" class="btn-remove btn btn-danger"  name="remove" id="'+i+'" ><i class="icon-close"></i></button</div></div></div></div>');
      $(document).on('click','.btn-remove',function(){

        var button_id = $(this).attr('id');
         //alert(button_id);
        $("#row"+button_id).remove();
      });
    };

  }

 
  
 </script>
 
 
 @endsection