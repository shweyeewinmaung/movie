@extends('admin.layouts.master')

@section('stylesheet')
<style type="text/css">
  .alerttext{
    color:#3e051e;
  }
</style>
@endsection
@section('content')

  <div class="row ">
     <div class="col-lg-12" ><!--  <div class="col-lg-12 col-xl-12"> -->
      <div class="card">
     <div class="card-header" align="center"><i class="zmdi zmdi-invert-colors"></i> USER HISTORY <i class="icon-user-female"></i> </div>
    <!----card body start------>
     <div class="card-body">
        
      
           <div class="row">
            <div class="col-md-12 pr-md-1">
              <div class="form-group">
                <h5>Name ::: <font>{{$admin->name}} </font></h5>
                
                 @if($comments->count() <= 0 || $comments == null)
                   <div class="row">
                        <div class="col-md-12 pr-md-1">
                          <div class="form-group">
                            <label>There is no data in User History List</label>
                            </div>
                        </div>
                        
                      </div>
                  @else
                  <div class="row">
                      @foreach($comments as $key=>$comment)
                      
                           
                            <div class="col-md-1 pr-md-1">
                              <div class="form-group">                          
                                <label>No.{{$comments->firstItem() +$key}}</label> 
                              </div>
                            </div>
                            <div class="col-md-3 pr-md-1">
                              <div class="form-group">                          
                                <p>Date :: {{$comment->created_at}}</p>                          
                                
                                </div>
                            </div>
                            <div class="col-md-8 pr-md-1">
                              <div class="form-group">                          
                                <p>{{$comment->content}}</p>                          
                                
                                </div>
                            </div>                       
                        


                      @endforeach  
                   </div>
                  @endif
              </div>
            </div>

        </div><!-----card body end-----> 
         <div class="card-body" >
      <p style="float: right;">TOTAL {{$commentsall->count()}} </p>   
       {{ $comments->links() }} 
      </div>
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 
@endsection