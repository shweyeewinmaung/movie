@extends('admin.layouts.master')
@section('title','TrueNet')
@section('stylesheet')
<style type="text/css">
  .alerttext{
    color:#3e051e;
  }
</style>
@endsection
@section('content')

  <div class="row ">
     <div class="col-lg-7 offset-2" ><!--  <div class="col-lg-12 col-xl-12"> -->
      <div class="card">
     <div class="card-header" align="center"><i class="icon-user"></i> USER REGISTER <i class="icon-user-female"></i> </div>
    <!----card body start------>
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
                   <option value="admin" >Admin</option>   
                   <option value="store">Store</option>  
                   <option value="staff">Staff</option>   
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
           <button type="submit" class="btn btn-light px-5" ><i class="icon-lock"></i> Register</button>
          </div>
         </form>
        </div><!-----card body end-----> 
        <!-- <div class="card-footer"> -->
          
        <!-- </div> -->
    </div><!-----card End---->
   </div><!-----col12 End-------------->

    
  </div><!--End Row-->
  
 
@endsection