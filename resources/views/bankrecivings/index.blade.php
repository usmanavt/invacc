<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CHEQUE RECEIVING/ISSUING
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                 {{-- Create Form --}}
                 <div class="px-6 py-2" >
                    <div class="flex gap-8">

                        {{-- Form Data --}}
                        <div class="flex flex-col justify-start items-center">
                            <form action="{{ route('bankrecivings.store') }}" method="post" class="flex flex-col" id="createForm">
                                @csrf
                                <x-input-date title="Document Date" name="documentdate" req required/>
                                <label for="">Bank</label>
                                <select name="bank_id" required autocomplete="on">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Head --}}
                                <label for="">Head</label>
                                <select name="head_id" id="head_id" required autocomplete="on">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($heads as $head)
                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Subhead --}}
                                <label for="">Subead</label>
                                <select name="subhead_id" id="subhead_id" disabled class="disabled:opacity-50" autocomplete="on">
                                    <option disabled selected value="">--Select</option>
                                    {{-- @foreach ($heads as $head)
                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                    @endforeach --}}
                                </select>
                                {{-- Supplier --}}
                                <label for="">Supplier</label>
                                <select name="supplier_id" id="supplier_id" disabled class="disabled:opacity-50" autocomplete="on">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->title }}</option>
                                    @endforeach
                                </select>
                                {{-- Customer --}}
                                <label for="">Customer</label>
                                <select name="customer_id" id="customer_id" disabled class="disabled:opacity-50" autocomplete="on">
                                    <option disabled selected value="">--Select</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->title }}</option>
                                    @endforeach
                                </select>

                                {{-- <x-input-numeric title="Conversion Rate" name="conversion_rate" id="conversion_rate" value="1" min="1" step="0.01" required  onblur="convamounttodlr()"/> --}}
                                <x-input-numeric title="Receiving" name="received" id="received" min="1" required  onblur="convamounttodlr()"/>
                                <x-input-numeric title="Payment" name="payment" id="payment"   required class=""/>
                                <x-input-text title="Cheque #" name="cheque_no" req required class=""/>
                                <x-input-date title="Cheque Date" name="cheque_date" req required/>


                                <div class="flex flex-col">
                                    <label for="">
                                        Description <span class="text-red-500 font-semibold">(*)</span>
                                    </label>
                                    <textarea name="description" id="description" cols="30" rows="3" maxlength="255" class="rounded"></textarea>
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
                                </div>
                            </form>

                        </div>


                        {{-- Listing --}}
                        <div class="p-2 pb-2 border border-slate-300 w-full">
                            {{-- tabulator component --}}
                            <x-tabulator />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@push('scripts')
<script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    let subheads = @json($subheads);
    const submitButton = document.getElementById('submitButton')
    const conversion_rate = document.getElementById('conversion_rate')
    const received = document.getElementById('received')
    const payment = document.getElementById('payment')
    const head = document.getElementById('head_id')
    const subhead = document.getElementById('subhead_id')
    const supplier = document.getElementById('supplier_id')
    const customer = document.getElementById('customer_id')

    head.addEventListener('change',()=>{
        const val = head.value
        subhead.options.length = 0 // Reset List
        let list = subheads.filter( l => l.head_id === parseInt(val))
        // if(list.length <=0) { alert('Cannot continue,No Sub Head Defined!') ; return}
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
        }
        else if(val === "33"){
            customer.setAttribute('required','')
            customer.removeAttribute('disabled','')
            supplier.setAttribute('disabled','')
            supplier.removeAttribute('required','')
            subhead.setAttribute('disabled','')
            subhead.removeAttribute('required','')
        }else {
            customer.setAttribute('disabled','')
            customer.removeAttribute('required','')
            supplier.setAttribute('disabled','')
            supplier.removeAttribute('required','')
        }
    })

    const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

    const calculate = () =>{
        payment.value = (parseFloat(conversion_rate.value) * parseFloat(received.value)).toFixed(2)
        submitButton.disabled = false
    }
</script>
@endpush

@push('scripts')
<script>
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    var lockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-red-600'></i>";};
    var unlockIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-lock text-green-600'></i>";};

    const getMaster = @json(route('bankrecivings.master'));
    let table;
    let searchValue = "";

    //  Table Filter
    function dataFilter(element)
    {
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue});
    }
    // The Table for Items Modal
    table = new Tabulator("#tableData", {
        autoResize:true,
        responsiveLayout:"collapse",
        layout:"fitData",
        index:"id",
        placeholder:"No Data Available",
        pagination:true,
        paginationMode:"remote",
        sortMode:"remote",
        filterMode:"remote",
        paginationSize:10,
        paginationSizeSelector:[10,25,50,100],
        ajaxParams: function(){
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data

            {
                title:'CHEQUE TRANSACTION', headerHozAlign:"center",
                    columns:[

            {title:"Id", field:"id" , responsive:0,visible:false},
            {title:"Bank", field:"bank" , visible:true , responsive:0},
            {title:"Head", field:"mhead" , visible:true , responsive:0},
            {title:"Subhead", field:"supname" , visible:true , responsive:0},
            {title:"Entry Date", field:"documentdate" , visible:true , responsive:0},
            // {title:"Customer", field:"customer.title" , visible:true , responsive:0},
            // {title:"Tran", field:"transaction_type" ,  responsive:0,cssClass:'text-green-500 font-semibold'},
            // {title:"Conv. Rate", field:"conversion_rate",hozAlign:"right" ,  responsive:0,formatter:"money",formatterParams:{thousand:",",precision:2}},
            {title:"Receiving", field:"received",hozAlign:"right" ,  responsive:0,formatter:"money",formatterParams:{thousand:",",precision:2}},
            {title:"Payment", field:"payment",hozAlign:"right" ,  responsive:0,formatter:"money",formatterParams:{thousand:",",precision:0}},
            {title:"Cheque Date", field:"cheque_date" ,  responsive:0},
            {title:"Cheque #", field:"cheque_no" ,  responsive:0},
            {title:"Description", field:"description" ,  responsive:0}]},

            {
                title:'DURATION', headerHozAlign:"center",
                    columns:[

            {title:"Days", field:"days" ,  responsive:0}]},

            {
                title:'CLEARANCE STATUS', headerHozAlign:"center",
                    columns:[

            // {title:"Status", field:"clrstatus" ,  responsive:0},
            {title:"Status", field:"clrstatus", hozAlign:"center", formatter:"tickCross", headerSort:false},
            {title:"Date", field:"clrdate" ,  responsive:0},
            {title:"", field:"clrid" ,  responsive:0,visible:false},
            {title:"Ref.", field:"ref" ,  responsive:0},


        ]},

            // {title:"Status", field:"status" ,  responsive:0,
            //     formatter:function(cell){
            //         if(cell.getData().status === 1)
            //         {
            //             table.hideColumn('unlock')
            //             table.showColumn('lock')
            //         }else{
            //             table.showColumn('unlock')
            //             table.hideColumn('lock')
            //         }
            //     return cell.getData().status === 1 ? 'Active':'Locked';
            // }},
            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().id + "/edit" ,"_self");
            }},
            // {title:"Unlock",field:'unlock' , formatter:unlockIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e,cell){
            //         if(confirm('Do you really want to Unlock this Bank?'))
            //         {
            //             window.open(window.location + "/" + cell.getData().id  ,"_self");
            //         }
            //     }
            // },
            // {title:"Lock",field:'lock' , formatter:lockIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e,cell){
            //         if(confirm('Do you really want to Lock this Bank?'))
            //         {
            //             window.open(window.location + "/" + cell.getData().id  ,"_self");
            //         }
            //     }
            // }

        ],
        // Extra Pagination Data for End Users
        ajaxResponse:function(getDataUrl, params, response){
            remaining = response.total;
            let doc = document.getElementById("example-table-info");
            doc.classList.add('font-weight-bold');
            doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
            return response;
        },
    })

    function convamounttodlr()
        {
            payment.value = (parseFloat(conversion_rate.value) * parseFloat(received.value)).toFixed(2)
        }

</script>
@endpush

</x-app-layout>

