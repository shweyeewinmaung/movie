@extends('admin.layouts.master')
@section('title','TrueNet')
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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  ADMIN LIST </div>
     <div class="card-body">
       <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#register"><i class="icon-plus"></i> Add New</button>

    <!-- Modal -->
     <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        	<div class="card-header" align="center">
        		<i class="icon-user"></i> ADMIN REGISTER <i class="icon-user-female"></i>
        		<button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
        	</div><!--- card-header -->
        	
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form method="post" action="{{route('admin.register.submit')}}" >
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="icon-user"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>
                     <div class="col-md-6 px-md-1">
                       <div class="form-group">
                         <label> <i class="icon-envelope"></i> Email</label>
                         <input type="email" class="form-control" placeholder="Email" name="email">
                          @if ($errors->has('email'))
                           <label class="alerttext">{{ $errors->first('email') }}</label>
                          @endif
                       </div>
                     </div>
                  </div>
          <div class="row">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <label><i class="icon-lock"></i> Password</label>
                <input type="text" class="form-control" placeholder="Password" name="password">
              </div>
            </div>
            <div class="col-md-6 px-md-1">
              <div class="form-group">
                <label><i class="icon-list"></i> Position</label>
               <!--  <input type="text" class="form-control" placeholder="Position"  > -->
               <select class="browser-default custom-select dropdown-primary" name="job_title">
                   <option selected value="" >Click here to choose Job</option>
                   <option value="admin" >admin</option>   
                   <option value="store">store</option>  
                   <option value="staff">staff</option>   
               </select>
                @if ($errors->has('job_title'))
                   <label class="alerttext">{{ $errors->first('job_title') }}</label>
                @endif
              </div>
            </div>
           </div>
           <div class="row">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <label><i class="fa fa-map-marker"></i> City</label>
                <input type="text" class="form-control" placeholder="City" name="city">
              </div>
            </div>
            <div class="col-md-6 px-md-1">
              <div class="form-group">
                <label><i class="fa fa-map-marker"></i> Township</label>
                <input type="text" class="form-control" placeholder="Township" name="township">
              </div>
            </div>
           </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><i class="icon-home"></i> Address</label>
                <textarea rows="4" cols="80" class="form-control" placeholder="Address"  name="address"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group" align="center">
           <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal" type="reset">Cancel</button> -->
           <button class="btn btn-light" type="submit" ><i class="icon-lock"></i> Register</button>
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
     	 
     	<form class="search-bar" style="float: right" action="{{route('search')}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
      </form>
     	</div>
    <!----card body start------>
     <div class="card-body">
      @if($adminlistsall->count() <= 0)
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
                     <th>Email</th>
                     <th>Position</th>
                     <th>City</th>
                     <th>History</th>
                     <th>View</th>
                     <th>Edit</th>
                     <th>Delete</th>
                   </tr>
                   </thead>
                   <tbody>
                   	@foreach($adminlists as $key=>$admin)
                      
                   <tr>
                   	<td>{{$adminlists->firstItem() +$key}}</td>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{$admin->job_title}}</td>
                    <td>{{$admin->city}}</td>
                    
                    <td>
                      <a href=""><button type="button" class="btn btn-light" title="History"><i class="zmdi zmdi-invert-colors"></i></button></a>
                      
                    </td>
                    <td>
                      <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#show{{$admin->id}}" title="View"><i class="zmdi zmdi-eye"></i></button>

                      <!-- Modal -->
                      <div class="modal fade" id="show{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                           <div class="card-header" align="center">
                            <i class="icon-user"></i> ADMIN PROFILE <i class="icon-user-female"></i>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                           </div><!--- card-header -->         
            
                            <div class="modal-body">
                            <!----------------->
                              <div class="card-body">
                                <div class="row">
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="icon-user"></i> Name</h5>
                                       <label> {{$admin->name}}</label>
                                     </div>
                                   </div>
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="icon-envelope"></i> Email</h5>
                                       <label> {{$admin->email}}</label>
                                     </div>
                                   </div>
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="icon-list"></i> Position</h5>
                                       <label> {{$admin->job_title}}</label>
                                     </div>
                                   </div>
                                </div>
                                <div class="row">
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="fa fa-map-marker"></i> City</h5>
                                       <label> {{$admin->city}}</label>
                                     </div>
                                   </div>
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="fa fa-map-marker"></i> Township</h5>
                                       <label> {{$admin->township}}</label>
                                     </div>
                                   </div>
                                   <div class="col-md-4 pr-md-1">
                                     <div class="form-group">
                                       <h5><i class="icon-home"></i> Address</h5>
                                       <label> {{$admin->address}}</label>
                                     </div>
                                   </div>
                                </div>

           
                              </div><!-----card body end----->             
                            <!----------------->
                            </div><!--modal-body end-->

                            <div class="modal-footer">
                             <div class="form-group" align="center">
                               <button class="btn btn-light" type="button" data-dismiss="modal"><i class="icon-close"></i> Close</button>
                                
                             </div>              
                            </div>           
                        </div><!--- modal-content end -->
                        </div><!-----modal-dialog end-------->
                      </div><!----modal fade end --->
                      <!---------modal end --->

                    </td>
                    <td> 
                      <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#edit{{$admin->id}}" title="Edit"><i class="icon-event"></i></button>
                      <!-- Modal -->
                      <div class="modal fade" id="edit{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-scrollable" role="document">
                         <div class="modal-content">
                           <div class="card-header" align="center">
                             <i class="icon-user"></i> ADMIN UPDATE <i class="icon-user-female"></i>
                             <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
                            </div><!--- card-header -->
          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
               <form method="post" action="{{route('admin.edit.submit',['id'=>$admin->id])}}" >
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
       
      
                  <div class="row">
                     <div class="col-md-6 pr-md-1">
                       <div class="form-group">
                         <label><i class="icon-user"></i> Name</label>
                         <input type="text" class="form-control" placeholder="Name" name="name" value="{{$admin->name}}">
                          @if ($errors->has('name'))
                           <label class="alerttext">{{ $errors->first('name') }}</label>
                          @endif
                       </div>
                     </div>
                     <div class="col-md-6 px-md-1">
                       <div class="form-group">
                         <label> <i class="icon-envelope"></i> Email</label>
                         <input type="email" class="form-control" placeholder="Email" name="email" value="{{$admin->email}}">
                          @if ($errors->has('email'))
                           <label class="alerttext">{{ $errors->first('email') }}</label>
                          @endif
                       </div>
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label><i class="icon-lock"></i> Password</label>
                        <input type="text" class="form-control" placeholder="Password" name="password" value="">
                        
                      </div>
                    </div>
                    <div class="col-md-6 px-md-1">
                      <div class="form-group">
                        <label><i class="icon-list"></i> Position</label><br>
                      
                       <select class=" custom-select " name="job_title">
                           <option value="{{$admin->job_title}}" >{{$admin->job_title}}</option>   
                           <option value="admin" >admin</option>   
                           <option value="store">store</option>  
                           <option value="staff">staff</option>   
                       </select>
                        @if ($errors->has('job_title'))
                           <label class="alerttext">{{ $errors->first('job_title') }}</label>
                        @endif
                      </div>
                    </div>
                   </div>
          
           <div class="row">
            <div class="col-md-6 pr-md-1">
              <div class="form-group">
                <label><i class="fa fa-map-marker"></i> City</label>
                <input type="text" class="form-control" placeholder="City" name="city" value="{{$admin->city}}">
              </div>
            </div>
            <div class="col-md-6 px-md-1">
              <div class="form-group">
                <label><i class="fa fa-map-marker"></i> Township</label>
                <input type="text" class="form-control" placeholder="Township" name="township" value="{{$admin->township}}">
              </div>
            </div>
           </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><i class="icon-home"></i> Address</label>
                <textarea rows="4" cols="80" class="form-control" placeholder="Address"  name="address">{{$admin->address}}</textarea>
              </div>
            </div>
          </div>
          <div class="form-group" align="center">
           <!-- <button class="btn btn-secondary" type="button" data-dismiss="modal" type="reset">Cancel</button> -->
           <button class="btn btn-light" type="submit" ><i class="icon-event"></i> UPDATE</button>
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
              <td>
                <button type="submit" class="btn btn-light" style="float: left" data-toggle="modal" data-target="#delete{{$admin->id}}" title="Delete"><i class="icon-close"></i></button>
                 <!-- Modal -->
     <div class="modal fade" id="delete{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="card-header" align="center">
            <i class="icon-user"></i> ADMIN DELETE <i class="icon-user-female"></i>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="float:right;"><spanstyle="color:red">x</span></button>
          </div><!--- card-header -->          
            
            <div class="modal-body">
             <!----------------->
              <div class="card-body">
                <form action="{{action('AdminController@destory',$admin->id)}}" method="post">
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
      <p style="float: right;">TOTAL {{$adminlistsall->count()}} ADMINS</p>   
       {{ $adminlists->appends(Request::only('search'))->links() }} 
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