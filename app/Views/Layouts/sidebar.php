 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="#" class="logo logo-dark">
             <span class="logo-sm">
                 <!-- <img src="<?= site_url('public/assets/images/logo-sm.png') ?>" alt="" height="22"> --><span class="fw-bold text-dark">VW</span>
             </span>
             <span class="logo-lg">
                 <!-- <img src="<?= site_url('public/assets/images/logo-dark.png') ?>" alt="" height="17"> --><span class="fw-bold text-dark">Virtual Wardrobe</span>
             </span>
         </a>
         <!-- Light Logo-->
         <a href="#" class="logo logo-light">
             <span class="logo-sm">
                 <!-- <img src="public/assets/images/logo-sm.png" alt="" height="22"> --><span class="fw-bold text-dark"><small>Wardrobe</small></span>
             </span>
             <span class="logo-lg">
                 <!-- <img src="public/assets/images/logo-light.png" alt="" height="17"> --><span class="fw-bold text-dark">Wardrobe</span>
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="<?= site_url('Dashboard') ?>">
                         <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboard">Dashboard</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                         <i class="ri-shirt-line"></i> <span data-key="t-workers">Wardrobes</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarLayouts">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="<?= site_url('wardrobe/new') ?>" class="nav-link" data-key="t-importFile">New Wardorbe</a>
                             </li>
                             <li class="nav-item">
                                 <a href="<?= site_url('wardrobe/index') ?>" class="nav-link" data-key="t-addworker">Manage Wardrobes</a>
                             </li>

                         </ul>
                     </div>
                 </li>
                 <!-- <li class="nav-item">
                     <a class="nav-link menu-link" href="#Articles" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Articles">
                         <i class="ri-store-line"></i> <span data-key="t-Articles">Articles</span>
                     </a>
                     <div class="collapse menu-dropdown" id="Articles">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="<?= site_url('article/new') ?>" class="nav-link" data-key="t-importFile">New Article</a>
                             </li>
                             <li class="nav-item">
                                 <a href="<?= site_url('article') ?>" class="nav-link" data-key="t-addworker">Manage Articles</a>
                             </li>

                         </ul>
                     </div>
                 </li> -->
                 <!-- <li class="nav-item">
                     <a class="nav-link menu-link" href="<?= site_url('worker/requests') ?>">
                         <i data-feather="clipboard" class="icon-dual"></i> <span data-key="t-requests">Requests</span>
                     </a>
                 </li> -->
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->