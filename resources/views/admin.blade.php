@extends('admin.layouts.master')

@section('stylesheet')
<style type="text/css">
.float-left
{
  margin-right: 5px;
}
li.lineheightstyle{ line-height: 2.5; }
</style>
@endsection
@section('content')

<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">

           <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                <!--  <span class="float-left">User <i class="fa fa-user"></i></span>  --> <h5 class="text-white mb-0" > Today Register</h5>
                  <ul>
                    
                  </ul>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:55%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">User <span class="float-right">{{$todayusers->count()}}  <i class="fa fa-user"></i></span></p>
                   
                </div>
            </div>
           
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                <!--  <span class="float-left">User <i class="fa fa-user"></i></span>  --> <h5 class="text-white mb-0" > </h5>
                  <ul>
                    
                  </ul>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:55%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Total User <span class="float-right">{{$users->count()}}  <i class="fa fa-user"></i></span></p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                <!--  <span class="float-left">User <i class="fa fa-user"></i></span>  --> <h5 class="text-white mb-0" > </h5>
                  <ul>
                    
                  </ul>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:55%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Active User <span class="float-right">{{$activeusers->count()}}  <i class="fa fa-user"></i></span></p>
                   <p class="mb-0 text-white small-font">Inactive User <span class="float-right">{{$inactiveusers->count()}}  <i class="fa fa-user"></i></span></p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                <!--  <span class="float-left">User <i class="fa fa-user"></i></span>  --> <h5 class="text-white mb-0" > </h5>
                  <ul>
                    
                  </ul>
                    <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:55%"></div>
                    </div>
                  <p class="mb-0 text-white small-font">Free User <span class="float-right">{{$freeusers->count()}}  <i class="fa fa-user"></i></span></p>
                   <p class="mb-0 text-white small-font">Premier User <span class="float-right">{{$preusers->count()}}  <i class="fa fa-user"></i></span></p>
                </div>
            </div>

            
           
        </div>
    </div>
 </div>  


<div class="card mt-3">
    <div class="card-content">
        <div class="row row-group m-0">
          @foreach($categories as $category)
            <div class="col-12 col-lg-6 col-xl-3 border-light">
                <div class="card-body">
                 <span class="float-left"><i class="fa fa-film"></i></span>  <h5 class="text-white mb-0" >  {{$category->name}} </h5>
                  <ul>
                    <?php $subcategories=DB::table('sub_categories')->where('category_id',$category->id)->orderBy('name','asc')->get(); ?>
                    @foreach($subcategories as $subcategory)
                    <?php $movienames=DB::table('movie_names')->where('subcategory_id',$subcategory->id)->where('category_id',$category->id)->count(); ?>
                    <li class="lineheightstyle">{{$subcategory->name}} - {{$movienames}}</li>
                    @endforeach
                  </ul>
                   <!--  <div class="progress my-3" style="height:3px;">
                       <div class="progress-bar" style="width:55%"></div>
                    </div> -->
                <!--   <p class="mb-0 text-white small-font">Total  <span class="float-right">+4.2% <i class="zmdi zmdi-long-arrow-up"></i></span></p> -->
                </div>
            </div>
            @endforeach
         
        </div>
    </div>
 </div>  

 
    
   <div class="row">
   <!--   <div class="col-12 col-lg-8 col-xl-8">
      <div class="card">
     <div class="card-header">Site Traffic
       <div class="card-action">
       <div class="dropdown">
       <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
        <i class="icon-options"></i>
       </a>
        <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="javascript:void();">Action</a>
        <a class="dropdown-item" href="javascript:void();">Another action</a>
        <a class="dropdown-item" href="javascript:void();">Something else here</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void();">Separated link</a>
         </div>
        </div>
       </div>
     </div>
     <div class="card-body">
        <ul class="list-inline">
        <li class="list-inline-item"><i class="fa fa-circle mr-2 text-white"></i>New Visitor</li>
        <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>Old Visitor</li>
      </ul>
      <div class="chart-container-1">
        <canvas id="chart1"></canvas>
      </div>
     </div>
     
     <div class="row m-0 row-group text-center border-top border-light-3">
       <div class="col-12 col-lg-4">
         <div class="p-3">
           <h5 class="mb-0">45.87M</h5>
         <small class="mb-0">Overall Visitor <span> <i class="fa fa-arrow-up"></i> 2.43%</span></small>
         </div>
       </div>
       <div class="col-12 col-lg-4">
         <div class="p-3">
           <h5 class="mb-0">15:48</h5>
         <small class="mb-0">Visitor Duration <span> <i class="fa fa-arrow-up"></i> 12.65%</span></small>
         </div>
       </div>
       <div class="col-12 col-lg-4">
         <div class="p-3">
           <h5 class="mb-0">245.65</h5>
         <small class="mb-0">Pages/Visit <span> <i class="fa fa-arrow-up"></i> 5.62%</span></small>
         </div>
       </div>
     </div>
     
    </div>
   </div> -->

     <div class="col-12 col-lg-12 col-xl-12">
        <div class="card">
           <div class="card-header">Today Advertising
            <!--  <div class="card-action">
             <div class="dropdown">
           <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();">Action</a>
              <a class="dropdown-item" href="javascript:void();">Another action</a>
              <a class="dropdown-item" href="javascript:void();">Something else here</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void();">Separated link</a>
               </div>  
              </div>
             </div> -->
           </div>
           <!-- <div class="card-body">
         <div class="chart-container-2">
               <canvas id="chart2"></canvas>
        </div>
           </div> -->
           @if($adslistsall->count() <= 0)
           <div class="card-body">
             No Advertising To Show For Today
           </div>
           @else
          
           <div class="table-responsive">
             <table class="table align-items-center">
               <tbody>
                
                  <tr>
                    <th><i class="fa fa-circle text-white mr-2"></i>No</th>
                    <th>Company</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Time(Seconds)</th>
                    <th>Type</th>
                  </tr>
 
                 @foreach($adslists as $key=>$adslist) 
                 <tr>
                   <td><i class="fa fa-circle text-white mr-2"></i>  {{$adslists->firstItem() +$key}}</td>
                   <td>{{$adslist->company_name}}</td>
                   <td>{{$adslist->from_date}}</td>
                   <td>{{$adslist->to_date}}</td>
                   <td>{{$adslist->display_time}}</td>
                   <td>{{$adslist->display_type}}</td>
                   
                 </tr>
                @endforeach
               
             </table>
           </div>
            <div class="card-body" >
              <p style="float: right;">Total {{$adslistsall->count()}}</p>
           {{$adslists->links()}}
            @endif
           </div>
         
        
     </div>
  </div> <!--End Row
  
 <div class="row">
   <div class="col-12 col-lg-12">
     <div class="card">
       <div class="card-header">Recent Order Tables
      <div class="card-action">
             <div class="dropdown">
             <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
             </a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:void();">Action</a>
              <a class="dropdown-item" href="javascript:void();">Another action</a>
              <a class="dropdown-item" href="javascript:void();">Something else here</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void();">Separated link</a>
               </div>
              </div>
             </div>
     </div>
         <div class="table-responsive">
                 <table class="table align-items-center table-flush table-borderless">
                  <thead>
                   <tr>
                     <th>Product</th>
                     <th>Photo</th>
                     <th>Product ID</th>
                     <th>Amount</th>
                     <th>Date</th>
                     <th>Shipping</th>
                   </tr>
                   </thead>
                   <tbody><tr>
                    <td>Iphone 5</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405822</td>
                    <td>$ 1250.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 90%"></div>
                        </div></td>
                   </tr>

                   <tr>
                    <td>Earphone GL</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405820</td>
                    <td>$ 1500.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 60%"></div>
                        </div></td>
                   </tr>

                   <tr>
                    <td>HD Hand Camera</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405830</td>
                    <td>$ 1400.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 70%"></div>
                        </div></td>
                   </tr>

                   <tr>
                    <td>Clasic Shoes</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405825</td>
                    <td>$ 1200.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                        </div></td>
                   </tr>

                   <tr>
                    <td>Hand Watch</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405840</td>
                    <td>$ 1800.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 40%"></div>
                        </div></td>
                   </tr>
           
           <tr>
                    <td>Clasic Shoes</td>
                    <td><img src="https://via.placeholder.com/110x110" class="product-img" alt="product img"></td>
                    <td>#9405825</td>
                    <td>$ 1200.00</td>
                    <td>03 Aug 2017</td>
          <td><div class="progress shadow" style="height: 3px;">
                          <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                        </div></td>
                   </tr>

                 </tbody></table>
               </div>
     </div>
   </div>
  </div> --><!--End Row-->
@endsection