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
  select option {
    background: #ccc;
}
.btn {
  
    color: #ca8e8b;
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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  USER LIST </div>
     <div class="card-body">
      
     	 
     	<form class="search-bar" style="float: right" action="{{route('user.search')}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
       @if($usersall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in User List</label>
               
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
                     <th>Code</th>
                     <th>Email</th>
                     <th>Provider-ID</th>
                     <th>Provider</th>

                     <th>Type</th>
                     <th>Status</th>
                     <th>Start Date</th>
                     <th>End Date</th>
                     
                     <th>Change Password</th>
                     
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                   	 @foreach($userslists as $key=>$userslist) 
	                   <tr>
	                   	<td>{{$userslists->firstItem() +$key}}</td>
	                   	<td>{{$userslist->name}}</td>
	                   	<td>{{$userslist->user_code}}</td>
	                    <td>{{$userslist->email}}</td>
	                   	<td>{{$userslist->provider_id}}</td>
	                    <td>{{$userslist->provider}}</td>

	                    @foreach($userslist->typeuser as $type)
	                   	<td>
	                   		 <form action="{{route('usertypesupdate',['id'=>$type->id])}}" style="float: right;" method="POST">
                               {{csrf_field()}}
	                   		<select  name="typeofuser" >
				               @if($type->typeofuser == "free")
				                 <option  selected value="free">free</option>
				                 <option  value="premier">premier</option>
				               @else
				                 <option selected value="premier">premier</option> 
				                 <option   value="free">free</option>
				               @endif                     
				             </select>   
	                   		<button type="submit" class="btn"  ><i class="icon-plus"></i></button>
	                   	</form>
	                   		</td>
	                    <td>
	                    	<form action="{{route('userstatusupdate',['id'=>$type->id])}}" style="float: right;" method="POST">
                               {{csrf_field()}}
	                   		<select  name="status" >
				               @if($type->status == "active")
				                 <option  selected value="active">active</option>
				                 <option  value="inactive">inactive</option>
				               @else
				                 <option selected value="inactive">inactive</option> 
				                 <option   value="active">active</option>
				               @endif                     
				             </select>   
	                   		<button type="submit" class="btn"  ><i class="icon-plus"></i></button>
	                   	</form>
	                   	</td>	                   
	                   	<td>
	                   		@if($type->start_date != null)
	                   		{{$type->start_date}}
	                   		@else
	                   		-
	                   		@endif
	                   	</td>
	                   	<td>
	                   		@if($type->end_date != null)
	                   		{{$type->end_date}}
	                   		@else
	                   		-
	                   		@endif
	                   	</td>
	                   	@endforeach
	                   
	                   	<td>
	                   		<form action="{{route('changepassword',['id'=>$userslist->id])}}" style="float: right;" method="POST">
                               {{csrf_field()}}
                               <button type="submit" class="btn btn-light"  ><i class="icon-lock"></i> Default</button>
	                   		 </form>
	                   	</td>
	                    
	                   	<td>
	                   		 <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$userslist->id}}" title="Delete"><i class="icon-close"></i></button>
                 <!-- Modal -->
     <div class="modal fade" id="delete{{$userslist->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> <i class="fa fa-server"></i> USER DELETE FOR {{$userslist->name}} 
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{route('userfor.delete',['id'=>$userslist->id])}}" method="post">
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
        <p style="float: right;">TOTAL {{$usersall->count()}}</p>   
       {{ $userslists->appends(Request::only('search'))->links() }} 
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