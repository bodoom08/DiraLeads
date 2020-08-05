@extends('common.layout')

@push('styles')
<style>
.floor-plans table td, table th {
    padding: 10px 15px;
    border-right: 1px solid rgba(0, 0, 0, 0.07);
    font-size: 16px;
}
</style>
@endpush

@section('content')

<!-- Properties details page start -->
<div class="properties-details-page content-area">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <!-- Heading properties 3 start -->
            <div class="heading-properties-3">
               <h1 class="mb-3">Relaxing Apartment</h1>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <!-- main slider carousel items -->
            <div id="propertiesDetailsSlider" class="carousel properties-details-sliders slide ">
               <div class="carousel-inner">
                  <div class="active item carousel-item" data-slide-number="0">
                     <img src="https://diraleads.com/assets/img/luxury-property.jpg" width="100%" alt="slider-properties">
                  </div>
                  <div class="item carousel-item" data-slide-number="1">
                     <img src="https://diraleads.com/assets/img/luxury-property.jpg" width="100%" alt="slider-properties">
                  </div>
                  <div class="item carousel-item" data-slide-number="2">
                     <img src="https://diraleads.com/assets/img/luxury-property.jpg" width="100%" alt="slider-properties">
                  </div>
                  <a class="carousel-control left" href="#propertiesDetailsSlider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                  <a class="carousel-control right" href="#propertiesDetailsSlider" data-slide="next"><i class="fa fa-angle-right"></i></a>
               </div>
               <div class="slider-pos">
                  <div class="form-bg">
                     <h4 class="text-center">More about this property</h4>
                     <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Your Name</label>
                        <div class="input-group mb-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text"><i class="fa fa-user"></i></div>
                           </div>
                           <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Your Name">
                        </div>
                     </div>
                     <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Email ID</label>
                        <div class="input-group mb-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                           </div>
                           <input type="email" class="form-control" id="inlineFormInputGroup" placeholder="Email ID">
                        </div>
                     </div>
                     <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Mobile No</label>
                        <div class="input-group mb-2">
                           <div class="input-group-prepend">
                              <div class="input-group-text"><i class="fa fa-phone"></i></div>
                           </div>
                           <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Mobile No">
                        </div>
                     </div>
                     <div class="col-auto">
                        <textarea class="form-control" style="min-height:100px;">
                        </textarea>
                     </div>
                     <div class="col-auto">
                        <button class="search-button">SEND</button>
                     </div>
                  </div>
               </div>
               <!-- main slider carousel items -->
            </div>
            <div class="property-box" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);">
               <ul class="facilities-list clearfix">
                  <li>
                     <img src="https://diraleads.com/assets/img/icon-6.png"> 3600 Sqft
                  </li>
                  <li>
                     <img src="https://diraleads.com/assets/img/icon-badroom.png"> 3
                  </li>
                  <li>
                     <img src="https://diraleads.com/assets/img/icon-8.png"> 2
                  </li>
                  <li>
                     <img src="https://diraleads.com/assets/img/icon-b-4.png"> 1
                  </li>
               </ul>
               <div class="row">
                  <div class="col-md-12">
                     <!-- Heading properties 3 start -->
                     <div class="heading-properties-3">
                        <div class="p-4">
                           <span class="rent">Apartments for Rent</span>
                           <div class="clearfix"></div>
                           <span class="property-price" style="font-size:28px; font-weight: 600;">$35,0000</span>
                           <span class="rent">/ Month</span>
                           <div class="clearfix"></div>
                           <span class="location"><i class="fa fa-map-marker"></i>123 Kathal St. Tampa City,</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Properties description start -->
            <div class="properties-description mb-40">
              
               <div class="accordion" id="accordion2">
                  <div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                        Property Details
                        </a>
                     </div>
                     <div id="collapseOne" class="accordion-body collapse">
                        <div class="accordion-inner">
                           <!-- Floor plans start -->
                           <div class="floor-plans mb-50">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><strong>Size</strong></td>
                                       <td><strong>Rooms</strong></td>
                                       <td><strong>Bathrooms</strong></td>
                                       <td><strong>Garage</strong></td>
                                    </tr>
                                    <tr>
                                       <td>1600</td>
                                       <td>3</td>
                                       <td>2</td>
                                       <td>1</td>
                                    </tr>
                                 </tbody>
                              </table>
                              <img src="https://diraleads.com/assets/img/floor-plans.png" alt="floor-plans" class="img-fluid">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                        Property Location
                        </a>
                     </div>
                     <div id="collapseTwo" class="accordion-body collapse">
                        <div class="accordion-inner">
                           <div class="location mb-50">
                              <div class="map">
                                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448183.73907005717!2d76.81307299667618!3d28.646677259922765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1565001207989!5m2!1sen!2sin" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapsethree">
                        Features 
                        </a>
                     </div>
                     <div id="collapsethree" class="accordion-body collapse">
                        <div class="accordion-inner">
                           <div class="properties-amenities mb-40">
                              <h3 class="heading-2">
                                 Features
                              </h3>
                              <div class="row">
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                       <li>
                                          <i class="fa fa-check"></i>Air conditioning
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Balcony
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Pool
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Room service
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Gym
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                       <li>
                                          <i class="fa fa-check"></i>Wifi
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Parking
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Double Bed
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Home Theater
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Electric
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <ul class="amenities">
                                       <li>
                                          <i class="fa fa-check"></i>Telephone
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Jacuzzi
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Alarm
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Garage
                                       </li>
                                       <li>
                                          <i class="fa fa-check"></i>Security
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapsefour">
                        Property Video 
                        </a>
                     </div>
                     <div id="collapsefour" class="accordion-body collapse">
                        <div class="accordion-inner">
                           <!-- Floor plans start -->
                           <iframe src="https://www.youtube.com/embed/5e0LxrLSzok" width="100%" height="350" allowfullscreen=""></iframe>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Properties amenities start -->
            
               <!-- Similar Properties start -->
               <h3 class="heading-2 mt-5">Similar Properties</h3>
               <div class="row similar-properties">
                  <div class="col-md-4">
                     <div class="property-box">
                        <div class="property-thumbnail">
                           <a href="#" class="property-img">
                              <div class="price-box">
                                 <h6>Apartments for Rent</h6>
                                 <span>$850.00</span> Per Month
                              </div>
                              <img class="d-block w-100" src="https://diraleads.com/assets/img/luxury-property.jpg" alt="properties">
                           </a>
                        </div>
                        <ul class="facilities-list clearfix">
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-6.png"> 3600 Sqft
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-badroom.png"> 3
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-8.png"> 2
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-b-4.png"> 1
                           </li>
                        </ul>
                        <div class="detail">
                           <div class="location">
                              <a href="properties-details.html">
                              <i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City,
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="property-box">
                        <div class="property-thumbnail">
                           <a href="#" class="property-img">
                              <div class="price-box">
                                 <h6>Apartments for Rent</h6>
                                 <span>$850.00</span> Per Month
                              </div>
                              <img class="d-block w-100" src="https://diraleads.com/assets/img/luxury-property.jpg" alt="properties">
                           </a>
                        </div>
                        <ul class="facilities-list clearfix">
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-6.png"> 3600 Sqft
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-badroom.png"> 3
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-8.png"> 2
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-b-4.png"> 1
                           </li>
                        </ul>
                        <div class="detail">
                           <div class="location">
                              <a href="#">
                              <i class="fa fa-map-marker"></i>123 Kathal St. Tampa City,
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="property-box">
                        <div class="property-thumbnail">
                           <a href="#" class="property-img">
                              <div class="price-box">
                                 <h6>Apartments for Rent</h6>
                                 <span>$850.00</span> Per Month
                              </div>
                              <img class="d-block w-100" src="https://diraleads.com/assets/img/luxury-property.jpg" alt="properties">
                           </a>
                        </div>
                        <ul class="facilities-list clearfix">
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-6.png"> 3600 Sqft
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-badroom.png"> 3
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-8.png"> 2
                           </li>
                           <li>
                              <img src="https://diraleads.com/assets/img/icon-b-4.png"> 1
                           </li>
                        </ul>
                        <div class="detail">
                           <div class="location">
                              <a href="#">
                              <i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City,
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Properties details page end -->
@endsection

@push('scripts')

@endpush