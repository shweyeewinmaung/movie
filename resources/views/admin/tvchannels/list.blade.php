@extends('admin.layouts.master')

@section('stylesheet')
<link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.css" rel="stylesheet">
<script src="https://vjs.zencdn.net/7.2.3/video.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-hls-source-selector@1.0.1/dist/videojs-http-source-selector.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/videojs-contrib-quality-levels@2.0.9/dist/videojs-contrib-quality-levels.min.js"></script>

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
     <div class="card-header" align="center"><i class="fa fa-television"></i> TV CHANNEL LIST </div>
     <div class="card-body">
       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#tvchannelstore"><i class="icon-plus"></i> Add New</button>
       <!-- Modal -->
     <div class="modal fade" id="tvchannelstore" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="fa fa-television"></i> TV CHANNEL ENTRY 
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="post" action="{{route('tvchannel.store')}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-television"></i> Name</label>
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
                         <label ><i class="fa fa-server"></i> TV Category</label>
                         <select class="form-control" name="tvcategory_id">
		                   <option selected value="" >Click here to choose</option>
		                   @foreach($tvcategories as $tvcategory)
		                    <option value="{{$tvcategory->id}}" >{{$tvcategory->name}}</option>   
		                   @endforeach
		               </select>
                      @if ($errors->has('tvcategory_id'))
                           <label class="alerttext">{{ $errors->first('tvcategory_id') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div> 
                   <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-television"></i> TV CHANNEL PICTURE</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="channel_image">
                          @if ($errors->has('channel_image'))
                      <label class="alerttext">{{ $errors->first('channel_image') }}</label>
                    @endif
                       </div>
                     </div>  
                  </div>
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> CHANNEL API</label>
                          <textarea class="form-control"  name="channel_api"></textarea>
                           @if ($errors->has('channel_api'))
                            <label class="alerttext">{{ $errors->first('channel_api') }}</label>
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
    
     	 
     	<form class="search-bar" style="float: right" action="{{route('tvchannel.search')}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
      @if($tvchannellistsall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in TV Channel List</label>
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
                     <th>TV Category</th>
                     
                     <th>Play</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                    @foreach($tvchannellists as $key=>$tvchannellist)
                   	<tr>
                   		<td>{{$tvchannellists->firstItem() +$key}}</td>
                   		<td> <img class="image" src="{{asset('/images/tvchannels/'.$tvchannellist->channel_image)}}" alt=""></td>
                   		<td>{{$tvchannellist->name}}</td>
                   		<td>{{$tvchannellist->tvcategories->name}}</td>

                   		<td>
                   			     <button type="submit" class="btn btn-light"  data-toggle="modal" data-target="#play{{$tvchannellist->id}}"><i class="fa fa-play" aria-hidden="true"></i></button>

                   			      <!-- Modal -->
                     <div class="modal fade" id="play{{$tvchannellist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                          <div class="modal-body">
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                             <!----------------->
                              <div class="card-body">
                                
                                 <video id='hls-example{{$tvchannellist->id}}' oncontextmenu="return false;"  class="video-js vjs-default-skin" controls style="width: 100%; height: 400px;" >
                                    <source src="{{$tvchannellist->channel_api}}" type="application/x-mpegURL">
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
                                  var player = videojs('hls-example'+{{$tvchannellist->id}}, options);
                                  player.httpSourceSelector();
                            </script>        
                               
                                
                              </div><!-----card body end-----> 
                            <!----------------->
                            </div><!--modal-body end-->
                     
                            </div><!--- modal-content end -->
                          </div><!-----modal-dialog end-------->
                         </div><!----modal fade end --->
                         <!---------modal end --->  
                   		</td>
                   		<td>
                   			 <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#edit{{$tvchannellist->id}}" title="Edit"><i class="icon-event"></i></button>

                   			   <!-- Modal -->
     <div class="modal fade" id="edit{{$tvchannellist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="fa fa-television"></i> TV CHANNEL UPDATE FOR {{$tvchannellist->name}} 
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="post" action="{{route('tvchannel.update',['id'=>$tvchannellist->id])}}" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-television"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name" value="{{$tvchannellist->name}}">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div>
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label ><i class="fa fa-server"></i> TV Category</label>
                         <select class="form-control" name="tvcategory_id">
		                   <option selected value="{{$tvchannellist->tvcategory_id}}" >{{$tvchannellist->tvcategories->name}}</option>
		                   @foreach($tvcategories as $tvcategory)
		                   @if($tvcategory->id != $tvchannellist->tvcategory_id)
		                    <option value="{{$tvcategory->id}}" >{{$tvcategory->name}}</option>   
		                    @endif
		                   @endforeach
		               </select>
                      @if ($errors->has('tvcategory_id'))
                           <label class="alerttext">{{ $errors->first('tvcategory_id') }}</label>
                          @endif
                       </div>
                     </div>  
                  </div> 
                   <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-television"></i> TV CHANNEL PICTURE</label>
                         <input type="file" class="form-control" placeholder="Picture"  name="channel_image">
                          @if ($errors->has('channel_image'))
                      <label class="alerttext">{{ $errors->first('channel_image') }}</label>
                    @endif
                       </div>
                     </div>  
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                        <img class="image1" src="{{asset('/images/tvchannels/'.$tvchannellist->channel_image)}}" alt="">
                       </div>
                     </div>  
                  </div>
                    <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label class="form-group"><i class="fa fa-server"></i> CHANNEL API</label>
                          <textarea class="form-control"  name="channel_api">{{$tvchannellist->channel_api}}</textarea>
                           @if ($errors->has('channel_api'))
                            <label class="alerttext">{{ $errors->first('channel_api') }}</label>
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
                   			  <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$tvchannellist->id}}" title="Delete"><i class="icon-close"></i></button>
                   			    <!-- Modal -->
     <div class="modal fade" id="delete{{$tvchannellist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-television"></i> CHANNEL NAME DELETE FOR {{$tvchannellist->name}}
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('tvchannel.delete',['id'=>$tvchannellist->id])}}" method="post">
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
        <p style="float: right;">TOTAL {{$tvchannellistsall->count()}} </p>   
       {{ $tvchannellists->appends(Request::only('search'))->links() }} 
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