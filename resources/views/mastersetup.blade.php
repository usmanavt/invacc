<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Setup') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <div class="flex flex-col flex-wrap md:flex-row items-center gap-2 justify-center">
                        
                        <a class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg"  href="{{ route('suppliers.index') }}" >
                            <i class="fa-solid fa-truck-field fa-2xl"></i> Suppliers
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{ route('customers.index') }}" >
                            <i class="fa-solid fa-person-military-pointing fa-2xl"></i> Customers
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('locations.index') }}">
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Location
                        </a>
                        
                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('subheads.index') }}">
                            <i class="fa-solid fa-kitchen-set fa-2xl"></i> ChartOfAccount
                        </a>
                                
                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('categories.index') }}">
                            <i class="fa-solid fa-arrow-up-from-ground-water fa-2xl"></i> Category
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('items.index') }}">
                            <i class="fa-solid fa-arrow-up-from-bracket fa-2xl"></i> Items
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('itemsize.index') }}">
                            <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Items Size
                        </a>

                        <a  class="basis-0 w-full md:basis-1/3 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('grouprelations.index') }}">
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Group Relation
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
