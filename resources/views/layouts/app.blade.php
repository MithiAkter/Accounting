<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Test App</title>



    <!-- vendor css -->
    <link href="{{ asset('backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{ asset('backend/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{ asset('backend/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/starlight.css') }}">
    <link href="{{ asset('backend/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{ asset('backend/lib/summernote/summernote-bs4.css')}}" rel="stylesheet">

  </head>
  <style>
    /* Hover effect on the text inside the dropdown */
    .dropdown-menu .dropdown-item:hover {
        color: black !important;  /* Make the text color black */
    }
</style>
  <body>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
          {{-- <a class="navbar-brand" href="{{ url('/') }}">
              Laravel 11 User Roles and Permissions Tutorial - ItSolutionStuff.com
          </a> --}}
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav me-auto">
              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ms-auto">
                  <!-- Authentication Links -->
                  @guest
                      @if (Route::has('login'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                          </li>
                      @endif

                      @if (Route::has('register'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                          </li>
                      @endif
                  @else
                      <li class="nav-item dropdown">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }}
                          </a>

                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  {{ __('Logout') }}
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  @endguest
              </ul>
          </div>
      </div>
  </nav>

     
          
      @auth
            <!-- ########## START: HEAD PANEL ########## -->
      <div class="sl-header">
        <div class="sl-header-left">
          <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
          <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        </div><!-- sl-header-left -->
        <div class="sl-header-right">
          <nav class="nav">
            <div class="dropdown">
              <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                <span class="logged-name">Logout<span class="hidden-md-down"></span></span>
                <img src="{{asset ('public/backend/img/img3.jpg') }}" class="wd-32 rounded-circle" alt="">
              </a>
              <div class="dropdown-menu dropdown-menu-header wd-200">
                {{-- <ul class="list-unstyled user-profile-nav">
                  <li><a href=""><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
                  <li><a href="#"><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
                  <li><a href="#"><i class="icon ion-power"></i> Sign Out</a></li>
                </ul> --}}

                
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              

              </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
          </nav>
        </div><!-- sl-header-right -->
      </div><!-- sl-header -->
    <!-- ########## START: LEFT PANEL ########## -->
      <div class="sl-logo"><a href=""><i class="icon ion-android-star-outline"></i> Test App</a></div>
      <div class="sl-sideleft">
        <div class="sl-sideleft-menu">
          <a href="{{ route('products.index') }}" class="sl-menu-link">
            <div class="sl-menu-item">
              <i class="menu-item-icon ion-ios-cart tx-20"></i>
              <span class="menu-item-label">Manage Product</span>
              {{-- <i class="menu-item-arrow fa fa-angle-down"></i> --}}
            </div><!-- menu-item -->
            
          </a><!-- sl-menu-link -->
          <a href="" class="sl-menu-link">
            <div class="sl-menu-item">
              <i class="menu-item-icon ion-person-stalker tx-20"></i>
              <span class="menu-item-label">Customers</span>
            </div><!-- menu-item -->
            
          </a><!-- sl-menu-link -->
          <a href="{{ route('users.index') }}" class="sl-menu-link">
            <div class="sl-menu-item">
              <i class="menu-item-icon ion-person tx-20"></i>
              <span class="menu-item-label">Manage Users</span>
            </div><!-- menu-item -->
            
          </a><!-- sl-menu-link -->
          <a href="{{ route('roles.index') }}" class="sl-menu-link">
            <div class="sl-menu-item">
              <i class="menu-item-icon ion-gear-b tx-20"></i>
              <span class="menu-item-label">Manage Role</span>
            </div><!-- menu-item -->
          </a><!-- sl-menu-link -->
          @endauth
        </div>
      </div> 
      {{-- <div class="sl-mainpanel">
        @yield('content')
      </div> --}}

       <!-- Main Content -->
       <div class="sl-mainpanel">
        
            <div class="card-body">
                @yield('content')
            </div>
        
    </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

      <!-- SweetAlert -->
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script>
        @if(Session::has('messege'))
            var message = "{{ Session::get('messege') }}";
            var type = "{{ Session::get('alert-type', 'info') }}";
    
            switch(type){
                case 'info':
                    swal("Info!", message, "info");
                    break;
    
                case 'success':
                    swal("Success!", message, "success");
                    break;
    
                case 'warning':
                    swal("Warning!", message, "warning");
                    break;
    
                case 'error':
                    swal("Error!", message, "error");
                    break;
            }
        @endif
        </script>


        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- SweetAlert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>  
            $(document).on("click", "#delete", function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                var link = $(this).attr("href"); // Get the link URL
                swal({
                    title: "Are you sure you want to delete?",
                    text: "This will permanently delete the category.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = link; // Redirect to delete the item
                    } else {
                        swal("Your data is safe!"); // Display cancellation message
                    }
                });
            });
        </script>


    <script src="{{ asset('backend/lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('backend/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('backend/lib/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('backend/lib/jquery.sparkline.bower/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('backend/lib/d3/d3.js') }}"></script>
    <script src="{{ asset('backend/lib/rickshaw/rickshaw.min.js') }}"></script>
    <script src="{{ asset('backend/lib/chart.js/Chart.js') }}"></script>
    <script src="{{ asset('backend/lib/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('backend/lib/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('backend/lib/Flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('backend/lib/flot-spline/jquery.flot.spline.js') }}"></script>
    
    <script src="{{ asset('backend/js/starlight.js') }}"></script>
    <script src="{{ asset('backend/js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('backend/js/dashboard.js') }}"></script>
    <script src="{{ asset('backend/lib/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('backend/lib/datatables-responsive/dataTables.responsive.js') }}"></script>

    <script src="{{ asset('backend/lib/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('backend/lib/medium-editor/medium-editor.js') }}"></script>

    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
