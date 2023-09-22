 <!--start back-to-top-->
 <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
     <i class="ri-arrow-up-line"></i>
 </button>
 <!--end back-to-top-->

 <!--preloader-->
 <div id="preloader">
     <div id="status">
         <div class="spinner-border text-primary avatar-sm" role="status">
             <span class="visually-hidden">Loading...</span>
         </div>
     </div>
 </div>



 <!-- JAVASCRIPT -->
 <script src="<?= site_url('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
 <script src="<?= site_url('public/assets/libs/simplebar/simplebar.min.js') ?>"></script>
 <script src="<?= site_url('public/assets/libs/node-waves/waves.min.js') ?>"></script>
 <script src="<?= site_url('public/assets/libs/feather-icons/feather.min.js') ?>"></script>
 <script src="<?= site_url('public/assets/js/pages/plugins/lord-icon-2.1.0.js') ?>"></script>
 <script src="<?= site_url('public/assets/js/plugins.js') ?>"></script>
 <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
 <!-- apexcharts -->
 <!-- <script src="<?= site_url('public/assets/libs/apexcharts/apexcharts.min.js') ?>"></script> -->

 <!-- Vector map-->
 <!-- <script src="<?= site_url('public/assets/libs/jsvectormap/js/jsvectormap.min.js') ?>"></script> -->
 <!-- <script src="<?= site_url('public/assets/libs/jsvectormap/maps/world-merc.js') ?>"></script> -->

 <!--Swiper slider js-->
 <!-- <script src="<?= site_url('public/assets/libs/swiper/swiper-bundle.min.js') ?>"></script> -->

 <!-- Dashboard init -->
 <!-- <script src="<?= site_url('public/assets/js/pages/dashboard-ecommerce.init.js') ?>"></script> -->

 <!-- App js -->
 <script src="<?= site_url('public/assets/js/app.js') ?>"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 <script>
     $(document).ready(function() {
         // Get the current page URL
         var currentUrl = window.location.href;
         var userId = '<?= current_user()->Id ?>';
         // Loop through each anchor element with the class "nav-link"
         $('.nav-link').each(function() {
             // Compare the href attribute with the current URL
             if ($(this).attr('href') === currentUrl) {
                 // If they match, add the "active" class to the parent <li> element
                 $(this).addClass('active');
                 var parentCollapse = $(this).closest('div.collapse');
                 if (parentCollapse.length > 0) {
                     // If it does, add the "show" class to that specific <div>
                     parentCollapse.addClass('show');
                     $(parentCollapse).prev().attr('aria-expanded', true);
                 }
             }
         });
         $('#seachBrandSize').on('click', function() {
             if ($('.brandsSelection').val() != 0) {
                 let brand = $('.brandsSelection').val();
                 window.location.href = '<?= site_url("wardrobe/search_brands/") ?>'+ userId +'/' + brand;
             }
         });
     });
 </script>
 <?= $this->renderSection('pageJS'); ?>
 </body>

 </html>