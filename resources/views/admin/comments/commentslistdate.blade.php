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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="fa fa-history"></i>  HISTORY LIST </div>
     <div class="card-body">
      
    
     	 
     	<form class="search-bar" style="float: right" action="{{route('commentsearchdate',['date'=>$date])}}" method="get">
     	 {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
         </form>
     </div>
    <!----card body start------>
     <div class="card-body">
      
        @if($commentslistsall->count() <= 0)
       <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <label>There is no data in History List</label>
               
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
                   	<th>Date</th>
                   	<th>Name</th>
                   	<th>Reason</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($commentslists as $key=>$commentslist) 
                   <tr>
                   	<td>{{$commentslists->firstItem() +$key}}</td>
                   	<td> {{ date('Y-m-d', strtotime($commentslist->updated_at)) }}<br>{{$commentslist->updated_at->format('H:i:s')}} </td>
                   	<td>{{$commentslist->userS->name}}</td>
                   	<td> {{$commentslist->content}} </td>
                   </tr>
                   @endforeach
                   </tbody>
           </table>
          </div> <!--------------div table end ----->
       @endif
     </div><!-----card body end-----> 
      <div class="card-body" >
         
      <p style="float: right;">TOTAL {{$commentslistsall->count()}}</p>   
       {{ $commentslists->appends(Request::only('search'))->links() }} 
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 
 @endsection