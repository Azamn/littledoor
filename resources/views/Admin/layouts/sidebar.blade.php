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
                        <a class="nav-link  " href="/admin/category-list">
                            <i class="fa fa-stethoscope fa-lg m-r-10"></i><span>Doctors</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="/admin/category-list">
                             <i class="fa fa-wheelchair  fa-lg m-r-10"></i><span>Patients</span></a>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                        <i class="fa fa-list-ul fa-lg m-r-10"></i><span>Therapy Category</span></a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list">
                                <a class="nav-link  " href="{{ route('get.all-categories') }}">
                                    <i class="fa fa-cube fa-lg m-r-10"></i><span>Category</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="nav-link  " href="{{ route('get.all-sub-categories') }}">
                                    <i class="fa  fa-cubes fa-lg m-r-10"></i><span>Sub
                                        Category</span></a>
                            </li>
                        </ul>
                    </li>





                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                        <i class="fa fa-file-text-o fa-lg m-r-10"></i><span>Question Relationship</span></a>
                        <ul class="sidebar-submenu">
                            <li class="sidebar-list">
                                <a class="nav-link" href="/admin/questions-list">
                                    <i class="fa fa-question fa-lg m-r-10"></i><span>Questions</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="nav-link" href="/admin/options-list">
                                    <i class="fa fa-list-ol fa-lg m-r-10"></i><span>Options</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="nav-link" href="/admin/mapping-list">
                                    <i class="fa fa-list-ol fa-lg m-r-10"></i>  <span>Category-Question-Mapping</span></a>
                            </li>
                        </ul>
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
