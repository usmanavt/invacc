{{-- @section('mydbheader') --}}





<div style="border:1px solid black;">



        <header class="main-header" id="header">
        <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
        <!-- Sidebar toggle button -->
        <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
        </button>



            <div class="navbar navbar-static-top margin-left:10px; margin-right:10px;margin-bottom:5px;" >

                <div class="accent-purple-500 "  >

                    <a href="{{ route('contracts.index') }}">
                      <img title="Contracts" src= "{{asset('assets/auth/images/contract.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 " >
                    <a href="{{ route('cis.index') }}">
                      <img title="Import Purchasing" src= "{{asset('assets/auth/images/ipurchase.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 " >
                    <a href="{{ route('localpurchase.index') }}">
                      <img title="Local Purchasing" src= "{{asset('assets/auth/images/lpurchase.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('purchasereturn.index') }}">
                      <img title="Purchase Return" src= "{{asset('assets/auth/images/purchasereturn.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('clearance.index') }}">
                      <img title="Duty Clearance" src= "{{asset('assets/auth/images/dutyclear.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('quotations.index') }}">
                      <img title="Price Quotation" src= "{{asset('assets/auth/images/pricequotation.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('customerorder.index') }}">
                      <img title="Purchase Order" src= "{{asset('assets/auth/images/purchaseorder.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('saleinvoices.index') }}">
                      <img title="Sale W P.O" src= "{{asset('assets/auth/images/salewpo.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('salewopo.index') }}">
                      <img title="Sale W/O P.O" src= "{{asset('assets/auth/images/salewopo.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('salereturn.index') }}">
                      <img title="Sale Return" src= "{{asset('assets/auth/images/salereturn.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('banktransaction.index') }}">
                      <img title="Payment Voucher" src= "{{asset('assets/auth/images/payment.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('banktransactionr.index') }}">
                      <img title="Receive Voucher" src= "{{asset('assets/auth/images/received.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('bankrecivings.index') }}">
                      <img title="Cheque Collection" src= "{{asset('assets/auth/images/chequecoll.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('jv.index') }}">
                      <img title="Jeneral Voucher" src= "{{asset('assets/auth/images/jv.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('godownmovement.index') }}">
                      <img title="Goods Movement" src= "{{asset('assets/auth/images/goodstransfer.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('purchasing.index') }}">
                      <img title="Good Received in Godown(Imported)" src= "{{asset('assets/auth/images/goodsrcvdi.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('purchasingloc.index') }}">
                      <img title="Good Received in Godown(Local)" src= "{{asset('assets/auth/images/goodsrcvdl.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('gatepasse.index') }}">
                      <img title="Gate Pass" src= "{{asset('assets/auth/images/gatepass.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('godownpr.index') }}">
                      <img title="Pruchase Return(Godown)" src= "{{asset('assets/auth/images/purreturnwh.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('godownsr.index') }}">
                      <img title="Sale Return(Godown)" src= "{{asset('assets/auth/images/salereturnwh.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('godownmovementr.index') }}">
                      <img title="Goods Movement(Godown)" src= "{{asset('assets/auth/images/goodsmovementwh.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('purrpt.index') }}">
                      <img title="Purchasing Reports" src= "{{asset('assets/auth/images/purchasereport.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('salerpt.index') }}">
                      <img title="Sale Reports" src= "{{asset('assets/auth/images/salereport.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('reports.index') }}">
                      <img title="Financial Reports" src= "{{asset('assets/auth/images/financial.png')}}" >
                    </a>
                  </div>


                  <div class="accent-purple-500 ">
                    <a href="{{ route('stockledgers.index') }}">
                      <img title="Stock Ledgers" src= "{{asset('assets/auth/images/stockledger.png')}}" >
                    </a>
                  </div>

                  <div class="accent-purple-500 ">
                    <a href="{{ route('analysis.index') }}">
                      <img title="Stock Ledgers" src= "{{asset('assets/auth/images/analysis.png')}}" >
                    </a>
                  </div>




            <!-- search form -->
            {{-- <div class="search-form">
            <form action="index.html" method="get">
                <div class="input-group input-group-sm" id="input-group-search">
                <input type="text" autocomplete="off" name="query" id="search-input" class="form-control" placeholder="Search..." />
                <div class="input-group-append">
                    <button class="btn" type="button">/</button>
                </div>
                </div>
            </form>
            <ul class="dropdown-menu dropdown-menu-search">

                <li class="nav-item">
                <a class="nav-link" href="index.html">Morbi leo risus</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="index.html">Dapibus ac facilisis in</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="index.html">Porta ac consectetur ac</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="index.html">Vestibulum at eros</a>
                </li>

            </ul>

            </div> --}}

            {{-- <ul class="nav navbar-nav">
            <!-- Offcanvas -->
            <li class="custom-dropdown">
                <a class="offcanvas-toggler active custom-dropdown-toggler" data-offcanvas="contact-off" href="javascript:" >
                <i class="mdi mdi-contacts icon"></i>
                </a>
            </li>
            <li class="custom-dropdown">
                <button class="notify-toggler custom-dropdown-toggler">
                <i class="mdi mdi-bell-outline icon"></i>
                <span class="badge badge-xs rounded-circle">21</span>
                </button>
                <div class="dropdown-notify">

                <header>
                    <div class="nav nav-underline" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="all-tabs" data-toggle="tab" href="#all" role="tab" aria-controls="nav-home"
                        aria-selected="true">All (5)</a>
                    <a class="nav-item nav-link" id="message-tab" data-toggle="tab" href="#message" role="tab" aria-controls="nav-profile"
                        aria-selected="false">Msgs (4)</a>
                    <a class="nav-item nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="nav-contact"
                        aria-selected="false">Others (3)</a>
                    </div>
                </header>

                <div class="" data-simplebar style="height: 325px;">
                    <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tabs">

                        <div class="media media-sm bg-warning-10 p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src= "{{asset('assets/auth/images/user/user-sm-02.jpg')}}" alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">John Doe</span>
                            <span class="discribe">Extremity sweetness difficult behaviour he of. On disposal of as landlord horrible. Afraid at highly months do things on at.</span>
                            <span class="time">
                                <time>Just now</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 bg-light mb-0">
                        <div class="media-sm-wrapper bg-primary">
                            <a href="user-profile.html">
                            <i class="mdi mdi-calendar-check-outline"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">New event added</span>
                            <span class="discribe">1/3/2014 (1pm - 2pm)</span>
                            <span class="time">
                                <time>10 min ago...</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src="{{asset('assets/auth/images/user/user-sm-03.jpg')}}"  alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Sagge Hudson</span>
                            <span class="discribe">On disposal of as landlord Afraid at highly months do things on at.</span>
                            <span class="time">
                                <time>1 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper bg-info-dark">
                            <a href="user-profile.html">
                            <i class="mdi mdi-account-multiple-check"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Add request</span>
                            <span class="discribe">Add Dany Jones as your contact.</span>
                            <div class="buttons">
                                <a href="#" class="btn btn-sm btn-success shadow-none text-white">accept</a>
                                <a href="#" class="btn btn-sm shadow-none">delete</a>
                            </div>
                            <span class="time">
                                <time>6 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper bg-info">
                            <a href="user-profile.html">
                            <i class="mdi mdi-playlist-check"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Task complete</span>
                            <span class="discribe">Afraid at highly months do things on at.</span>
                            <span class="time">
                                <time>1 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src="{{asset('assets/auth/images/user/user-sm-01.jpg')}}"  alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Selena Wagner</span>
                            <span class="discribe">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                            <span class="time">
                                <time>15 min ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src="{{asset('assets/auth/images/user/user-sm-03.jpg')}}"  alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Sagge Hudson</span>
                            <span class="discribe">On disposal of as landlord Afraid at highly months do things on at.</span>
                            <span class="time">
                                <time>1 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm bg-warning-10 p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src= "{{asset('assets/auth/images/user/user-sm-02.jpg')}}" alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">John Doe</span>
                            <span class="discribe">Extremity sweetness difficult behaviour he of. On disposal of as landlord horrible. Afraid
                                at highly months do things on at.</span>
                            <span class="time">
                                <time>Just now</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper">
                            <a href="user-profile.html">
                            <img src="{{asset('assets/auth/images/user/user-sm-04.jpg')}}"   alt="User Image">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Albrecht Straub</span>
                            <span class="discribe"> Beatae quia natus assumenda laboriosam, nisi perferendis aliquid consectetur expedita non tenetur.</span>
                            <span class="time">
                                <time>Just now</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="contact-tab">

                        <div class="media media-sm p-4 bg-light mb-0">
                        <div class="media-sm-wrapper bg-primary">
                            <a href="user-profile.html">
                            <i class="mdi mdi-calendar-check-outline"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">New event added</span>
                            <span class="discribe">1/3/2014 (1pm - 2pm)</span>
                            <span class="time">
                                <time>10 min ago...</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper bg-info-dark">
                            <a href="user-profile.html">
                            <i class="mdi mdi-account-multiple-check"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Add request</span>
                            <span class="discribe">Add Dany Jones as your contact.</span>
                            <div class="buttons">
                                <a href="#" class="btn btn-sm btn-success shadow-none text-white">accept</a>
                                <a href="#" class="btn btn-sm shadow-none">delete</a>
                            </div>
                            <span class="time">
                                <time>6 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                        <div class="media media-sm p-4 mb-0">
                        <div class="media-sm-wrapper bg-info">
                            <a href="user-profile.html">
                            <i class="mdi mdi-playlist-check"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="user-profile.html">
                            <span class="title mb-0">Task complete</span>
                            <span class="discribe">Afraid at highly months do things on at.</span>
                            <span class="time">
                                <time>1 hrs ago</time>...
                            </span>
                            </a>
                        </div>
                        </div>

                    </div>
                    </div>
                </div>

                </div>
            </li>
            <!-- User Account -->
            <li class="dropdown user-menu">
                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                <img src= "{{asset('assets/auth/images/user/user-xs-01.jpg')}}"  class="user-image rounded-circle" alt="User Image" />
                <span class="d-none d-lg-inline-block">John Doe</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <a class="dropdown-link-item" href="user-profile.html">
                    <i class="mdi mdi-account-outline"></i>
                    <span class="nav-text">My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-link-item" href="email-inbox.html">
                    <i class="mdi mdi-email-outline"></i>
                    <span class="nav-text">Message</span>
                    <span class="badge badge-pill badge-primary">24</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-link-item" href="user-activities.html">
                    <i class="mdi mdi-diamond-stone"></i>
                    <span class="nav-text">Activitise</span></a>
                </li>
                <li>
                    <a class="dropdown-link-item" href="user-account-settings.html">
                    <i class="mdi mdi-settings"></i>
                    <span class="nav-text">Account Setting</span>
                    </a>
                </li>

                <li class="dropdown-footer">
                    <a class="dropdown-link-item" href="sign-in.html"> <i class="mdi mdi-logout"></i> Log Out </a>
                </li>
                </ul>
            </li>
            </ul></div>
        </nav> --}}


  </header>
</div>
  {{-- @endsection --}}

