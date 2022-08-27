<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

{{-- <div class="mt-2">
    @if (isset($co))

    <div>

        <x-label for="mheadid" :value="__('Account Man Head')" />
        <select required name="mheadid" id="mheadid" class="block mt-1 bg-slate-200 text-sm rounded-lg">
            <option value="" disabled >Select careof</option>
            @foreach ($co as $list)
                <option value="{{$list->smid}}" > {{$list->par1}}   </option>
            @endforeach
        </select>
    </div>

    @endif
</div> --}}

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> --}}


    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">.
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('mastersetup') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('mastersetup')" :active="request()->routeIs('mastersetup')">
                        {{ __('Master Setup') }}
                    </x-nav-link>
                </div>


                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('transaction')" :active="request()->routeIs('transaction')">
                        {{ __('Transactions') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>



                {{-- <input type="checkbox" id="check">
                    <label for="check" >
                        <i class="fas fa-bars"  id="btn">  </i>
                        <i class="fas fa-times" id="cancel">  </i>
                    </label>
                    <div class="sidebar">
                        <header> Main Menu</header>
                        <ul>
                            <li> <a href="{{ url('layouts/navigation/1')}} "><i class="fas fa-qrcode"></i> Master Setup </a>  </li>
                            <li> <a href="{{ url('layouts/navigation/2')}} "><i class="fas fa-link"></i>Transaction </a>  </li>
                            <li> <a href="{{ url('layouts/navigation/3')}} "><i class="fas fa-stream"></i> Reports </a>  </li>
                            <li> <a href="#"><i class="fas fa-calendar-week"></i>Utility</a>   </li>
                            <li> <a href="#"><i class="fas fa-question-circle"></i>Permission Setup</a>   </li>
                            <li> <a href="#"><i class="fas fa-sliders-h"></i>Locking </a>  </li>
                            <li> <a href="#"><i class="fas fa-envelope"></i>About </a>  </li>
                        </ul>

                    </div> --}}









                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>


                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                        {{ __('Suppliers') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        {{ __('Customers') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('locations.index')" :active="request()->routeIs('locations.*')">
                        {{ __('Locations') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('subheads.index')" :active="request()->routeIs('subheads.*')">
                        {{ __('CharOfAccount') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('itemcategories.index')" :active="request()->routeIs('itemcategories.*')">
                        {{ __('Items Category') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('items.index')" :active="request()->routeIs('items.*')">
                        {{ __('Items') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('itemsize.index')" :active="request()->routeIs('itemsize.*')">
                        {{ __('Items Size') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('grouprelations.index')" :active="request()->routeIs('grouprelations.*')">
                        {{ __('Group Relation') }}
                    </x-nav-link>
                </div> --}}

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
