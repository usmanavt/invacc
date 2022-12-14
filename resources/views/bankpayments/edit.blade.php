<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Bank Payments
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                 {{-- Create Form --}}
                 <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('bankpayments.update',$bt) }}" method="post" class="flex flex-col">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $bt->id }}">
                                <label for="">Bank</label>
                                <select name="bank_id" required>
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" @if($bank->id === $bt->bank_id) selected @endif>{{ $bank->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Head --}}
                                <label for="">Head</label>
                                <select name="head_id" id="head_id" required onchange="populateSelect()">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($heads as $head)
                                        <option value="{{ $head->id }}" @if($head->id === $bt->head_id) selected @endif>{{ $head->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Subhead --}}
                                <label for="">Subead</label>
                                <select name="subhead_id" id="subhead_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    {{-- @foreach ($heads as $head)
                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- Supplier --}}
                                <label for="">Supplier</label>
                                <select name="supplier_id" id="supplier_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @if($supplier->id === $bt->supplier_id) selected @endif>{{ $supplier->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Customer --}}
                                <label for="">Customer</label>
                                <select name="customer_id" id="customer_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if($customer->id === $bt->customer_id) selected @endif>{{ $customer->title }}</option>
                                    @endforeach
                                </select>

                                <x-input-numeric title="Conversion Rate" name="conversion_rate" id="conversion_rate" value="1" min="1" step="0.01" req required class="" value="{{ $bt->conversion_rate }}"/>
                                <x-input-numeric title="Amount $" name="amount_fc" id="amount_fc" min="1" req required class="" value="{{ $bt->amount_fc }}"/>
                                <x-input-numeric title="Amount Rs" name="amount_pkr" id="amount_pkr"  disabled required class="" value="{{ $bt->amount_pkr }}"/>
                                <x-input-text title="Cheque #" name="cheque_no" req required class="" value="{{ $bt->cheque_no }}"/>
                                <x-input-date title="Cheque Date" name="cheque_date" value="{{ $bt->cheque_date->format('Y-m-d') }}" req required/>


                                <div class="flex flex-col">
                                    <label for="">
                                        Description <span class="text-red-500 font-semibold">(*)</span>
                                    </label>
                                    <textarea name="description" id="description" cols="30" rows="3" maxlength="255" required class="rounded">{{ $bt->description }}</textarea>
                                </div>

                                <div class="mt-2">
                                    <x-button type="button" onclick="calculate()">
                                        <i class="fa fa-save fa-fw"></i>
                                            Calculate
                                    </x-button>
                                    <x-button disabled id="submitButton">
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@push('scripts')
<script>
    let subheads = @json($subheads);
    let supplier_id = @json($bt->supplier_id);
    let customer_id = @json($bt->customer_id);
    let subhead_id = @json($bt->subhead_id);

    console.info(supplier_id,customer_id,subhead_id)


    const submitButton = document.getElementById('submitButton')
    const conversion_rate = document.getElementById('conversion_rate')
    const amount_fc = document.getElementById('amount_fc')
    const amount_pkr = document.getElementById('amount_pkr')
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const supplier = document.getElementById('supplier_id')
    const customer = document.getElementById('customer_id')

    document.addEventListener('DOMContentLoaded',()=>{
       populateSelect()
    })

    const populateSelect = ()=>{
        const val = head.value
        subhead.options.length = 0 // Reset List
        let list = subheads.filter( l => l.head_id === parseInt(val))
        //  Setup subhead dropdown
        addSelectElement(subhead,'','--Select')
        list.forEach(e => {
            addSelectElement(subhead,e.id,e.title)
        });
        subhead.setAttribute('required','')
        subhead.removeAttribute('disabled','')
        console.info(list)

        if(val === "32"){
            supplier.setAttribute('required','')
            supplier.removeAttribute('disabled','')
            customer.setAttribute('disabled','')
            customer.removeAttribute('required','')
            subhead.setAttribute('disabled','')
            subhead.removeAttribute('required','')
            if(supplier_id > 0){ supplier.value = supplier_id}
        }
        else if(val === "33"){
            customer.setAttribute('required','')
            customer.removeAttribute('disabled','')
            supplier.setAttribute('disabled','')
            supplier.removeAttribute('required','')
            subhead.setAttribute('disabled','')
            subhead.removeAttribute('required','')
            if(customer_id > 0){ customer.value = customer_id}
        }else {
            customer.setAttribute('disabled','')
            customer.removeAttribute('required','')
            supplier.setAttribute('disabled','')
            supplier.removeAttribute('required','')
            subhead.removeAttribute('disabled','')
            subhead.setAttribute('required','')
            if(subhead_id > 0){ subhead.value = subhead_id}
        }
    }

    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

    const calculate = () =>{
        amount_pkr.value = (parseFloat(conversion_rate.value) * parseFloat(amount_fc.value)).toFixed(2)
        submitButton.disabled = false
    }
</script>
@endpush

</x-app-layout>

