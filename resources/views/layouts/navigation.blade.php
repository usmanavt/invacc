<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('mastersetup') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Master Setup -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="left" width="60">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <x-dropdown-link href="{{ route('mastersetup') }}">Master</x-dropdown-link>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-20" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('categories.index') }}">Categories</x-dropdown-link>
                            <x-dropdown-link href="{{ route('dimensions.index') }}">Dimensions</x-dropdown-link>
                            <x-dropdown-link href="{{ route('brands.index') }}">Brands</x-dropdown-link>
                            <x-dropdown-link href="{{ route('suppliers.index') }}">Suppliers</x-dropdown-link>
                            <x-dropdown-link href="{{ route('customers.index') }}">Customers</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cares.index') }}">CareOf</x-dropdown-link>
                            <x-dropdown-link href="{{ route('locations.index') }}">Locations</x-dropdown-link>
                            <x-dropdown-link href="{{ route('heads.index') }}">Account Heads</x-dropdown-link>
                            <x-dropdown-link href="{{ route('subheads.index') }}">Chart of Accounts</x-dropdown-link>
                            <x-dropdown-link href="{{ route('hscodes.index') }}">Hscode</x-dropdown-link>
                            <x-dropdown-link href="{{ route('materials.index') }}">Materials</x-dropdown-link>
                            <x-dropdown-link href="{{ route('banks.index') }}">Banks</x-dropdown-link>
                            @if (auth()->user()->email == 'ali.jibran@auvitronics.com')
                                <x-dropdown-link href="{{ route('users.index') }}">Users</x-dropdown-link>

                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Transactions --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="left" width="100">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <x-dropdown-link href="{{ route('transaction') }}">Transaction</x-dropdown-link>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-20" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link href="{{ route('contracts.index') }}">Contracts</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cis.index') }}">Imported Purchase</x-dropdown-link>
                            <x-dropdown-link href="{{ route('localpurchase.index') }}">Local Purchase</x-dropdown-link>
                            <x-dropdown-link href="{{ route('clearance.index') }}">Duty Clearance</x-dropdown-link>
                            <x-dropdown-link href="{{ route('quotations.index') }}">Price Quotation</x-dropdown-link>
                            <x-dropdown-link href="{{ route('customerorder.index') }}">Purchase Order</x-dropdown-link>
                            <x-dropdown-link href="{{ route('saleinvoices.index') }}">Sales Invoice</x-dropdown-link>
                            <x-dropdown-link href="{{ route('salereturn.index') }}">Sales Return</x-dropdown-link>
                            <x-dropdown-link href="{{ route('bankpayments.index') }}">Bank Payments</x-dropdown-link>
                            <x-dropdown-link href="{{ route('bankrecivings.index') }}">Bank Recivings</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cashpayments.index') }}">Cash Payments</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cashrecivings.index') }}">Cash Receiving</x-dropdown-link>
                            <x-dropdown-link href="{{ route('jv.index') }}">Journal Vouchers</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>


                {{-- Reports --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <x-dropdown-link href="{{ route('transaction') }}">Reports</x-dropdown-link>

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

                        <x-slot name="content">

                            {{-- <x-dropdown-link href="{{ route('transaction') }}">Transaction</x-dropdown-link> --}}

                            <x-dropdown-link href="{{ route('purrpt.index') }}">Purchase</x-dropdown-link>
                            <x-dropdown-link href="{{ route('dutyclearance.index') }}">Duty Clearance</x-dropdown-link>
                            <x-dropdown-link href="{{ route('salerpt.index') }}">Sale</x-dropdown-link>
                            <x-dropdown-link href="{{ route('reports.index') }}">Financial</x-dropdown-link>
                            <x-dropdown-link href="{{ route('stockledgers.index') }}">Material Stock Ledgers</x-dropdown-link>


                            {{-- <x-dropdown-link href="{{ route('cisl.index') }}">Comm Invoices Local</x-dropdown-link> --}}
                            {{-- <x-dropdown-link href="{{ route('localpurchase.index') }}">Comm Invoices Local</x-dropdown-link>
                            <x-dropdown-link href="{{ route('recivings.index') }}">Goods Reciving</x-dropdown-link>
                            <x-dropdown-link href="{{ route('clearances.index') }}">Duty Clearance</x-dropdown-link>
                            <x-dropdown-link href="{{ route('sales.index') }}">Sales Invoice</x-dropdown-link>
                            <x-dropdown-link href="{{ route('bankpayments.index') }}">Bank Payments</x-dropdown-link>
                            <x-dropdown-link href="{{ route('bankrecivings.index') }}">Bank Recivings</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cashpayments.index') }}">Cash Payments</x-dropdown-link>
                            <x-dropdown-link href="{{ route('cashrecivings.index') }}">Cash Receiving</x-dropdown-link>
                            <x-dropdown-link href="{{ route('jv.index') }}">Journal Vouchers</x-dropdown-link> --}}
                        </x-slot>
                    </x-dropdown>
                </div>


                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    {{-- <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <x-dropdown-link href="{{ route('reports') }}">Reports</x-dropdown-link>

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

                    </x-dropdown> --}}
                    {{-- <x-nav-link href="{{ route('reports.index') }}">Reports</x-nav-link> --}}
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
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

                    <x-slot name="content">
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

            <!-- Hamburger -->
            {{-- <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    {{-- <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div> --}}
</nav>
