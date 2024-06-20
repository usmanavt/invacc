<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Mono - Responsive Admin & Dashboard Template</title>

  <!-- theme meta -->
  <meta name="theme-name" content="mono" />

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">


  <link href="{{asset('assets/auth/plugins/material/css/materialdesignicons.min.css')}}  " rel="stylesheet" />
  {{-- <link href="plugins/material/css/materialdesignicons.min.css" rel="stylesheet" /> --}}

  <link href="{{asset('assets/auth/plugins/simplebar/simplebar.css')}}  " rel="stylesheet" />
  {{-- <link href="plugins/simplebar/simplebar.css" rel="stylesheet" /> --}}

  <!-- PLUGINS CSS STYLE -->
  {{-- <link href="{{asset('assets/auth/plugins/nprogress/nprogress.css')}}  " rel="stylesheet" /> --}}



  {{-- <link href="{{asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css')}}  " rel="stylesheet" /> --}}


  {{-- <link href="{{asset('assets/auth/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}  " rel="stylesheet" /> --}}
  {{-- <link href="{{asset('assets/auth/plugins/daterangepicker/daterangepicker.css')}}  " rel="stylesheet" /> --}}



  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


  {{-- <link href="{{asset('assets/auth/plugins/toaster/toastr.min.css')}}  " rel="stylesheet" /> --}}


  <!-- MONO CSS -->
  <link id="main-css-href" rel="stylesheet" href={{asset('assets/auth/css/style.css')}}   />




  <!-- FAVICON -->
  <link href=" {{asset('assets/auth/images/favicon.png')}}" rel="shortcut icon" />

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  {{-- <link href="{{asset('assets/auth/plugins/nprogress/nprogress.js')}}  " rel="stylesheet" /> --}}
  {{-- <script src="plugins/nprogress/nprogress.js"></script> --}}
</head>





@yield('contents')




<body class="navbar-fixed sidebar-fixed" id="body">
    {{-- <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script> --}}


    <div id="toaster"></div>


    <!-- ====================================
    ——— WRAPPER
    ===================================== -->





    <div class="wrapper">


        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
          <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="/index.html">
                <img src= "{{asset('assets/auth/images/logo.png')}}"    alt="Mono">


                <span class="brand-name">MN & CO.</span>
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-left" data-simplebar style="height: 100%;">
              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">



                  {{-- <li
                   class="active"
                   >
                    <a class="sidenav-item-link" href="index.html">
                      <i class="mdi mdi-briefcase-account-outline"></i>
                      <span class="nav-text">Business Dashboard</span>
                    </a>
                  </li>


                  <li
                   >
                    <a class="sidenav-item-link" href="analytics.html">
                      <i class="mdi mdi-chart-line"></i>
                      <span class="nav-text">Analytics Dashboard</span>
                    </a>
                  </li> --}}





                  <li class="section-title" style="font-weight: bold;text-align: left;font-size:1rem;color:chartreuse">
                    ENTRY FORMS & REPORTS
                  </li>






                  {{-- <li
                   >
                    <a class="sidenav-item-link" href="chat.html">
                      <i class="mdi mdi-wechat"></i>
                      <span class="nav-text">Chat</span>
                    </a>
                  </li> --}}





                  {{-- <li
                   >
                    <a class="sidenav-item-link" href="contacts.html">
                      <i class="mdi mdi-phone"></i>
                      <span class="nav-text">Contacts</span>
                    </a>
                  </li> --}}





                  {{-- <li
                   >
                    <a class="sidenav-item-link" href="team.html">
                      <i class="mdi mdi-account-group"></i>
                      <span class="nav-text">Team</span>
                    </a>
                  </li> --}}





                  {{-- <li
                   >
                    <a class="sidenav-item-link" href="calendar.html">
                      <i class="mdi mdi-calendar-check"></i>
                      <span class="nav-text">Calendar</span>
                    </a>
                  </li> --}}





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#email"
                      aria-expanded="false" aria-controls="email">
                      <i class="mdi mdi-email"></i>
                      <span class="nav-text">MASTER SETUP</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="email"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">

                            <li >
                              <a class="sidenav-item-link" href="{{ route('users.index') }}">
                                <span class="nav-text">Users</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('sources.index') }}">
                                  <span class="nav-text">Category</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('categories.index') }}">
                                  <span class="nav-text">Items</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('dimensions.index') }}">
                                  <span class="nav-text">Dimension</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('brands.index') }}">
                                  <span class="nav-text">Specification</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('suppliers.index') }}">
                                  <span class="nav-text">Suppliers</span>
                                </a>
                              </li>
                            <li >
                              <a class="sidenav-item-link" href="{{ route('customers.index') }}">
                                <span class="nav-text">Customers</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('cares.index') }}">
                                <span class="nav-text">CareOf</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('locations.index') }}">
                                <span class="nav-text">Location</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('heads.index') }}">
                                <span class="nav-text">Accounts Head</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('subheads.index') }}">
                                    <span class="nav-text">Chart Of Account</span>
                                  </a>
                                </li>

                                <li >
                                    <a class="sidenav-item-link" href="{{ route('hscodes.index') }}">
                                        <span class="nav-text">HS Code</span>
                                      </a>
                                    </li>
                                    <li >
                                <li >
                                    <a class="sidenav-item-link" href="{{ route('materials.index') }}">
                                        <span class="nav-text">Material</span>
                                        </a>
                                    </li>
                                    <li >
                                        <li >
                                            <a class="sidenav-item-link" href="{{ route('banks.index') }}">
                                                <span class="nav-text">Bank</span>
                                                </a>
                                            </li>
                                            <li >

                                                <li >
                                                    <a class="sidenav-item-link" href="{{ route('openinggodownstock.index') }}">
                                                        <span class="nav-text">Item Opening Stock</span>
                                                        </a>
                                                    </li>
                                                    <li >







                              {{-- <li >
                              <a class="sidenav-item-link" href="email-details.html">
                                <span class="nav-text">xyz</span>

                              </a>
                            </li>


                            <li >
                              <a class="sidenav-item-link" href="email-compose.html">
                                <span class="nav-text">Items</span>

                              </a>
                            </li> --}}




                      </div>
                    </ul>
                  </li>


                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#trans"
                      aria-expanded="false" aria-controls="trans">
                      <i class="mdi mdi-trans"></i>
                      <span class="nav-text">OFFICE TRANSACTION</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="trans"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">

                            <li >
                              <a class="sidenav-item-link" href="{{ route('contracts.index') }}">
                                <span class="nav-text">Contracts</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('cis.index') }}">
                                  <span class="nav-text">Import Purchase</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('localpurchase.index') }}">
                                  <span class="nav-text">Local Purchase</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('purchasereturn.index') }}">
                                  <span class="nav-text">Purchase Return</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('clearance.index') }}">
                                  <span class="nav-text">Duty Clearance</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('quotations.index') }}">
                                  <span class="nav-text">Price Quotaion</span>
                                </a>
                              </li>
                            <li >
                              <a class="sidenav-item-link" href="{{ route('customerorder.index') }}">
                                <span class="nav-text">Purchase Order</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('saleinvoices.index') }}">
                                <span class="nav-text">SaleInvoice W PO</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('salewopo.index') }}">
                                <span class="nav-text">SaleInvoice W/O PO</span>
                              </a>
                            </li>

                            <li >
                            <a class="sidenav-item-link" href="{{ route('salereturn.index') }}">
                                <span class="nav-text">Sale Return</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('banktransaction.index') }}">
                                    <span class="nav-text">Payment Voucher</span>
                                  </a>
                                </li>

                                <li >
                                    <a class="sidenav-item-link" href="{{ route('banktransactionr.index') }}">
                                        <span class="nav-text">Receive Voucher</span>
                                      </a>
                                    </li>
                                    <li >
                                <li >
                                    <a class="sidenav-item-link" href="{{ route('bankrecivings.index') }}">
                                        <span class="nav-text">Cheque Collection</span>
                                        </a>
                                    </li>
                                    <li >
                                        <li >
                                            <a class="sidenav-item-link" href="{{ route('jv.index') }}">
                                                <span class="nav-text">Jeneral Voucher</span>
                                                </a>
                                            </li>
                                            <li >

                                                <li >
                                                    <a class="sidenav-item-link" href="{{ route('godownmovement.index') }}">
                                                        <span class="nav-text">Goods Movement</span>
                                                        </a>
                                                    </li>
                                                    <li >







                              {{-- <li >
                              <a class="sidenav-item-link" href="email-details.html">
                                <span class="nav-text">xyz</span>

                              </a>
                            </li>


                            <li >
                              <a class="sidenav-item-link" href="email-compose.html">
                                <span class="nav-text">Items</span>

                              </a>
                            </li> --}}




                      </div>
                    </ul>
                  </li>




                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#gtrans"
                      aria-expanded="false" aria-controls="gtrans">
                      <i class="mdi mdi-gtrans"></i>
                      <span class="nav-text">GODOWN TRANSACTION</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="gtrans"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">

                            <li >
                              <a class="sidenav-item-link" href="{{ route('purchasing.index') }}">
                                <span class="nav-text">Goods Receive Not (I)</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('purchasingloc.index') }}">
                                  <span class="nav-text">Goods Receive Not (L)</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('gatepasse.index') }}">
                                  <span class="nav-text">Gate Pass</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('godownpr.index') }}">
                                  <span class="nav-text">Purchase Retunr</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('godownsr.index') }}">
                                  <span class="nav-text">Sale Return</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('godownmovementr.index') }}">
                                  <span class="nav-text">Goods Movement GatePass</span>
                                </a>
                              </li>







                              {{-- <li >
                              <a class="sidenav-item-link" href="email-details.html">
                                <span class="nav-text">xyz</span>

                              </a>
                            </li>


                            <li >
                              <a class="sidenav-item-link" href="email-compose.html">
                                <span class="nav-text">Items</span>

                              </a>
                            </li> --}}




                      </div>
                    </ul>
                  </li>

                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#reports"
                      aria-expanded="false" aria-controls="reports">
                      <i class="mdi mdi-reports"></i>
                      <span class="nav-text">REPORTS</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="reports"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">

                            <li >
                              <a class="sidenav-item-link" href="{{ route('purrpt.index') }}">
                                <span class="nav-text">Purchase</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="{{ route('salerpt.index') }}">
                                  <span class="nav-text">Sale</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('reports.index') }}">
                                  <span class="nav-text">Financial</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="{{ route('stockledgers.index') }}">
                                  <span class="nav-text">Stock Ledgers</span>
                                </a>
                              </li>


                              <li >
                                <a class="sidenav-item-link" href="{{ route('analysis.index') }}">
                                  <span class="nav-text">Analysis</span>
                                </a>
                              </li>





                      </div>
                    </ul>
                  </li>


                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#utility"
                      aria-expanded="false" aria-controls="utility">
                      <i class="mdi mdi-utility"></i>
                      <span class="nav-text">UTILITY</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="utility"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">

                            <li >
                              <a class="sidenav-item-link" href="">
                                <span class="nav-text">Permission Setup</span>
                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="">
                                  <span class="nav-text">Lock Transaction</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="">
                                  <span class="nav-text">Form Color Setup</span>
                                </a>
                              </li>

                              <li >
                                <a class="sidenav-item-link" href="">
                                  <span class="nav-text">Edit/Delete Password Change</span>
                                </a>
                              </li>


                              {{-- <li >
                                <a class="sidenav-item-link" href="{{ route('analysis.index') }}">
                                  <span class="nav-text">Analysis</span>
                                </a>
                              </li> --}}





                      </div>
                    </ul>
                  </li>



                  <li class="section-title" style="font-weight: bold;text-align: left;font-size:1rem;color:chartreuse">
                    DASHBOARD
                  </li>







                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#BusinessDashboard"
                      aria-expanded="false" aria-controls="BusinessDashboard">
                      <i class="mdi mdi-folder-outline"></i>
                      <span class="nav-text">Business Dashboard</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="BusinessDashboard"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="">
                                <span class="nav-text">Sale</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="">
                                <span class="nav-text">Purchase</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="">
                                <span class="nav-text">Payment Voucher</span>

                              </a>
                            </li>

                            <li >
                                <a class="sidenav-item-link" href="">
                                  <span class="nav-text">Received Voucher</span>

                                </a>
                              </li>


                              <li >
                                <a class="sidenav-item-link" href="">
                                  <span class="nav-text" style="font-weight:bold;color:brown" >Analytics Dashboard</span>

                                </a>
                              </li>


                        {{-- <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#buttons"
                            aria-expanded="false" aria-controls="buttons">
                            <span class="nav-text">Buttons</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="buttons">
                            <div class="sub-menu">

                              <li >
                                <a href="button-default.html">Button Default</a>
                              </li>

                              <li >
                                <a href="button-dropdown.html">Button Dropdown</a>
                              </li>

                              <li >
                                <a href="button-group.html">Button Group</a>
                              </li>

                              <li >
                                <a href="button-social.html">Button Social</a>
                              </li>

                              <li >
                                <a href="button-loading.html">Button Loading</a>
                              </li>

                            </div>
                          </ul>
                        </li>





                            <li >
                              <a class="sidenav-item-link" href="card.html">
                                <span class="nav-text">Card</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="carousel.html">
                                <span class="nav-text">Carousel</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="collapse.html">
                                <span class="nav-text">Collapse</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="editor.html">
                                <span class="nav-text">Editor</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="list-group.html">
                                <span class="nav-text">List Group</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="modal.html">
                                <span class="nav-text">Modal</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="pagination.html">
                                <span class="nav-text">Pagination</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="popover-tooltip.html">
                                <span class="nav-text">Popover & Tooltip</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="progress-bar.html">
                                <span class="nav-text">Progress Bar</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="spinner.html">
                                <span class="nav-text">Spinner</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="switches.html">
                                <span class="nav-text">Switches</span>

                              </a>
                            </li>
 --}}




                        {{-- <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#tables"
                            aria-expanded="false" aria-controls="tables">
                            <span class="nav-text">Tables</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="tables">
                            <div class="sub-menu">

                              <li >
                                <a href="bootstarp-tables.html">Bootstrap Tables</a>
                              </li>

                              <li >
                                <a href="data-tables.html">Data Tables</a>
                              </li>

                            </div>
                          </ul>
                        </li>





                            <li >
                              <a class="sidenav-item-link" href="tab.html">
                                <span class="nav-text">Tab</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="toaster.html">
                                <span class="nav-text">Toaster</span>

                              </a>
                            </li>





                        <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#icons"
                            aria-expanded="false" aria-controls="icons">
                            <span class="nav-text">Icons</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="icons">
                            <div class="sub-menu">

                              <li >
                                <a href="material-icons.html">Material Icon</a>
                              </li>

                              <li >
                                <a href="flag-icons.html">Flag Icon</a>
                              </li>

                            </div>
                          </ul>
                        </li>




                        <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#forms"
                            aria-expanded="false" aria-controls="forms">
                            <span class="nav-text">Forms</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="forms">
                            <div class="sub-menu">

                              <li >
                                <a href="basic-input.html">Basic Input</a>
                              </li>

                              <li >
                                <a href="input-group.html">Input Group</a>
                              </li>

                              <li >
                                <a href="checkbox-radio.html">Checkbox & Radio</a>
                              </li>

                              <li >
                                <a href="form-validation.html">Form Validation</a>
                              </li>

                              <li >
                                <a href="form-advance.html">Form Advance</a>
                              </li>

                            </div>
                          </ul>
                        </li>




                        <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#maps"
                            aria-expanded="false" aria-controls="maps">
                            <span class="nav-text">Maps</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="maps">
                            <div class="sub-menu">

                              <li >
                                <a href="google-maps.html">Google Map</a>
                              </li>

                              <li >
                                <a href="vector-maps.html">Vector Map</a>
                              </li>

                            </div>
                          </ul>
                        </li>




                        <li  class="has-sub" >
                          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#widgets"
                            aria-expanded="false" aria-controls="widgets">
                            <span class="nav-text">Widgets</span> <b class="caret"></b>
                          </a>
                          <ul  class="collapse"  id="widgets">
                            <div class="sub-menu">

                              <li >
                                <a href="widgets-general.html">General Widget</a>
                              </li>

                              <li >
                                <a href="widgets-chart.html">Chart Widget</a>
                              </li>

                            </div>
                          </ul>
                        </li>



                      </div>
                    </ul>
                  </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#charts"
                      aria-expanded="false" aria-controls="charts">
                      <i class="mdi mdi-chart-pie"></i>
                      <span class="nav-text">Charts</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="charts"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="apex-charts.html">
                                <span class="nav-text">Apex Charts</span>

                              </a>
                            </li>




                      </div>
                    </ul>
                  </li>





                  <li class="section-title">
                    Pages
                  </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#users"
                      aria-expanded="false" aria-controls="users">
                      <i class="mdi mdi-image-filter-none"></i>
                      <span class="nav-text">User</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="users"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="user-profile.html">
                                <span class="nav-text">User Profile</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-activities.html">
                                <span class="nav-text">User Activities</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-profile-settings.html">
                                <span class="nav-text">User Profile Settings</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-account-settings.html">
                                <span class="nav-text">User Account Settings</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-planing-settings.html">
                                <span class="nav-text">User Planing Settings</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-billing.html">
                                <span class="nav-text">User billing</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="user-notify-settings.html">
                                <span class="nav-text">User Notify Settings</span>

                              </a>
                            </li>




                      </div>
                    </ul>
                  </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#authentication"
                      aria-expanded="false" aria-controls="authentication">
                      <i class="mdi mdi-account"></i>
                      <span class="nav-text">Authentication</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="authentication"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="sign-in.html">
                                <span class="nav-text">Sign In</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="sign-up.html">
                                <span class="nav-text">Sign Up</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="reset-password.html">
                                <span class="nav-text">Reset Password</span>

                              </a>
                            </li>




                      </div>
                    </ul>
                  </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#other-page"
                      aria-expanded="false" aria-controls="other-page">
                      <i class="mdi mdi-file-multiple"></i>
                      <span class="nav-text">Other pages</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="other-page"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="invoice.html">
                                <span class="nav-text">Invoice</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="404.html">
                                <span class="nav-text">404 page</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="page-comingsoon.html">
                                <span class="nav-text">Coming Soon</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="page-maintenance.html">
                                <span class="nav-text">Maintenance</span>

                              </a>
                            </li>




                      </div>
                    </ul>
                  </li>





                  <li class="section-title">
                    Documentation
                  </li> --}}





                  {{-- <li
                   >
                    <a class="sidenav-item-link" href="getting-started.html">
                      <i class="mdi mdi-airplane"></i>
                      <span class="nav-text">Getting Started</span>
                    </a>
                  </li> --}}





                  {{-- <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#customization"
                      aria-expanded="false" aria-controls="customization">
                      <i class="mdi mdi-square-edit-outline"></i>
                      <span class="nav-text">Customization</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="customization"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">



                            <li >
                              <a class="sidenav-item-link" href="navbar-customization.html">
                                <span class="nav-text">Navbar</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="sidebar-customization.html">
                                <span class="nav-text">Sidebar</span>

                              </a>
                            </li>






                            <li >
                              <a class="sidenav-item-link" href="styling.html">
                                <span class="nav-text">Styling</span>

                              </a>
                            </li> --}}




                      </div>
                    </ul>
                  </li>



              </ul>

            </div>

            <div class="sidebar-footer">
              <div class="sidebar-footer-content">
                <ul class="d-flex">
                  <li>
                    <a href="user-account-settings.html" data-toggle="tooltip" title="Profile settings"><i class="mdi mdi-settings"></i></a></li>
                  <li>
                    <a href="#" data-toggle="tooltip" title="No chat messages"><i class="mdi mdi-chat-processing"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </aside>

<div class="page-wrapper">


      <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
      @yield('content')




                    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


                    <script src="{{asset('assets/auth/plugins/toaster/toastr.min.js')}}"></script>
                    {{-- <script src="plugins/toaster/toastr.min.js"></script> --}}



                    {{-- <script src="{{asset('assets/auth/js/mono.js')}}"></script> --}}
                    {{-- <script src="{{asset('assets/auth/js/chart.js')}}"></script> --}}
                    {{-- <script src="{{asset('assets/auth/js/map.js')}}"></script> --}}
                    {{-- <script src="{{asset('assets/auth/js/custom.js')}}"></script> --}}
                    <!--  -->

                    <script src="{{asset('assets/auth/plugins/jquery/jquery.min.js')}}"></script>
                    <script src="{{asset('assets/auth/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
                    <script src="{{asset('assets/auth/plugins/simplebar/simplebar.min.js')}}"></script>
                    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>



  </body>
</html>
