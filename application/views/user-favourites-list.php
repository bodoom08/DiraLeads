<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/front_end_layout/top', [
    'title' => 'User Favourites List'
]);
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<div class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-sm-12 col-pad">
                <div class="dashboard-nav d-none d-xl-block d-lg-block">
                    <?php $this->load->view('common/front_end_layout/sidebar'); ?>
                </div>
            </div>
            <?php
            $attrs = [
                'name'=> 'modify_package_form',
                'method' => 'POST'
            ];
            echo form_open_multipart('pricing/manage_subscribed_package_custom', $attrs);
            ?>
                <input type="hidden" name="package_table_id">
                <input type="hidden" name="action">
                
            </form>
            <form action="<?php echo site_url('subscription/manage_package_area_info'); ?>" name="modify_package_area_info_form" method="POST">
                <input type="hidden" name="package_table_id">
                <input type="hidden" name="action">
            </form>
            <div class="col-lg-10 col-md-12 col-sm-12 col-pad">
                <div class="content-area5">
                    <div class="dashboard-content">

                      <div class="dashboard-list myproperti_list">
                        <div class="col-md-12 subs-sec">
                        <h3 class="heading" style="border-bottom:0px;"> My Favourites</h3>
                        </div>
                        <div class="explore-content-box new">
                          <div class="container-fluid"> 
                            <div class="inner-content-box">
                              <div class="row dn-items"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                       <p class="sub-banner-2 text-center">© <?php echo date('Y'); ?> Diraleads. Trademarks and brands are the property of their respective owners.</p>
                    </div>
                   
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="modal" id="Properties-popup">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="slider-popup">
                <div id="demo" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                   <ul class="carousel-indicators">
                   </ul>
                <!-- The slideshow -->
                       <div class="carousel-inner">
                       </div>
                    </div>
                   <div class="popup-slider-text">
                    <div class="inner-slider-text">
                             <div class="content-text contentText">

                             </div>
                      
                   
                       <div class="content-text">
                        <h5>Property Details</h5>
                           <div class="list-content contectDetail">
                           </div>
                          <div class="submit-box">
                             <button>Submit Request</button>
                          </div>
                        </div>
                </div>
                </div>
         </div>
      </div>
      <!-- <div id="map"></div> -->
      </div>
      </div>

<?php $this->load->view('common/front_end_layout/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
<script>
    $(function() {
        var formData = new FormData();
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
        $.ajax({
            url: '<?php echo site_url("favourites/json_data"); ?>',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                $('.dn-items').append(data);
            },
            error: function(error) {
                console.log(error);
            },
            complete: function(data) {
                console.log(data);
            }
        })
        // window.DT = $('#preferences-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "<?php // echo site_url('favourites/json'); ?>"
        // });
    });
    $(function() {
    $('body').on('click', '.favLinkButton', function() {
        // $.LoadingOverlay("show", {
        //     image       : "",
        //     fontawesome : "fa fa-cog fa-spin"
        // });
        var form = $(this).closest('form');
        property_id = $(form).find('[name="property_id"]').val();
        csrf_token = $(form).find('[name="csrf_token"]').val();
        var formData = new FormData($(form)[0]);
        $.ajax({
            url: '<?php echo site_url("properties/addToFavorites"); ?>',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                // $.LoadingOverlay("hide");
                 if(data.response == 'remove') {
                  toastr.success('Rental removed from favorites');
                  setTimeout(function(){
                   location.reload();
                   }, 3000);
                    
                }
            },
            error: function(data) {
                console.log();
                $.LoadingOverlay("hide");
            },
            complete: function(data) {
                $.LoadingOverlay("hide");
                console.log(data)
            }
        })


    })
})
   function showDetails(id){
   $.ajax({
   type: "post",
   url: "<?php echo site_url('properties/viewDetails') ?>",
   dataType: "json",
   data: {
      property_id: id,
   },
   success: function (res) {
      

      if (res.property.coords) {
         var a = JSON.parse(res.property.coords);
         var coords = a.map(function (x) { 
         return parseFloat(x); 
         });
         // initMap(JSON.parse(res.property.coords));
      } else {
         // initMap();
      }
      $(".contentText").html("");
      $(".contectDetail").html("");
      $(".carousel-indicators").html("");
      $(".carousel-inner").html("");
      $.each( res.property_images, function( key, value ) {
         if(key == 0){
            var active = 'active';
         }else{
            var active = '';
         }
          $(".carousel-indicators").append("<li data-target='#demo' data-slide-to='"+key+"' class='"+active+"'></li>");
         var base_path = "<?php echo  site_url("uploads/") ?>";
         $(".carousel-inner").append("<div class='carousel-item "+active+"'><img src='"+base_path+value.path+"' /></li>");
      });

      $(".prepends").remove();
      $(".contectDetail").append("<span>Property ID:"+res.property.id+"</span>"+"<span>Property Price:$"+res.property.price+"</span><span>Property status: For "+res.property.for+"</span><span>Property Type: "+res.property.type+"</span><p class='moreDetails'>");
      $.each( res.property_attributes, function( key, value ) {
         var icon_path = '<?php echo site_url("") ?>';
         $(".moreDetails").prepend("<span>"+value.text+': '+value.value+" "+value.text+" </span>");
      });
       if(res.property.description !=''){
      $(".contentText").append("<h5>Discription</h5><p>"+res.property.description+"</p>");
      }
      $("#propertyDetailStreet").html(res.property.street);

      $("#Properties-popup").modal('show');
   }
   });
   }
</script>