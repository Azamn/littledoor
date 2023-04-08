<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div class="logo-wrapper text-center p-0" style="box-shadow: none">
        <a href="/admin/dashboard">
            <img class="img-fluid" src="{{ asset('Admin/images/littledoor/logo.png') }}" alt="" width="50%">
            <img class="img-fluid" src="{{ asset('Admin/images/littledoor/logotext.png') }}" alt=""
                width="50%">

        </a>
    </div>
    <nav>
        <div class="sidebar-main">
            <div id="sidebar-menu">
                <ul class="sidebar-links custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list"><a class="nav-link " href="/admin/dashboard">
                            <i data-feather="home"></i><span>Dashboard</span></a></li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="/admin/category-list"><i
                                data-feather="truck"></i><span>Doctors</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="/admin/category-list"><i
                                data-feather="truck"></i><span>Patients</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="/admin/category-list"><i
                                data-feather="truck"></i><span>Category</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="/admin/sub-category-list"><i data-feather="box"></i><span>Sub
                                Category</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link" href="/admin/questions-list"><i
                                data-feather="monitor"></i><span>Questions</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link" href="/admin/options-list"><i
                                data-feather="monitor"></i><span>Options</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link" href="/admin/mapping-list"><i
                                data-feather="monitor"></i><span>Category-Question-Mapping</span></a>
                    </li>

                    <li class="sidebar-list">
                        <a class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            href=""><i data-feather="log-out"></i><span>Log out</span></>
                            {{-- <form method="POST" id="logout-form" action="">
                                @csrf
                            </form> --}}
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>
<!-- Page Sidebar Ends-->
