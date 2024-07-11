
<nav class="bg-sky-700 " >
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between  ">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <!--
            Icon when menu is closed.

            Menu open: "hidden", Menu closed: "block"
          -->
          <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!--
            Icon when menu is open.

            Menu open: "block", Menu closed: "hidden"
          -->
          <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>


      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        {{-- <div class="flex flex-shrink-0 items-center">
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=white&shade=500" alt="Your Company">
        </div> --}}
        <div class="hidden sm:ml-1 sm:block">
          <div class="flex space-x-1">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->


            <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class=" flex items-center h-10 leading-4 px-1 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Master</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('sources.index') }}" class=" border border-gray-300    px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer "> <span class="flex-1">Category</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('categories.index') }}" class=" border border-gray-300  px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Items</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('dimensions.index') }}" class=" border border-gray-300  px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Dimensions</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('brands.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Specification</span> </a>
                            </li>


                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('suppliers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Suppliers</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('customers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Customers</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('cares.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">CareOf</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('locations.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Location</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('heads.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Account Heads</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('subheads.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Chart Of Accounts</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('hscodes.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">HS Code</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('materials.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Materials</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('banks.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Banks</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('openinggodownstock.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Item Opening Stock</span> </a>
                            </li>



                        </ul>
                    </div>
                </div>
            </li>


            <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Office</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" >
                                <a href="{{ route('contracts.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Contracts</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('cis.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Import Purchase Invoice</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('localpurchase.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Local Purchase Invoice</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('purchasereturn.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Return Invoice</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('clearance.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Duty Clearance</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('quotations.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Price Quotation</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('customerorder.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Order</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('saleinvoices.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice W/PO</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('salewopo.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice WO/PO</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('salereturn.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('banktransaction.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Payment Voucher</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('banktransactionr.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Receive Voucher</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('bankrecivings.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Cheque Collection</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('jv.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Journal Vouchers</span> </a>
                            </li>

                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('godownmovement.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Stock Transfer Order</span> </a>
                            </li>



                        </ul>
                    </div>
                </div>
            </li>



            <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Godown</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" >
                                <a href="{{ route('purchasing.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Receive Not (I)</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('purchasingloc.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Receive Not (L)</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('gatepasse.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Gate Pass</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('godownpr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Return</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('godownsr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('godownmovementr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Movement Gate Pass</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('customerorder.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Order</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('saleinvoices.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice W/PO</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('salewopo.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice WO/PO</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('salereturn.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>


            <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Reports</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" >
                                <a href="{{ route('purrpt.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('salerpt.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('reports.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Financial</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('stockledgers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Material Stock Ledgers</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="{{ route('analysis.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Analysis</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>


            <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Utility</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" >
                                <a href="{{ route('users.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">User Setup</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Permission Setup</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Color Setup</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Locking</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
<a href="{{ route('mastersetup') }}" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>

            {{-- <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
                <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
                text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
                    <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
                    <span>Dashboard</span>
                    <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
                    <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
                    <div class="bg-white rounded w-full relative z-10 py-1">
                        <ul class="list-reset">
                            <li class="relative" x-data="{showChildren:false}" >
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Finance</span> </a>
                            </li>
                            <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                                <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Analytics</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>




 --}}


            {{-- <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a> --}}
          </div>
        </div>
       </div>


       <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="absolute -inset-1.5"></span>
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
        </button>

        <!-- Profile dropdown -->



        <div class="relative ml-3">



          <div>
            <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">Open user menu</span>
              {{-- <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> --}}
            </button>
          </div>



          <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->

          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <x-dropdown align="right" width="48" >
                <x-slot name="trigger">
                    <button
                        class="flex items-center text-sm font-medium text-white hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content" >
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>







          {{-- <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"> --}}
            <!-- Active: "bg-gray-100", Not Active: "" -->
            {{-- <a href="{{ route('cis.index') }}" class=" block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a> --}}

        {{-- </div> --}}
        </div>
      </div>
    </div>
</div>



  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden" id="mobile-menu">
    <div class="space-y-1 px-2 pb-3 pt-2">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->


      <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class=" flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Master Setup</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('sources.index') }}" class=" border border-gray-300    px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer "> <span class="flex-1">Category</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('categories.index') }}" class=" border border-gray-300  px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Items</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('dimensions.index') }}" class=" border border-gray-300  px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Dimensions</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('brands.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Specification</span> </a>
                    </li>


                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('suppliers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Suppliers</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('customers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Customers</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('cares.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">CareOf</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('locations.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Location</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('heads.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Account Heads</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('subheads.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Chart Of Accounts</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('hscodes.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">HS Code</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('materials.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Materials</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('banks.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Banks</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('openinggodownstock.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Item Opening Stock</span> </a>
                    </li>



                </ul>
            </div>
        </div>
    </li>



    <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Office Transaction</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" >
                        <a href="{{ route('contracts.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Contracts</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('cis.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Import Purchase Invoice</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('localpurchase.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Local Purchase Invoice</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('purchasereturn.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Return Invoice</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('clearance.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Duty Clearance</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('quotations.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Price Quotation</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('customerorder.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Order</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('saleinvoices.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice W/PO</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('salewopo.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice WO/PO</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('salereturn.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('banktransaction.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Payment Voucher</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('banktransactionr.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Receive Voucher</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('bankrecivings.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Cheque Collection</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('jv.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Journal Vouchers</span> </a>
                    </li>

                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('godownmovement.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Stock Transfer Order</span> </a>
                    </li>



                </ul>
            </div>
        </div>
    </li>






    <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Godown Transaction</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" >
                        <a href="{{ route('purchasing.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Receive Not (I)</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('purchasingloc.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Receive Not (L)</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('gatepasse.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Gate Pass</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('godownpr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Return</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('godownsr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('godownmovementr.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Goods Movement Gate Pass</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('customerorder.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase Order</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('saleinvoices.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice W/PO</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('salewopo.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Invoice WO/PO</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('salereturn.index') }}"  class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale Return</span> </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>


    <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Reports</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" >
                        <a href="{{ route('purrpt.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('salerpt.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('reports.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Financial</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('stockledgers.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Material Stock Ledgers</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="{{ route('analysis.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Analysis</span> </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>


    <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Utility</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" >
                        <a href="{{ route('users.index') }}" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">User Setup</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Permission Setup</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Color Setup</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Locking</span> </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>


    {{-- <li class="block relative" x-data="{showChildren:false}" @click.away="showChildren=false">
        <a href="#" class="flex items-center h-10 leading-10 px-4 rounded cursor-pointer no-underline hover:no-underline transition-colors
        text-white duration-100 mx-1 hover:bg-black" @click.prevent="showChildren=!showChildren">
            <span class="mr-3 text-xl "> <i class="mdi mdi-apple-safari"></i> </span>
            <span>Dashboard</span>
            <span class="ml-2"> <i class="mdi mdi-chevron-down"></i> </span>
        </a>
        <div class="bg-white shadow-md rounded border border-gray-300 text-sm absolute top-auto left-0 min-w-full w-56 z-30 mt-1" x-show="showChildren" x-transition:enter="transition ease duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease duration-300 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
            <span class="absolute top-0 left-0 w-3 h-3 bg-white border transform rotate-45 -mt-1 ml-6"></span>
            <div class="bg-white rounded w-full relative z-10 py-1">
                <ul class="list-reset">
                    <li class="relative" x-data="{showChildren:false}" >
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Purchase</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Sale</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Finance</span> </a>
                    </li>
                    <li class="relative" x-data="{showChildren:false}" @mouseleave="showChildren=false" @mouseenter="showChildren=true">
                        <a href="" class=" border border-gray-300 px-4 py-2 flex w-full items-start hover:bg-sky-700 no-underline hover:no-underline transition-colors duration-100 cursor-pointer"> <span class="flex-1">Analytics</span> </a>
                    </li>
                </ul>
            </div>
        </div>
    </li> --}}


      <a href="{{ route('mastersetup') }}" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>
      {{-- <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>  --}}

    </div>

</div>


</nav>
{{-- @yield('contents') --}}

