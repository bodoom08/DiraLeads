@extends('common.layout')

@section('content')  

<div class="explore-content-box">
   <div class="container-fluid">
      <div class="inner-content-box">
         <div class="row">
          <div class="col-md-12">
            
         </div>
               @if(intval(count($propertiea_counts)) < 1)  <div class="row" id="norecord">
                  <div class="col-lg-12 text-center mt-5">
                      <h4>You have no rentals marked as Favorite, you can add rentals to Your Favorites by clicking on the rental's Favorite icon
                      </h4>
                  </div>
              </div>
            @else
            @foreach ($propertiea_counts as $key=>$value)
           <div class="col-md-4 col-lg-4">
               <div class="item">
                     <div class="feat_property custome_area" style="height:auto">
                        <div class="thumb">
                       
                        <img class="img-whp" src="assets/images/gal2.png"
                        alt="properties" />
                      
                        <div class="thmb_cntnt">
                        <p>{{$value}}</p> <p>{{$key}}</p>
                        </div>
                        </div>
                  </div>
               
               </div>
            </div>
            @endforeach
            @endif
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div
@endsection