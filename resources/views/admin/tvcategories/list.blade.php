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
     <div class="card-header" align="center"><i class="fa fa-television"></i> <i class="zmdi zmdi-format-list-bulleted"></i> TV CATEGORY LIST </div>
     <div class="card-body">
       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#tvcategorystore"><i class="icon-plus"></i> Add New</button>
       <!-- Modal -->
     <div class="modal fade" id="tvcategorystore" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="fa fa-television"></i> <i class="zmdi zmdi-format-list-bulleted"></i> TV CATEGORY ENTRY 
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="post" action="{{route('tvcategory.store')}}" >
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
		          <div class="form-group" align="center">
		           <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal" type="reset">Cancel</button> -->
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
    
     	 
     	<form class="search-bar" style="float: right" action="{{route('tvcategory.search')}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
       @if($tvcategorylistsall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in TV Channel Category List</label>
               
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
                     <th>Name</th>
                     
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($tvcategorylists as $key=>$tvcategorylist) 
                   <tr>
                   	<td>{{$tvcategorylists->firstItem() +$key}} </td>
                    <td>{{$tvcategorylist->name}}</td>
                    <td> 
                      <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#edit{{$tvcategorylist->id}}" title="Edit"><i class="icon-event"></i></button>
                      <!-- Modal -->
                      <div class="modal fade" id="edit{{$tvcategorylist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-scrollable" role="document">
                         <div class="modal-content">
                           <div class="card-header" align="center">
                             <i class="fa fa-television"></i> <i class="zmdi zmdi-format-list-bulleted"></i> TV CATEGORY UPDATE <i class="icon-user-female"></i>
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                            </div><!--- card-header -->
          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
               <form method="post" action="{{route('tvcategory.edit',['id'=>$tvcategorylist->id])}}" >
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-12 pr-md-1">
                       <div class="form-group">
                         <label><i class="fa fa-television"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name" value=" {{$tvcategorylist->name}}">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>
                    
                  </div> 
               <div class="form-group" align="center">
                <button class="btn btn-light" type="button" data-dismiss="modal" ><i class="fa fa-times"></i> Close</button> 
               	<button class="btn btn-light" type="submit" ><i class="icon-event"></i> UPDATE</button>
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
                <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$tvcategorylist->id}}" title="Delete"><i class="icon-close"></i></button>
                 <!-- Modal -->
     <div class="modal fade" id="delete{{$tvcategorylist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="fa fa-television"></i> <i class="zmdi zmdi-format-list-bulleted"></i> TV CATEGORY DELETE <i class="icon-user-female"></i>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('tvcategory.delete',['id'=>$tvcategorylist->id])}}" method="post">
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
        <p style="float: right;">TOTAL {{$tvcategorylistsall->count()}}</p>   
       {{ $tvcategorylists->appends(Request::only('search'))->links() }} 
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