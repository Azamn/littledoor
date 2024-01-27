<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div class="logo-wrapper text-center p-0" style="box-shadow: none">
        <a href="/admin/dashboard">
            <img class="img-fluid" src="{{ asset('Admin/images/littledoor/littleDoorLogo.png') }}" alt=""
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
                        <a class="nav-link  " href="{{ route('get.all-doctors') }}">
                            <i class="fa fa-stethoscope fa-lg m-r-10"></i><span>Doctors</span></a>
                    </li>
                    <li class="sidebar-list">
                        <a class="nav-link  " href="{{ route('get.all-patient') }}">
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
                                <a class="nav-link" href="{{ route('get.questions') }}">
                                    <i class="fa fa-question fa-lg m-r-10"></i><span>Questions</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="nav-link" href="{{ route('get.options') }}">
                                    <i class="fa fa-list-ol fa-lg m-r-10"></i><span>Options</span></a>
                            </li>
                            <li class="sidebar-list">
                                <a class="nav-link" href="{{ route('get.all-mapping') }}">
                                    <i class="fa fa-list-ol fa-lg m-r-10"></i>
                                    <span>Category-Question-Mapping</span></a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#">
                        <i class="fa fa-list-ul fa-lg m-r-10"></i><span>Transaction Details</span></a>
                    <ul class="sidebar-submenu">
                        <li class="sidebar-list">
                            <a class="nav-link  " href="{{ route('get.all-transactions-details') }}">
                                <i class="fa fa-cube fa-lg m-r-10"></i><span>All Transactions</span></a>
                        </li>
                        <li class="sidebar-list">
                            <a class="nav-link  " href="{{ route('get.doctor-payment-request') }}">
                                <i class="fa  fa-cubes fa-lg m-r-10"></i><span>Doctor Payment Request</span></a>
                        </li>

                        <li class="sidebar-list">
                            <a class="nav-link  " href="{{ route('get.all-sub-categories') }}">
                                <i class="fa  fa-cubes fa-lg m-r-10"></i><span>Doctor Payment Completed</span></a>
                        </li>

                    </ul>
                </li>

                    <li class="sidebar-list">
                        <a class="nav-link  " href="{{ route('get.all-emotions') }}">
                            <i class="fa fa-smile-o fa-lg m-r-10"></i><span>Emotions</span></a>
                    </li>

                    <li class="sidebar-list">
                        <a class="nav-link  " href="{{ route('get.all-promotions') }}">
                            <i class="fa fa-send-o fa-lg m-r-10"></i><span>Promotion</span></a>
                    </li>

                    <li class="sidebar-list">
                        <a class="nav-link  " href="{{ route('get.portal-service') }}">
                            <i class="fa fa-send-o fa-lg m-r-10"></i><span>Portal Service Charges</span></a>
                    </li>

                    <li class="sidebar-list">
                        <a class="nav-link  " href="{{ route('get.privacy-policy') }}">
                            <i class="fa fa-send-o fa-lg m-r-10"></i><span>Privacy Policy</span></a>
                    </li>

                    <li class="sidebar-list">
                        <a class="nav-link" href="{{ route('logout') }}"><i data-feather="log-out"></i>
                            <span>Logout</span></>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>
<!-- Page Sidebar Ends-->
