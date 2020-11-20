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
     <div class="card-header" align="center"><i class="icon-user"></i> <i class="icon-list"></i>  HISTORY LIST </div>
     <div class="card-body">      
    
       
      <form class="search-bar" style="float: right" action="{{route('history.search')}}" method="get">
       {{csrf_field()}}
        <input type="text" class="form-control" placeholder="Enter keywords" name="search" value="{{$s}}">
         <a href="javascript:void();" type="submit"><i class="icon-magnifier"></i></a>        
      </form>
      </div>
    <!----card body start------>
     <div class="card-body">
       @if($historylistsall->count() <= 0)
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
                   	 <th>No.</th>
                     <th>Name</th>
                     <th>Content</th>                     
                     <!-- <th>Type</th>  -->                    
                     <th>Update</th>
                     
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($historylists as $key=>$history) 
                    <tr>
                      <td>{{$historylists->firstItem() +$key}}</td>
                      <td>
                         <a href="{{route('adminhistory.list',['id'=>$history->admin->id])}}">{{$history->admin->name}}</a>
                       </td> 
                     	<td>{{$history->content}}</td>                                           
                     
                      <td>{{$history->updated_at}}</td>                    
                     </tr>
                     @endforeach
                  </tbody>
             </table>
            </div> <!--------------div table end ----->
           @endif
     </div><!-----card body end-----> 
     <div class="card-body" >
      <p style="float: right;">TOTAL {{$historylistsall->count()}} </p>   
       {{ $historylists->appends(Request::only('search'))->links() }} 
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 @endsection
 @section('script')
 
 </script>
 @endsection