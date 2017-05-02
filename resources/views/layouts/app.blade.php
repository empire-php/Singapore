<!DOCTYPE html>
<html class="st-layout ls-top-navbar ls-bottom-footer show-sidebar sidebar-l2" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>App</title>

    <!-- Vendor CSS BUNDLE
      Includes styling for all of the 3rd party libraries used with this module, such as Bootstrap, Font Awesome and others.
      TIP: Using bundles will improve performance by reducing the number of network requests the client needs to make when loading the page. -->
    <link href="/css/vendor/all.css" rel="stylesheet">

    <!-- Vendor CSS Standalone Libraries
          NOTE: Some of these may have been customized (for example, Bootstrap).
          See: src/less/themes/{theme_name}/vendor/ directory -->
    <!-- <link href="/css/vendor/bootstrap.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/font-awesome.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/picto.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/material-design-iconic-font.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/datepicker3.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/jquery.minicolors.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/bootstrap-slider.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/railscasts.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/jquery-jvectormap.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/owl.carousel.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/slick.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/morris.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/ui.fancytree.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/daterangepicker-bs3.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/jquery.bootstrap-touchspin.css" rel="stylesheet"> -->
    <!-- <link href="/css/vendor/select2.css" rel="stylesheet"> -->
    {{--<link href="/css/vendor/dataTables.bootstrap.min.css" rel="stylesheet" />--}}

    <!-- APP CSS BUNDLE [css/app/app.css]
  INCLUDES:
      - The APP CSS CORE styling required by the "admin" module, also available with main.css - see below;
      - The APP CSS STANDALONE modules required by the "admin" module;
  NOTE:
      - This bundle may NOT include ALL of the available APP CSS STANDALONE modules;
        It was optimised to load only what is actually used by the "admin" module;
        Other APP CSS STANDALONE modules may be available in addition to what's included with this bundle.
        See src/less/themes/admin/app.less
  TIP:
      - Using bundles will improve performance by greatly reducing the number of network requests the client needs to make when loading the page. -->
    <link href="/css/app/app.css" rel="stylesheet">

    <!-- App CSS CORE
  This variant is to be used when loading the separate styling modules -->
    <!-- <link href="/css/app/main.css" rel="stylesheet"> -->

    <!-- App CSS Standalone Modules
      As a convenience, we provide the entire UI framework broke down in separate modules
      Some of the standalone modules may have not been used with the current theme/module
      but ALL modules are 100% compatible -->

    <!-- <link href="/css/app/essentials.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/layout.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/sidebar.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/sidebar-skins.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/navbar.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/media.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/player.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/timeline.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/cover.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/chat.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/charts.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/maps.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/colors-alerts.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/colors-background.css" rel="stylesheet" /> -->
    <link href="/css/app/colors-buttons.css" rel="stylesheet" />
    <!-- <link href="/css/app/colors-calendar.css" rel="stylesheet" />
    <!-- <link href="/css/app/colors-progress-bars.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/colors-text.css" rel="stylesheet" /> -->
    <!-- <link href="/css/app/ui.css" rel="stylesheet" /> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
  WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="/css/app/custom.css" rel="stylesheet" />
    @stack('css')
    
    <script src="/js/vendor/core/jquery.js"></script>
</head>

<body>
<div class="st-container">

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            @if (!Auth::guest())
                <div class="navbar-header">
                    <a href="#sidebar-menu" data-toggle="sidebar-menu" data-effect="st-effect-3" class="toggle pull-left visible-xs"><i class="fa fa-bars"></i></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{ url('/') }}" class="navbar-brand hidden-xs navbar-brand-primary">
                        @if ($headerCompany)
                            {{ $headerCompany->name }}
                        @else
                            ThemeKit
                        @endif
                    </a>
                </div>
            @endif
            <div class="navbar-collapse collapse" id="collapse">
                @if (!Auth::guest())
                    <form class="navbar-form navbar-left hidden-xs" role="search">
                        <div class="search-2">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-w-150" placeholder="Search ..">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <!-- notifications -->
                        <li class="dropdown notifications updates hidden-xs hidden-sm">
                            <a href="{{ url('/notifications') }}">
                                <i class="fa fa-bell-o"></i>
                            </a>
                        </li>
                        <!-- // END notifications -->
                        <!-- user -->
                        <li class="dropdown user">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/images/people/110/guy-6.jpg" alt="" class="img-circle"/> {{ Auth::User()->name }}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                        <!-- // END user -->
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ url('/login') }}">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/register') }}">
                                Register
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- sidebar effects OUTSIDE of st-pusher: -->
    <!-- st-effect-1, st-effect-2, st-effect-4, st-effect-5, st-effect-9, st-effect-10, st-effect-11, st-effect-12, st-effect-13 -->

    <!-- content push wrapper -->
    <div class="st-pusher">
        @if (!Auth::guest())
            <div class="sidebar left sidebar-size-2 sidebar-offset-0 sidebar-skin-blue sidebar-visible-desktop" id="sidebar-menu" data-type="collapse">
                <div class="split-vertical">
                    <div class="split-vertical-body">
                        <div class="split-vertical-cell">
                            <div class="tab-content">
                                <div class="tab-pane active" id="sidebar-tabs-menu">
                                    <div data-scrollable>
                                        <ul class="sidebar-menu sm-bordered sm-active-item-bg">
                                            <li class="hasSubmenu">
                                                <a href="#submenu-home" data-toggle="collapsed"><span>General</span></a>
                                                <ul id="submenu-home">
                                                    <li>
                                                        <a href="{{ url('/shifting') }}">
                                                            <span>New shifting</span>
                                                        </a>
                                                    </li>
                                                
                                                    <li>
                                                        <a href="{{ url('/ashcollection') }}">
                                                            <span>Ash Collection Slip</span>
                                                        </a>
                                                    </li>
                                                  
                                                    <li>
                                                        <a href="{{ url('/smsnotification/sms') }}">
                                                            <span>SMS</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-arrangement"><span>New Order</span></a>
                                                <ul id="submenu-arrangement">
                                                    <li>
                                                        <a href="{{ url('/fa') }}">
                                                            <span>Funeral Arrangement</span>
                                                        </a>
                                                    </li>
                                       <!--             <li>	-->
                                       <!--                <a href="{{ url('/view_fa') }}">  -->
                                       <!--                     <span>View Funeral Arrangements</span>  -->
                                       <!--                  </a>  -->
                                       <!--             </li>   -->
                                       
                                                    <li>
                                                        <a href="{{ url('/FArepatriation') }}">
                                                            <span>FA for Repatriation</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/hearse') }}">
                                                            <span>Hearse</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/parlour') }}">
                                                            <span>Parlours</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/columbarium') }}">
                                                            <span>Columbarium</span>
                                                        </a>
                                                    </li>
                                           <!--         <li>			-->
                                           <!--             <a href="{{ url('/view_co') }}">		-->
                                           <!--                 <span>View Columbarium Orders</span>		-->
                                           <!--             </a>					-->
                                           <!--         </li>						-->
                                                    <li>
                                                        <a href="{{ url('/gemstone') }}">
                                                            <span>Gem Stone</span>
                                                        </a>
                                                    </li>
                                          <!--          <li>						-->
                                          <!--              <a href="{{ url('/view_gs') }}">		-->
                                          <!--                  <span>View Gem Stone Orders</span>	-->
                                          <!--              </a>					-->
                                          <!--          </li>						-->
                                            <!--         <li>-->
                                             <!--            <a href="">-->
                                             <!--                <span>Niche-Nirvana</span>-->
                                              <!--           </a>-->
                                              <!--       </li>-->
                                                    <li>
                                                        <a href="{{ url('/niche') }}">
                                                            <span>Niche Nirvana</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-scc"><span>SCC Care</span></a>
                                                <ul id="submenu-scc">
                                                    <li>
                                                        <a href="{{ url('/scc/buddhist') }}">
                                                            <span>Buddhist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/scc/christian') }}">
                                                            <span>Christian</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/scc/tidbits') }}">
                                                            <span>Tidbits & Drinks</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/scc/chanting') }}">
                                                            <span>Chanting</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/scc/tentage') }}">
                                                            <span>Tentage</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-operations"><span>Operations</span></a>
                                                <ul id="submenu-operations">
                                                    <li>
                                                        <a href="/manpowerallocation">
                                                            <span>Manpower</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/duty') }}">
                                                            <span>Duty Roster</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/operations') }}">
                                                            <span>Operations Checklist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/operations/opservice') }}">
                                                            <span>Operation Service team</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/hearse/hearseallocation') }}">
                                                            <span>Hearses allocation</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <span>Deceased Summary</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <span>Supervisor Checklist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/holdniche') }}">
                                                            <span>Niche on hold</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-embalming"><span>Embalming</span></a>
                                                <ul id="submenu-embalming">
                                                    <li>
                                                        <a href="">
                                                            <span>Embalming Progress</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/embalming') }}">
                                                            <span>Embalming</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-accounts"><span>Accounts</span></a>
                                                <ul id="submenu-accounts">
                                                    <li>
                                                        <a href="">
                                                            <span>Accounting</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <span>Payroll</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="">
                                                            <span>Commission</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{url('/invoice')}}">
                                                            <span>Invoice</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/inventory') }}">
                                                            <span>Products & Inventory</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-hr"><span>HR</span></a>
                                                <ul id="submenu-hr">
                                                    <li>
                                                        <a href="">
                                                            <span>E-leave</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-forms"><span>Forms for Printing</span></a>
                                                <ul id="submenu-forms">
                                                    <li>
                                                        <a href="">
                                                            <span>View all Forms</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="hasSubmenu">
                                                <a href="#submenu-users"><span>Users & Settings</span></a>
                                                <ul id="submenu-users">
                                                    <li>
                                                        <a href="{{ url('/settings') }}">
                                                            <span>Settings</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/users') }}">
                                                            <span>Users</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="hasSubmenu">
                                                <a href="#summary"><span>Summary & Receipts</span></a>
                                                <ul id="summary">
                                                
                                                   <li>
                                                        <a href="{{ url('/view_ss') }}">
                                                            <span>View Shiftings</span>
                                                        </a>
                                                   </li>
                                                   <li>
                                                        <a href="{{ url('/view_ac') }}">
                                                            <span>View Ash Collection Slip</span>
                                                        </a>
                                                    </li>
                                                   <li>	
                                                       <a href="{{ url('/view_fa') }}">  
                                                            <span>View Funeral Arrangements</span>  
                                                         </a>  
                                                    </li>  
                                                  
                                                    
                                                    <li>
                                                        <a href="{{ url('/view_co') }}">
                                                            <span>View Columbarium Orders</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/view_gs') }}">
                                                            <span>View Gem Stone Orders</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/embalming') }}">
                                                            <span>Embalming</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/salesorder') }}">
                                                            <span>Sales Order</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/view_niche') }}">
                                                            <span>View Niche</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/inventory_record') }}">
                                                            <span>Inventory Records</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="st-content" id="content">
            <div class="st-content-inner">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /st-content -->

    </div>
    <!-- /st-pusher -->

    <!-- Footer -->
    <footer class="footer">
        <strong>SC System</strong> &copy; Copyright 2016
    </footer>
    <!-- // Footer -->

</div>
<!-- /st-container -->

<!-- Modal -->
<div class="modal fade image-gallery-item" id="showImageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-header">
            On my way to the top
        </div>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img class="img-responsive" src="images/place1-full.jpg" alt="Place">
    </div>
</div>

<!-- Inline Script for colors and config objects; used by various external scripts; -->
<script>
    var colors = {
        "danger-color": "#e74c3c",
        "success-color": "#81b53e",
        "warning-color": "#f0ad4e",
        "inverse-color": "#2c3e50",
        "info-color": "#2d7cb5",
        "default-color": "#6e7882",
        "default-light-color": "#cfd9db",
        "purple-color": "#9D8AC7",
        "mustard-color": "#d4d171",
        "lightred-color": "#e15258",
        "body-bg": "#f6f6f6"
    };
    var config = {
        theme: "admin",
        skins: {
            "default": {
                "primary-color": "#3498db"
            }
        }
    };
</script>

<!-- Vendor Scripts Bundle
  Includes all of the 3rd party JavaScript libraries above.
  The bundle was generated using modern frontend development tools that are provided with the package
  To learn more about the development process, please refer to the documentation.
  Do not use it simultaneously with the separate bundles above. -->
{{--<script src="/js/vendor/all.js"></script>--}}

<!-- Vendor Scripts Standalone Libraries -->
<!-- <script src="/js/vendor/core/all.js"></script> -->

<script src="/js/vendor/core/bootstrap.js"></script>
<script src="/js/vendor/core/breakpoints.js"></script>
<script src="/js/vendor/core/jquery.nicescroll.js"></script>
<script src="/js/vendor/core/isotope.pkgd.js"></script>
<script src="/js/vendor/core/packery-mode.pkgd.js"></script>
<!-- <script src="/js/vendor/core/jquery.grid-a-licious.js"></script> -->
<script src="/js/vendor/core/jquery.cookie.js"></script>
<script src="/js/vendor/core/jquery-ui.custom.js"></script>
<!-- <script src="/js/vendor/core/jquery.hotkeys.js"></script> -->
<!-- <script src="/js/vendor/core/handlebars.js"></script> -->
<!-- <script src="/js/vendor/core/jquery.hotkeys.js"></script> -->
<!-- <script src="/js/vendor/core/load_image.js"></script> -->
<script src="/js/vendor/core/jquery.debouncedresize.js"></script>
<script src="/js/vendor/tables/all.js"></script>
<script src="/js/vendor/forms/all.js"></script>
<script src="/js/vendor/media/all.js"></script>
<!-- <script src="/js/vendor/player/all.js"></script> -->
<!-- <script src="/js/vendor/charts/all.js"></script> -->
<!-- <script src="/js/vendor/charts/flot/all.js"></script> -->
<!-- <script src="/js/vendor/charts/easy-pie/jquery.easypiechart.js"></script> -->
<!-- <script src="/js/vendor/charts/morris/all.js"></script> -->
<!-- <script src="/js/vendor/charts/sparkline/all.js"></script> -->
<!-- <script src="/js/vendor/maps/vector/all.js"></script> -->
{{--<script src="/js/vendor/tree/jquery.fancytree-all.js"></script>--}}
{{--<script src="/js/vendor/nestable/jquery.nestable.js"></script>--}}
<!-- <script src="/js/vendor/angular/all.js"></script> -->

<!-- App Scripts Bundle
  Includes Custom Application JavaScript used for the current theme/module;
  Do not use it simultaneously with the standalone modules below. -->
{{--<script src="/js/app/app.js"></script>--}}

<!-- App Scripts Standalone Modules
  As a convenience, we provide the entire UI framework broke down in separate modules
  Some of the standalone modules may have not been used with the current theme/module
  but ALL the modules are 100% compatible -->

<script src="/js/app/essentials.js"></script>
<script src="/js/app/layout.js"></script>
<script src="/js/app/sidebar.js"></script>
<!-- <script src="/js/app/media.js"></script> -->
<!-- <script src="/js/app/player.js"></script> -->
<!-- <script src="/js/app/timeline.js"></script> -->
<!-- <script src="/js/app/chat.js"></script> -->
<!-- <script src="/js/app/maps.js"></script> -->
<!-- <script src="/js/app/charts/all.js"></script> -->
<!-- <script src="/js/app/charts/flot.js"></script> -->
<!-- <script src="/js/app/charts/easy-pie.js"></script> -->
<!-- <script src="/js/app/charts/morris.js"></script> -->
<!-- <script src="/js/app/charts/sparkline.js"></script> -->
<script src="/js/app/custom.js"></script>
 @stack('scripts')
</body>
</html>
