<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Setup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                        {{ __('Suppliers') }}
                    </x-nav-link> --}}



                    {{-- "{{ route('mastersetup') }}" --}}

                    <div class="flex flex-col md:flex-row items-center justify-start">
                        <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <a class=""  href="{{ route('suppliers.index') }}" >
                                <i class="fa-solid fa-truck-field fa-2xl"></i> Suppliers
                            </a>
                        </div>

                        <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <a  class="" href= "{{ route('customers.index') }}" >
                                <i class="fa-solid fa-person-military-pointing fa-2xl"></i> Customers
                            </a>
                        </div>

                        <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                            <a  class="" href="{{ route('locations.index') }}">
                                <i class="fa-solid fa-shop-lock fa-2xl"></i> Location
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row justify-evenly items-center">
                            <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                                <a  class="" href="{{ route('subheads.index') }}">
                                    <i class="fa-solid fa-kitchen-set fa-2xl"></i> ChartOfAccount
                                </a>
                            </div>
                            <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                                <a  class="" href="{{ route('itemcategories.index') }}">
                                    <i class="fa-solid fa-arrow-up-from-ground-water fa-2xl"></i> Item Category
                                </a>
                            </div>
                            <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                                <a  class="" href="{{ route('items.index') }}">
                                    <i class="fa-solid fa-arrow-up-from-bracket fa-2xl"></i> Items
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-evenly items-center">
                            <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                                <a  class="" href="{{ route('itemsize.index') }}">
                                    <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Items Size
                                </a>
                            </div>

                            <div class="flex m-4 basis-0 md:basis-1/3 bg-blue-500 text-white p-6 rounded-lg shadow-lg">
                                <a  class="" href="{{ route('grouprelations.index') }}">
                                    <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Group Relation
                                </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
