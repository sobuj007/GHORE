 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <a href="#" target="_blank" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('backend') }}/assets/images/pixcafe.png" alt="" height="22">
             </span>
             <span class="logo-lg text-white">
                 <img src="{{ asset('backend') }}/assets/images/pixcafe.png" alt="" height="45">
                 <span class="ms-1">{{ config('starter.LOGO_TEXT') }}</span>
             </span>
         </a>
         <a href="#" target="_blank" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('backend') }}/assets/images/pixcafe.png" alt="" height="22">
             </span>
             <span class="logo-lg text-white">
                 <img src="{{ asset('backend') }}/assets/images/pixcafe.png" alt="" height="45">
                 <span class="ms-1">{{ config('starter.LOGO_TEXT') }}</span>
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover shadow-none"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">

                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                 @if (Auth::user()->role==='admin')
               <x-nav-item title="Dashboard" icon="ti ti-brand-google-home" :url="route('dashboard')" :active="request()->routeIs('dashboard.index')" />

                <!-- Category -->
                <x-nav-dropdown id="category" title="Category" :active="request()->routeIs('category.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('category.index')" :active="request()->routeIs('category.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('category.create')" :active="request()->routeIs('category.create')" />
                </x-nav-dropdown>


                <!-- Subcategory -->
                <x-nav-dropdown id="subcategory" title="Subcategory" :active="request()->routeIs('subcategory.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('subcategory.index')" :active="request()->routeIs('subcategory.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('subcategory.create')" :active="request()->routeIs('subcategory.create')" />
                </x-nav-dropdown>


                <!-- Bodypart -->
                <x-nav-dropdown id="bodypart" title="Bodypart" :active="request()->routeIs('bodypart.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('bodypart.index')" :active="request()->routeIs('bodypart.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('bodypart.create')" :active="request()->routeIs('bodypart.create')" />
                </x-nav-dropdown>

               <!-- Faq -->
                <x-nav-dropdown id="promotion_banners" title="Promotion Banners" :active="request()->routeIs('promotion_banners.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('promotion_banners.index')" :active="request()->routeIs('promotion_banners.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('promotion_banners.create')" :active="request()->routeIs('promotion_banners.create')" />
                </x-nav-dropdown>

               <!-- Promo -->
                <x-nav-dropdown id="cities" title="Cities" :active="request()->routeIs('promo.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('cities.index')" :active="request()->routeIs('cities.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('cities.create')" :active="request()->routeIs('cities.create')" />
                </x-nav-dropdown>

                <!-- Courses -->
                <x-nav-dropdown id="locations" title="Locations" :active="request()->routeIs('course.*')" icon="ri-function-line">
                    <x-nav-item title="View All" icon="" :url="route('locations.index')" :active="request()->routeIs('locations.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('locations.create')" :active="request()->routeIs('locations.create')" />
                </x-nav-dropdown>

                <!-- Page -->
                <x-nav-dropdown id="users" title="Users" :active="request()->routeIs('users.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('users.index')" :active="request()->routeIs('users.index')" />
                    {{-- <x-nav-item title="Add New" icon="" :url="route('users.create')" :active="request()->routeIs('users.create')" /> --}}
                </x-nav-dropdown>

                <x-nav-dropdown id="usercommonprofile" title=" My Profile" :active="request()->routeIs('usercommonprofile.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('usercommonprofile.index')" :active="request()->routeIs('usercommonprofile.index')" />
                    {{-- <x-nav-item title="Add New" icon="" :url="route('usercommonprofile.create')" :active="request()->routeIs('users.create')" /> --}}
                </x-nav-dropdown>



               @endif
               @if (Auth::user()->role ==='agent')

                  <!-- Page -->
                  <x-nav-dropdown id="usercommonprofile" title=" My Profile" :active="request()->routeIs('usercommonprofile.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('usercommonprofile.index')" :active="request()->routeIs('usercommonprofile.index')" />
                    {{-- <x-nav-item title="Add New" icon="" :url="route('usercommonprofile.create')" :active="request()->routeIs('users.create')" /> --}}
                </x-nav-dropdown>
                  <!-- Page -->
                  <x-nav-dropdown id="storeprofile" title=" My Store" :active="request()->routeIs('storeprofile.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('storeprofile.index')" :active="request()->routeIs('storeprofile.index')" />
                    {{-- <x-nav-item title="Add New" icon="" :url="route('usercommonprofile.create')" :active="request()->routeIs('users.create')" /> --}}
                </x-nav-dropdown>
                  <!-- Page -->
                  <x-nav-dropdown id="myexparts" title=" My Exparts" :active="request()->routeIs('myexparts.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('myexparts.index')" :active="request()->routeIs('myexparts.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('myexparts.create')" :active="request()->routeIs('myexparts.create')" />
                </x-nav-dropdown>
                  <!-- Page -->
                  <x-nav-dropdown id="certificates" title=" My Certificate" :active="request()->routeIs('certificates.*')" icon=" ri-pages-fill ">
                    <x-nav-item title="View All" icon="" :url="route('certificates.index')" :active="request()->routeIs('certificates.index')" />
                    <x-nav-item title="Add New" icon="" :url="route('certificates.create')" :active="request()->routeIs('certificates.create')" />
                </x-nav-dropdown>

                 <!-- Gallery -->
                <x-nav-dropdown id="myslots" title="Myslots" :active="request()->routeIs('myslots.*')" icon=" ri-gallery-upload-fill ">
                     <x-nav-item title="View All" icon="" :url="route('myslots.index')" :active="request()->routeIs('myslots.index')" />
                     <x-nav-item title="Add New" icon="" :url="route('myslots.create')" :active="request()->routeIs('myslots.create')" />
                 </x-nav-dropdown>

                 <!-- User -->
                 <x-nav-dropdown id="appointmentslots" title="Appointment Slots" :active="request()->routeIs('appointmentslots.*')" icon=" ri-user-fill ">
                     <x-nav-item title="View All" icon="" :url="route('appointmentslots.index')" :active="request()->routeIs('appointmentslots.index')" />
                     <x-nav-item title="Add New" icon="" :url="route('appointmentslots.create')" :active="request()->routeIs('appointmentslots.create')" />
                 </x-nav-dropdown>


                 <!-- Contact -->
                 <x-nav-dropdown id="serviceproducts" title="serviceproducts" :active="request()->routeIs('serviceproducts.*')" icon="ri-function-line">
                     <x-nav-item title="View All" icon="" :url="route('serviceproducts.index')" :active="request()->routeIs('serviceproducts.index')" />
                        <x-nav-item title="Add New" icon="" :url="route('serviceproducts.create')" :active="request()->routeIs('serviceproducts.create')" />
                    </x-nav-dropdown>

                 <!-- Contact -->
                 <x-nav-dropdown id="agent.reviews" title="Reviews" :active="request()->routeIs('agent.reviews.*')" icon="ri-function-line">
                     <x-nav-item title="View All" icon="" :url="route('agent.reviews')" :active="request()->routeIs('agent.reviews')" />
                        {{-- <x-nav-item title="Add New" icon="" :url="route('serviceproducts.create')" :active="request()->routeIs('serviceproducts.create')" /> --}}
                    </x-nav-dropdown>
                 <!-- Contact -->
                 <x-nav-dropdown id="orders" title="Orders" :active="request()->routeIs('orders.*')" icon="ri-function-line">
                     <x-nav-item title="View All" icon="" :url="route('orders.index')" :active="request()->routeIs('orders.index')" />
                        <x-nav-item title="Add New" icon="" :url="route('orders.create')" :active="request()->routeIs('orders.create')" />
                    </x-nav-dropdown>
 @endif
 @if (Auth::user()->role==='user')
 <x-nav-dropdown id="user.create" title="Orders" :active="request()->routeIs('user.*')" icon="ri-function-line">
    <x-nav-item title="Add New" icon="" :url="route('orders.create')" :active="request()->routeIs('orders.create')" />
       {{-- <x-nav-item title="Add New" icon="" :url="route('serviceproducts.create')" :active="request()->routeIs('serviceproducts.create')" /> --}}
   </x-nav-dropdown>
  @endif

   {{--              <!-- Setting -->
                 <x-nav-item title="Setting" icon="ri ri-settings-2-line" :url="route('setting.index')" :active="request()->routeIs('setting.index')" />
 --}}


             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->
