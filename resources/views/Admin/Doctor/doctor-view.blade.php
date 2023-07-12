@extends('Admin.layouts.base')

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-title">
        <div class="row">
          <div class="col-6">
            <h3>Doctor View</h3>
          </div>
          <div class="col-6">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">                                       
                  <svg class="stroke-icon">
                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                  </svg></a></li>
                  
              <li class="breadcrumb-item active">Doctor View</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div>
        <div class="row product-page-main p-0">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="product-page-details">
                  <h3>Doctor Name</h3>
                </div>
                <hr>
                <div>
                  <table class="product-page-width">
                    <tbody>
                      <tr>
                        <td> <b>Expertise &nbsp;&nbsp;&nbsp;:</b></td>
                        <td>Pixelstrap</td>
                      </tr>
                      <tr>
                        <td> <b>Area of Speciality &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                        <td> asdasd , asdasd ,asdassd </td>
                      </tr>
                      <tr>
                        <td> <b>Year of Experience &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                        <td>12</td>
                      </tr>
                      <tr>
                        <td> <b>Description &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                        <td>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that.</td>
                      </tr>
                      <tr>
                        <td> <b>Certificates &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                        <td><a class="btn btn-primary"  href=""> <i class="icon-eye"></i> View Certificate </a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                
                
              </div>
            </div>
          </div>




          <div class="col-xl-6 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Outline Accordion </h4>
                <p class="f-m-light mt-1">
                   make custom <code>.accordion-wrapper</code> class use to bring border-left side.</p>
                <div class="card-header-right">
                  <ul class="list-unstyled card-option">
                    <li><i class="fa fa-spin fa-cog"></i></li>
                    <li><i class="view-html fa fa-code"></i></li>
                    <li><i class="icofont icofont-maximize full-card"></i></li>
                    <li><i class="icofont icofont-minus minimize-card"></i></li>
                    <li><i class="icofont icofont-refresh reload-card"></i></li>
                    <li><i class="icofont icofont-error close-card"> </i></li>
                  </ul>
                </div>
              </div>
              <div class="card-body"> 
                <div class="accordion dark-accordion" id="accordionExample">
                  <div class="accordion-item accordion-wrapper">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseOne" aria-expanded="true" aria-controls="left-collapseOne">What do web designers do?<i class="svg-color" data-feather="chevron-down"></i></button>
                    </h2>
                    <div class="accordion-collapse collapse" id="left-collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <p>
                           Web design<em class="txt-danger"> identifies the goals</em> of a website or webpage and promotes accessibility for all potential users. This process involves organizing content and images across a series of pages and integrating applications and other interactive elements.</p>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item accordion-wrapper">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseTwo" aria-expanded="false" aria-controls="left-collapseTwo">What is the use of web design?<i class="svg-color" data-feather="chevron-down"></i></button>
                    </h2>
                    <div class="accordion-collapse collapse" id="left-collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <p> <strong> Search engine optimization: </strong> Search engine optimization (SEO) is a method for improving the chances for a website to be found by search engines. Web design codes information in a way that search engines can read it. It can boost business because the site shows up on the top search result pages, helping people to find it.<br><br><strong> Mobile responsiveness:</strong> Mobile responsiveness is the feature of a website that allows it to display on a mobile device and adapt its layout and proportions to be legible. Web design ensures sites are easy to view and navigate from mobile devices. When a website is well-designed and mobile-responsive, customers can reach the business with ease.<br><br><strong> Improved sales:</strong>Increasing the number of items sold or acquiring more active customers are objectives of a compelling website. As web design reaches targeted customers and search engines, it helps the business make conversions on their site and improve its sales.</p>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item accordion-wrapper">
                    <h2 class="accordion-header" id="headingThree">
                      <button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseThree" aria-expanded="false" aria-controls="left-collapseThree">What are the elements of web design?<i class="svg-color" data-feather="chevron-down"></i></button>
                    </h2>
                    <div class="accordion-collapse collapse" id="left-collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <p>
                           The web design process allows designers to adjust to any preferences and provide effective solutions. There are many standard components of every web design, including:<br>--> Layout<br>--> Images<br>--> Visual hierarchy<br>--> Color scheme<br>--> Typography<br>--> Navigation<br>--> Readability<br>--> Content</p>
                      </div>
                    </div>
                  </div>
                  <div class="code-box-copy">
                    <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#left-according" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                    <pre><code class="language-html" id="left-according">&lt;!--You can use .accordion-collapse with .show class then show accordions.--&gt; 
&lt;div class="accordion" id="accordionExample"&gt;
&lt;div class="accordion-item accordion-wrapper"&gt;
&lt;h2 class="accordion-header" id="headingOne"&gt;
&lt;button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"&gt;What do web designers do?&lt;i class="svg-color" data-feather="chevron-down"&gt;&lt;/i&gt;&lt;/button&gt;
&lt;/h2&gt;
&lt;div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample"&gt;
&lt;div class="accordion-body"&gt;
&lt;p&gt;
Web design&lt;em class="txt-danger"&gt; identifies the goals&lt;/em&gt; of a website or webpage and promotes accessibility for all potential users. This process involves organizing content and images across a series of pages and integrating applications and other interactive elements.&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="accordion-item accordion-wrapper"&gt;
&lt;h2 class="accordion-header" id="headingTwo"&gt;
&lt;button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"&gt;What is the use of web design?&lt;i class="svg-color" data-feather="chevron-down"&gt;&lt;/i&gt;&lt;/button&gt;
&lt;/h2&gt;
&lt;div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionExample"&gt;
&lt;div class="accordion-body"&gt;
&lt;p&gt; &lt;strong&gt; Search engine optimization: &lt;/strong&gt; Search engine optimization (SEO) is a method for improving the chances for a website to be found by search engines. Web design codes information in a way that search engines can read it. It can boost business because the site shows up on the top search result pages, helping people to find it.&lt;br&gt;&lt;br&gt;&lt;strong&gt; Mobile responsiveness:&lt;/strong&gt; Mobile responsiveness is the feature of a website that allows it to display on a mobile device and adapt its layout and proportions to be legible. Web design ensures sites are easy to view and navigate from mobile devices. When a website is well-designed and mobile-responsive, customers can reach the business with ease.&lt;br&gt;&lt;br&gt;&lt;strong&gt; Improved sales:&lt;/strong&gt;Increasing the number of items sold or acquiring more active customers are objectives of a compelling website. As web design reaches targeted customers and search engines, it helps the business make conversions on their site and improve its sales.&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;div class="accordion-item accordion-wrapper"&gt;
&lt;h2 class="accordion-header" id="headingThree"&gt;
&lt;button class="accordion-button collapsed accordion-light-primary txt-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"&gt;What are the elements of web design?&lt;i class="svg-color" data-feather="chevron-down"&gt;&lt;/i&gt;&lt;/button&gt;
&lt;/h2&gt;
&lt;div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample"&gt;
&lt;div class="accordion-body"&gt;
&lt;p&gt;
The web design process allows designers to adjust to any preferences and provide effective solutions. There are many standard components of every web design, including:&lt;br&gt;--&gt; Layout&lt;br&gt;--&gt; Images&lt;br&gt;--&gt; Visual hierarchy&lt;br&gt;--&gt; Color scheme&lt;br&gt;--&gt; Typography&lt;br&gt;--&gt; Navigation&lt;br&gt;--&gt; Readability&lt;br&gt;--&gt; Content&lt;/p&gt;
&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt; </code></pre>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <!-- side-bar colleps block stat-->
                <div class="filter-block">
                  <h4>Brand</h4>
                  <ul>
                    <li>Clothing</li>
                    <li>Bags</li>
                    <li>Footwear</li>
                    <li>Watches</li>
                    <li>ACCESSORIES</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="collection-filter-block">
                  <ul class="pro-services">
                    <li>
                      <div class="media"><i data-feather="truck"></i>
                        <div class="media-body">
                          <h5>Free Shipping                                    </h5>
                          <p>Free Shipping World Wide</p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media"><i data-feather="clock"></i>
                        <div class="media-body">
                          <h5>24 X 7 Service                                    </h5>
                          <p>Online Service For New Customer</p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media"><i data-feather="gift"></i>
                        <div class="media-body">
                          <h5>Festival Offer                                 </h5>
                          <p>New Online Special Festival</p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media"><i data-feather="credit-card"></i>
                        <div class="media-body">
                          <h5>Online Payment                                  </h5>
                          <p>Contrary To Popular Belief.                                   </p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- silde-bar colleps block end here-->
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="row product-page-main">
          <div class="col-sm-12">
            <ul class="nav nav-tabs border-tab nav-primary mb-0" id="top-tab" role="tablist">
              <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="false">Febric</a>
                <div class="material-border"></div>
              </li>
              <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false">Video</a>
                <div class="material-border"></div>
              </li>
              <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="true">Details</a>
                <div class="material-border"></div>
              </li>
              <li class="nav-item"><a class="nav-link" id="brand-top-tab" data-bs-toggle="tab" href="#top-brand" role="tab" aria-controls="top-brand" aria-selected="true">Brand</a>
                <div class="material-border"></div>
              </li>
            </ul>
            <div class="tab-content" id="top-tabContent">
              <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                <p class="mb-0 m-t-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                <p class="mb-0 m-t-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
              </div>
              <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
              </div>
              <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
              </div>
              <div class="tab-pane fade" id="top-brand" role="tabpanel" aria-labelledby="brand-top-tab">
                <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
@endsection
