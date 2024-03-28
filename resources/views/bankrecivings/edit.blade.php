<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Bank Recivings
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                 {{-- Create Form --}}
                 <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        {{-- Form Data --}}




                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('bankrecivings.update',$bt) }}" method="post" class="flex flex-col">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $bt->id }}">
                                {{-- <label for="">Bank</label>
                                <select autocomplete="on" name="bank_id" required>
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" @if($bank->id === $bt->bank_id) selected @endif>{{ $bank->title }}</option>
                                    @endforeach
                                </select> --}}
                                {{-- Head --}}
                                <x-input-date title="Document Date" name="documentdate" value="{{ $bt->documentdate }}"/>
                                <x-input-text title="Bank Naration" name="banknaration" value="{{ $bt->banknaration }}"/>
                                <label for="">Head</label>
                                <select autocomplete="on" name="head_id" id="head_id" required onchange="populateSelect()">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($heads as $head)
                                        <option value="{{ $head->id }}" @if($head->id === $bt->head_id) selected @endif>{{ $head->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Subhead --}}
                                <label for="">Subead</label>
                                <select autocomplete="on" name="subhead_id" id="subhead_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    {{-- @foreach ($heads as $head)
                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- Supplier --}}
                                <label for="">Supplier</label>
                                <select autocomplete="on" name="supplier_id" id="supplier_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @if($supplier->id === $bt->supplier_id) selected @endif>{{ $supplier->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Customer --}}
                                <label for="">Customer</label>
                                <select autocomplete="on" name="customer_id" id="customer_id" disabled class="disabled:opacity-50">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @if($customer->id === $bt->customer_id) selected @endif>{{ $customer->title }}</option>
                                    @endforeach
                                </select>

                                {{-- <x-input-numeric title="Conversion Rate" name="conversion_rate" id="conversion_rate" value="1" min="1" step="0.01" required  onblur="convamounttodlr()" value="{{ $bt->conversion_rate }}"/> --}}
                                <x-input-numeric title="Receiving" name="received" id="received"    value="{{ $bt->received }}"/>
                                <x-input-numeric title="Payment" name="payment" id="payment"    class="" value="{{ $bt->payment }}"/>
                                <x-input-text title="Cheque #" name="cheque_no" req required class="" value="{{ $bt->cheque_no }}"/>
                                <x-input-date title="Cheque Date" name="cheque_date" value="{{ $bt->cheque_date }}" req required/>


                            <div>
                            <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" {{ $bt->ref === 'CHEQUE_RETURN' ? 'checked' : '' }}  type="checkbox" name="imppurf2" id="imppurf2"   onclick="imppur(this)" >
                            <label for="">
                                <span style="color: brown;font-weight: bold"> Cheque Return/Cancel </span> <span class="text-red-500 font-semibold font-size:1rem "></span>
                                </label>

                            </div>

                            <x-input-text title="" name="p1" id="p1" value="0" hidden />
                            <x-input-text title="" name="sts" id="sts" value="{{ $bt->clrstatus }}" hidden />
                            <x-input-text title="" name="chqref" id="chqref" value="{{ $bt->ref }}" hidden />

                                <div class="flex flex-col">
                                    <label for="">
                                        Description <span class="text-red-500 font-semibold">(*)</span>
                                    </label>
                                    <textarea name="description" id="description" cols="30" rows="3" maxlength="255"  class="rounded">{{ $bt->description }}</textarea>
                                </div>

                                <div class="mt-2">
                                    {{-- <x-button type="button" onclick="calculate()">
                                        <i class="fa fa-save fa-fw"></i>
                                            Calculate
                                    </x-button> --}}

                                    <x-button  id="submitButton">
                                        <i class="fa fa-save fa-fw"></i>
                                            Submit
                                    </x-button>
                                    <x-input-text title="Password For Edition" name="edtpw" id="edtpw" type="password"     />
                                    <x-input-text title="" name="dbpwrd2" id="dbpwrd2"  class="col-span-2" hidden  value="{{$passwrd}}" />

                                </div>
                                <div class="mt-2">
                                    {{-- <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none"  type="checkbox"  name="del" id="del" disabled   onclick="delmode(this)" >
                                    <label for="">
                                        <span style="color: brown;font-weight: bold"> Delete Mode </span> <span class="text-red-500 font-semibold font-size:1rem "></span>
                                        </label> --}}

                                {{-- <x-input-text title="Password For Deletion" name="delpwrd" id="delpwrd" type="password" class="col-span-2"    /> --}}
                                {{-- <x-input-text title="" name="delpwrd2" id="delpwrd2"  class="col-span-2" hidden   value="{{$passwrddel}}" /> --}}
                                <x-input-text title="" name="p2" id="p2" value="0" hidden  />

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

    // document.addEventListener('DOMContentLoaded',()=>{
    //     document.getElementById("submitButton").disabled = true;
    //  })
    let subheads = @json($subheads);
    let supplier_id = @json($bt->supplier_id);
    let customer_id = @json($bt->customer_id);
    let subhead_id = @json($bt->subhead_id);

    // console.info(supplier_id,customer_id,subhead_id)


    const submitButton = document.getElementById('submitButton')
    const conversion_rate = document.getElementById('conversion_rate')
    const received = document.getElementById('received')
    const payment = document.getElementById('payment')
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const supplier = document.getElementById('supplier_id')
    const customer = document.getElementById('customer_id')

    document.addEventListener('DOMContentLoaded',()=>{
        document.getElementById("submitButton").disabled = true;
        populateSelect()

    })
// xyz
    const populateSelect = ()=>{
        const val = head.value
        subhead.options.length = 0 // Reset List
        let list = subheads.filter( l => l.head_id === Number(val))
        //  Setup subhead dropdown
        addSelectElement(subhead,'','--Select')
        list.forEach(e => {
            addSelectElement(subhead,e.id,e.title)
        });
        subhead.setAttribute('required','')
        subhead.removeAttribute('disabled','')
        // console.info(list)

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

    // const calculate = () =>{
    //     payment.value = (parseFloat(conversion_rate.value) * parseFloat(received.value)).toFixed(2)
    //     submitButton.disabled = false
    // }

    // function convamounttodlr()
    //     {
    //         amount_pkr.value = (parseFloat(conversion_rate.value) * parseFloat(received.value)).toFixed(2)
    //     }

    edtpw.onblur=function(){
    if(edtpw.value == dbpwrd2.value )
     {document.getElementById("submitButton").disabled = false;

    }
    else
    {document.getElementById("submitButton").disabled = true;}

    }


    // delpwrd.onblur=function(){
    // if(delpwrd.value == delpwrd2.value )
    //  {
    //     // document.getElementById("submitButton").disabled = false;
    //     document.getElementById('del').disabled=false;

    // }
    // else
    // {
    //     // document.getElementById("submitButton").disabled = true;
    //     document.getElementById('del').disabled=true;

    // }


    // }






    function imppur(imppurf2) {
        var p1 = document.getElementById("p1");
        if(imppurf2.checked==true)
        {
            p1.value=1;
        }
        else
        {
            p1.value=0;
        }

    }

    function delmode(del) {
        var p2 = document.getElementById("p2");
        if(del.checked==true)
        {
            document.getElementById("submitButton").disabled = false;
            p2.value=1;
        }
        else
        {
            document.getElementById("submitButton").disabled = true;
            p2.value=0;
        }

    }




</script>
@endpush

</x-app-layout>

