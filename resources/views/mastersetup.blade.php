<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Setup') }}
        </h2>
    </x-slot>

    {{-- <div class="py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <div class="flex flex-col flex-wrap md:flex-row items-center gap-2 justify-center">

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('categories.index') }}">
                            <i class="fa-solid fa-arrow-up-from-ground-water fa-2xl"></i> Categories
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('skus.index') }}">
                            <i class="fa-solid fa-arrow-up-from-ground-water fa-2xl"></i> Skus
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('dimensions.index') }}">
                            <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Dimensions
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('brands.index') }}">
                            <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Brands
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('sources.index') }}">
                            <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Sources
                        </a>

                        <a class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg"  href="{{ route('suppliers.index') }}" >
                            <i class="fa-solid fa-truck-field fa-2xl"></i> Suppliers
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{ route('customers.index') }}" >
                            <i class="fa-solid fa-person-military-pointing fa-2xl"></i> Customers
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('locations.index') }}">
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Location
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('heads.index') }}">
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Account Heads
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('subheads.index') }}">
                            <i class="fa-solid fa-kitchen-set fa-2xl"></i> ChartOfAccount
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('hscodes.index') }}">
                            <i class="fa-solid fa-kitchen-set fa-2xl"></i> HS Codes
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('materials.index') }}">
                            <i class="fa-solid fa-arrow-up-from-bracket fa-2xl"></i> Materials
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg"
                        href= "{{ route('banks.index') }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Banks
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
