@extends('admin.layouts.master')

@section('stylesheet')
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@2.0.9/dist/videojs-contrib-quality-levels.min.js"></script>
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

#loadingDiv1{
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
/*.progress { position:relative; width:100%; height: 20px; }
.bar { background-color: #008000; width:0%; height:20px; }
.percent { position:absolute; display:inline-block; left:50%; color: #7F98B2;}*/
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
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label style="color:white;margin-top: .5rem;">{{session('status')}} <br></label>

                
              </div>
            </div>           
          </div>
        @endif
          @if(session('errorstatus'))
         
              <div class="form-group">
                <label class="alerttext">{{session('errorstatus')}} <br></label>

                
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
                <form enctype="multipart/form-data" method="POST" action="{{route('movieepisode.store')}}" id="formnameupload">
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
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Status</label>
                          <select class="form-control" name="status">
                          @if($moviedata->status == "Ongoing")
                             <option  selected value="Ongoing">{{$moviedata->status}}</option>
                             <option  value="Finished">Finished</option>
                           @elseif($moviedata->status == "Finished")
                             <option selected value="Finished">{{$moviedata->status}}</option> 
                             <option   value="Ongoing">Ongoing</option>
                           @else
                           <option></option>
                           <option  value="Ongoing">Ongoing</option>
                           <option  value="Finished">Finished</option> 
                           
                           @endif                                
                         </select>                       
                       </div>
                     </div>
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Season</label>
                         
                          <input type="number" class="form-control" placeholder="Number" name="season_number" min="1" value="1">         
                       </div>
                     </div>  
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Episode</label>
                          <input type="number" class="form-control" placeholder="Number" name="episode_name" min="1"> 
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Uploade File (*) .mp4 file only</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="video_file">
                          
                       </div>
                     </div>  
                  </div>
                  
                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Encoded File </label>
                         <input type="file" class="form-control" placeholder="Picture"   name="encodednames[]"  multiple="multiple">
                          
                       </div>
                     </div>  
                  </div>
                   <div class="row" id="subtitle">
                     <div class="col-md-10 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Subtitle</label> <br>
                                <button class="btn btn-light"  style="color:white" type="button"  class="form-control" name="add" id="add" onclick="ff()" ><i class="icon-plus"></i> Add More </button>
                        </div>
                     </div>  
                      
                    
                  </div>
                 

                 <!--  <div class="row">
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
                        <button class="btn btn-light"  style="color:white" type="button"  class="form-control" name="add" id="add" onclick="ff()" ><i class="icon-plus"></i> </button>
                       </div> 
                     </div> 
                       
                  </div> -->
                  
                  <div id="dynamic_field">
                    
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
               @elseif($moviedata->status == "Finished")
                 <option selected value="Finished">{{$moviedata->status}}</option> 
                 <option   value="Ongoing">Ongoing</option>
               @else
               <option></option>
               <option  value="Ongoing">Ongoing</option>
               <option  value="Finished">Finished</option>               
               @endif                     
             </select>   
            </td >
            <td style="border-top: none">
             
              <button type="submit" class="btn btn-light"  ><i class="icon-plus"></i> UPDATE</button></td>
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
                     <th>Season</th>
                     <th>Name</th>
                     <th>Subtitles</th> 
                     <th>Streaming Date</th>
                     <th>Process</th>

                     <th>Play</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                     @foreach($movieslists as $key=>$movieslist) 
                   <tr>
                     <td>{{$movieslists->firstItem() +$key}} </td>
                     <td>Season - {{$movieslist->season_number}}</td>
                     <td> Episode - {{$movieslist->episode_name}}</td>
                     <td> 
                      <ul>
                      @foreach($movieslist->subtitles as $subtitle)
                       <li>{{$subtitle->subtitle_name}}</li>
                      @endforeach
                    </ul>
                     </td>
                     <td>
                     @if($movieslist->converted_for_streaming_at)
                      {{ date('Y-m-d', strtotime($movieslist->converted_for_streaming_at)) }}<br>{{$movieslist->converted_for_streaming_at->format('H:i:s')}}
                      @else
                      No
                      @endif
                      </td>
                      <td>
                        @if($movieslist->processed == '0')
                        No Video File
                        @elseif($movieslist->processed == '1')
                        Done Uploaded
                        @else
                        No
                        @endif
                      </td>
                     <td>
                     <button type="submit" class="btn btn-light"  data-toggle="modal" data-target="#play{{$movieslist->id}}"><i class="fa fa-play" aria-hidden="true"></i></button>
                     <!-- Modal -->
                     <div class="modal fade" id="play{{$movieslist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                             <!----------------->
                              <div class="card-body">
                                @if($movieslist->processed == '0')
                                  <div class="alert alert-info w-100">
                                    No Video File
                                     <!-- Video is currently being processed and will be available shortly -->
                                  </div>
                                  @elseif($movieslist->processed == '1')
                                 <video id='hls-example{{$movieslist->id}}' oncontextmenu="return false;"  class="video-js vjs-default-skin" controls style="width: 100%; height: 400px;" >
                                    <source src="{{asset('/img/uploads/'.$movieslist->stream_path)}}" type="application/x-mpegURL">
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
                                  var player = videojs('hls-example'+{{$movieslist->id}}, options);
                                  player.httpSourceSelector();
                            </script>        
                               
                                 @else
                                  <div class="alert alert-info w-100">
                                    No Video
                                  </div>
                                 @endif
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
                <form method="POST" action="{{route('movieepisode.update',['moviename_id'=>$moviedata->id,'id'=>$movieslist->id])}}" enctype="multipart/form-data" id="formnameuploadupdate">
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
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Status</label>
                          <select class="form-control" name="status">
                         @if($moviedata->status == "Ongoing")
                           <option  selected value="Ongoing">{{$moviedata->status}}</option>
                           <option  value="Finished">Finished</option>
                         @elseif($moviedata->status == "Finished")
                           <option selected value="Finished">{{$moviedata->status}}</option> 
                           <option   value="Ongoing">Ongoing</option>
                         @else
                         <option></option>
                         <option  value="Ongoing">Ongoing</option>
                         <option  value="Finished">Finished</option> 
                         
                         @endif                                   
                         </select>                       
                       </div>
                     </div>
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Season</label>
                         
                          <input type="number" class="form-control" placeholder="Number" name="season_number" min="1" value="{{$movieslist->season_number}}">         
                       </div>
                     </div>  
                     <div class="col-md-4 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Episode</label>
                          <input type="number" class="form-control" placeholder="Number" name="episode_name" min="1" value="{{$movieslist->episode_name}}"> 
                        </div>
                     </div>    
                  </div>

                   <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Video Uploade File (*) .mp4 file only</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="video_file">
                          
                       </div>
                     </div>  
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                              @if($movieslist->processed == '0')
                                  <div class="alert alert-info w-100">
                                    No Video File
                                    <!--  Video is currently being processed and will be available shortly -->
                                  </div>
                                  @elseif($movieslist->processed == '1')
                                 <video id='hls-exampleedit{{$movieslist->id}}' oncontextmenu="return false;"  class="video-js vjs-default-skin" controls style="width: 100%; height: 400px;">
                                    <source src="{{asset('/img/uploads/'.$movieslist->stream_path)}}">
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
                                  var player = videojs('hls-exampleedit'+{{$movieslist->id}}, options);
                                  player.httpSourceSelector();
                            </script>        
                               
                                 @else
                                  <div class="alert alert-info w-100">
                                    No Video
                                  </div>
                                 @endif
                                
                       </div>
                     </div>  
                  </div>
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Encoded File </label>
                         <input type="file" class="form-control" placeholder="Picture"   name="encodednames[]"  multiple="multiple">
                          
                       </div>
                     </div>  
                   </div>
                   <div class="row" id="subtitle">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-server"></i> Subtitle  </label> <br>
                           <button class="btn btn-light"  style="color:white" type="button"  class="form-control"  id="addmyf{{$movieslist->id}}" onclick="myfadd{{$movieslist->id}}()" ><i class="icon-plus"></i> Add More</button>
                       <script type="text/javascript">
                         function myfadd{{$movieslist->id}}(){

                          var button = document. getElementById("addmyf{{$movieslist->id}}");
                          
                              i = 0;
                              button. onclick = function() {
                              i += 1;

                              document.getElementById("addmyf{{$movieslist->id}}").value= i;
                              $('#dynamic_fieldmyfmy{{$movieslist->id}}').append('<div class="row" id="row'+i+'"><div class="col-md-5 pr-md-1"><div class="form-group"><select class="form-control" name="subtitle_name[]"><option  value="English">English</option><option  value="Myanmar">Myanmar</option></select></div></div><div class="col-md-5 pr-md-1"><div class="form-group"><input type="file" class="form-control"  name="subtitle_file[]"></div></div><div class="col-md-2 pr-md-1"><div class="form-group"><button type="button" class="btn-remove btn btn-danger"  name="remove" id="'+i+'" ><i class="icon-close"></i></button></div></div></div></div>');
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

                     <!-- <div class="col-md-6 pr-md-1">
                       <div class="form-group">  -->
                      
                     <!--   </div> 
                     </div> -->
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

                 <!--  <div class="row">
                     <div class="col-md-5 pr-md-1">
                       <div class="form-group">                         
                          <input type="text" class="form-control" name="subtitle_name[]" placeholder="Enter Subtitle Name">
                        </div>
                     </div>  
                   
                       
                  </div> -->
                  
                  <div id="dynamic_fieldmyfmy{{$movieslist->id}}">
                    
                  </div>
                  
                  
              <div class="form-group" align="center">
                 <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button>
                <button class="btn btn-light" type="submit" ><i class="icon-event"></i> UPDATE</button>
              </div>
                </form>
        </div><!-----card body end-----> 
        <!----------------->
      
        </div><!--- modal-content end -->
          <div id="loadingDiv1"></div> 
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
                <form action="{{route('movieepisode.delete',['moviename_id'=>$moviedata->id,'id'=>$movieslist->id])}}" method="post">
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

  $('#formnameupload').submit(function() {
    $('#loadingDiv').show();
   
});
   $('#formnameuploadupdate').submit(function() {
    $('#loadingDiv1').show();
   
});
   //$('#sub').on('click',function(){
     // $('#loadingDiv').show();
   // });


 $(document).ready(function(){ 
    
    $("#alert").fadeOut(3000);

   
 
});
 
  
  function ff(){
        var button = document. getElementById("add"),

        i = 0;
        button. onclick = function() {
        i += 1;
        document.getElementById("add").value= i;
        $('#dynamic_field').append('<div class="row" id="row'+i+'"><div class="col-md-5 pr-md-1"><div class="form-group"><select class="form-control" name="subtitle_name[]"><option  value="English">English</option><option  value="Myanmar">Myanmar</option></select></div></div><div class="col-md-5 pr-md-1"><div class="form-group"><input type="file" class="form-control"  name="subtitle_file[]"></div></div><div class="col-md-2 pr-md-1"><div class="form-group"><button type="button" class="btn-remove btn btn-danger"  name="remove" id="'+i+'" ><i class="icon-close"></i></button</div></div></div></div>');
      $(document).on('click','.btn-remove',function(){

        var button_id = $(this).attr('id');
         //alert(button_id);
        $("#row"+button_id).remove();
      });
    };

  }

 
  
 </script>
 
 
 @endsection