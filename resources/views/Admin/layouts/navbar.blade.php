<!-- Page Header Start-->
<div class="page-header" style="background-color:#643fdb">
            <div class="header-wrapper bg-primmrary row m-0">
                
                <div class="header-logo-wrapper">
                    <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                src="{{asset('Admin/images/littledoor/logo.png')}}" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle">
                        </i></div>
                </div>
                <div class="left-header col horizontal-wrapper pl-0">
                    <ul class="horizontal-menu">
                        <li class="mega-menu">
{{--                            <div class="mega-menu-container nav-submenu">--}}
{{--                                <div class="container-fluid">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </li>
                    </ul>
                </div>
                <div class="nav-right col-8 text-right pull-right right-header p-0">
                    <ul class="nav-menus">

                        <li>
                            <div class="mode"><i style="color:white" class="fa fa-moon-o"></i></div>
                        </li>


                        <li class="maximize"><a class="text-light" href="#!" onclick="javascript:toggleFullScreen()"><i
                             data-feather="maximize"></i></a></li>
                            
                             <li class="profile-nav onhover-dropdown text-light pe-0 py-0">
                                <div class="media profile-media">
                                    <i data-feather="user"></i>
                                  <div class="media-body"><span id="user_name">Emay Walter</span>
                                  </div>
                                </div>
                                
                              </li>
                       
                    </ul>
                </div>
                <script id="result-template" type="text/x-handlebars-template">
                    <div class="ProfileCard u-cf">
            <div class="ProfileCard-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName"></div>
            </div>
            </div>
          </script>
                <script id="empty-template" type="text/x-handlebars-template">
                    <div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div>
                </script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
<script>
       var name = localStorage.getItem('name');
       
       if(name)
       {

        document.getElementById("user_name").innerHTML = name;
       }
       else
       {
        document.getElementById("user_name").innerHTML = "Admin";

       }

</script>