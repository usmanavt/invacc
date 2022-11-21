<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Commercial Invoice | {{ $i->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-date title="Inv. Date" name="invoicedate" value="{{ $i->invoice_date->format('Y-m-d') }}" disabled class="col-span-2"/>

                                <x-input-text title="Invoice #" name="invoiceno" value="{{ $i->invoiceno }}" disabled class=""/>
                                <x-input-text title="Challan #" name="challanno" value="{{ $i->challanno }}" disabled class=""/>

                                <x-input-numeric title="Conv. Rate" name="conversionrate" value="{{ $i->conversionrate }}" disabled class=""/>
                                <x-input-numeric title="Insurance" name="insurance"  value="{{ $i->insurance }}" disabled class=""/>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-date title="Mac. Date" name="machine_date" value="{{ $i->machine_date->format('Y-m-d') }}" disabled class="col-span-2"/>
                                <x-input-text title="Machine #" name="machineno" value="{{ $i->machineno }}" disabled class="col-span-2"/>

                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges" value="{{ $i->bankcharges }}"  disabled />
                                <x-input-numeric title="Cust Coll" name="collofcustom" value="{{ $i->collofcustom }}"  disabled />
                                <x-input-numeric title="Ex Tax of" name="exataxoffie" value="{{ $i->exataxoffie }}"  disabled />
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" value="{{ $i->lngnshipdochrgs }}"  disabled />
                                <x-input-numeric title="Lcl Cartage" name="localcartage" value="{{ $i->localcartage }}"  disabled />
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" value="{{ $i->miscexplunchetc }}"  disabled />
                                <x-input-numeric title="Custom Sepoy" name="customsepoy" value="{{ $i->customsepoy }}"  disabled />
                                <x-input-numeric title="Weigh Bridge" name="weighbridge" value="{{ $i->weighbridge }}"  disabled />
                                <x-input-numeric title="Misc Exp" name="miscexpenses" value="{{ $i->miscexpenses }}"  disabled />
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" value="{{ $i->agencychrgs }}"  disabled />
                                <x-input-numeric title="Other Chgs" name="otherchrgs" value="{{ $i->otherchrgs }}"  disabled />
                                <x-input-numeric title="Total" name="banktotal" value="{{ $i->otherchrgs }}" disabled />

                            </div>
                        </fieldset>

                        <x-tabulator-dynamic />

                    </div>
                </div>
            </div>
        </div>
    </div>


@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Contracts" />

@push('scripts')
    <script>
        const getDetails = @json("$i->commericalInvoiceDetails");
    </script>
@endpush

@push('scripts')
    <script>
        //  Dynamic Table [User data]
        dynamicTable = new Tabulator("#dynamicTable", {
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            data:getDetails,
            // reactiveData:true,
            columns:[
                // {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                //     cellClick:function(e, cell){
                //         cell.getRow().delete();
                //     }
                // },
                {title:"Id",           field:"material_id", visible:false},
                {title:"Material",     field:"material.title"},
                {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},
                {title:"user_id",      field:"user_id",visible:false},
                {title:"category_id",  field:"category_id",visible:false},
                {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},
                {title:"source_id",    field:"source_id",visible:false},
                {title:"brand_id",     field:"brand_id",visible:false},
                {
                    title:'Quantity', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs",
                            headerVertical:true,
                            formatter:"money",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Wt(mt)",
                            field:"gdswt",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Wt(pcs/kg)",
                            field:"inkg",
                            responsive:0,
                            headerVertical:true,
                        },
                        {   title:"Lng(pcs/feet)",
                            field:"length",
                            headerVertical:true,
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                    ]
                },
                {
                    title:'Price',
                    columns:[
                        {   title:"$/Ton",
                            field:"gdsprice",
                            formatter:"money" ,
                            responsive:0,
                            headerVertical:true,
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2}
                        },
                    ]
                },
                {
                    title:'Amount', headerHozAlign:"center",
                    columns:[
                        {   title:"In $",
                            field:"amtindollar",
                            formatter:"money",
                            bottomCalc:"sum",
                            bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"In Pkr",
                            field:"amtinpkr",
                            formatter:"money",
                            bottomCalc:"sum",
                            bottomCalcFormatter:"money",
                        },
                        {   title:"Item Ratio(%)",
                            field:"itmratio",
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                    ]
                },
                {
                    title:"Insur/Item",
                    field:"insuranceperitem",
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"Amt W/Insur (PKR)",
                    field:"amountwithoutinsurance",
                    headerVertical:true,

                    formatter:"money",
                },
                {
                    title:"1% Duty (PKR)",
                    field:"onepercentdutypkr",
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"Price value (CS)",
                    headerVertical:true,
                    field:"pricevaluecostsheet",
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },
                {
                    title:'Duties Rate', headerHozAlign:"center",
                    columns:[
                        {title:"Code",              field:"material.hscodes.hscode",
                        headerVertical:true,       visible:false},
                        {title:"CD",                field:"material.hscodes.cd",
                        headerVertical:true,        visible:false},
                        {title:"ST",                field:"material.hscodes.st",
                        headerVertical:true,          visible:false},
                        {title:"RD",                field:"material.hscodes.rd",
                        headerVertical:true,        visible:false},
                        {title:"ACD",               field:"material.hscodes.acd",
                        headerVertical:true,          visible:false},
                        {title:"AST",               field:"material.hscodes.ast",
                        headerVertical:true,        visible:false},
                        {title:"IT",                field:"material.hscodes.it",
                        headerVertical:true,        visible:false},
                        {title:"WSC",               field:"material.hscodes.wsc",
                        headerVertical:true,         visible:false},
                    ]
                },
                {
                    title:'Duties Amount (PKR)', headerHozAlign:"center",
                    columns:[
                        {title:"CD",                field:"cda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},             responsive:0},
                        {title:"ST",                field:"sta", formatter:"money",
                    formatterParams:{thousand:",",precision:2},             responsive:0},
                        {title:"RD",                field:"rda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},             responsive:0},
                        {title:"ACD",               field:"acda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},            responsive:0},
                        {title:"AST",               field:"asta",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},           responsive:0},
                        {title:"IT",                field:"ita",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},            responsive:0},
                        {title:"WSC",               field:"wsca",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},           responsive:0},
                        {title:"Total",             field:"total",   formatter:"money",
                    formatterParams:{thousand:",",precision:2},          responsive:0},
                    ]
                },
                {
                    title:"Total LC Cost W/InvsExp",
                    headerVertical:true,
                    field:"totallccostwexp",
                    responsive:0,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },
                {
                    title:'Cost Rate/Unit', headerHozAlign:"center",
                    columns:[
                        {title:"Per Pc",    field:"perpc",          responsive:0 ,formatter:"money",
                    formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Kg",    field:"perkg",          responsive:0 , formatter:"money",
                    formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Feet",  field:"perft",        responsive:0 ,formatter:"money",
                    formatterParams:{thousand:",",precision:2}, },

                    ]
                },
            ],
        })
    </script>
@endpush

</x-app-layout>
