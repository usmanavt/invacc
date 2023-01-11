<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">

                    <div class="flex flex-col md:flex-row flex-wrap items-center gap-2 justify-center">

                        <a class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg"  href="{{ route('contracts.index') }}" >
                            <i class="fa-solid fa-truck-field fa-2xl"></i> Contracts
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="{{ route('cis.index') }}" >
                            <i class="fa-solid fa-person-military-pointing fa-2xl"></i> Comm Invoice
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{ route('recivings.index') }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Goods Recivings
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{
                            route('clearances.index')
                        }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Duty Clearance
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{
                            route('bankpayments.index')
                        }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Bank Payments
                        </a>
                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{
                            route('bankrecivings.index')
                        }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Bank Recivings
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "{{
                            route('cashpayments.index')
                        }}" >
                            <i class="fa-solid fa-shop-lock fa-2xl"></i> Cash Payments
                        </a>
{{--
                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-kitchen-set fa-2xl"></i> Purchase Return
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href="#">
                            <i class="fa-solid fa-arrow-up-from-ground-water fa-2xl"></i> Delivery Challan
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrow-up-from-bracket fa-2xl"></i> Sales Invoice
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-xmarks-lines fa-2xl"></i> Sale Return
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Cash Payment
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Bank Payment
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Cash Receive
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Bank Receive
                        </a>

                        <a  class="basis-0 w-full md:basis-1/4 bg-blue-500 hover:bg-blue-700 text-white px-2 py-4 rounded-lg shadow-lg" href= "" >
                            <i class="fa-solid fa-arrows-to-circle fa-2xl"></i> Journal Voucher
                        </a> --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
