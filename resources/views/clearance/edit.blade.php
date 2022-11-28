<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Duty Clerance | {{ $clearance->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid">

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Entries</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-date title="Inv. Date" name="invoicedate" value="{{ $clearance->invoice_date->format('Y-m-d') }}" disabled />
                                <x-input-text title="Invoice #" name="invoiceno" value="{{ $clearance->invoiceno }}" disabled class=""/>
                                <x-input-numeric title="Conv. Rate" name="conversionrate" value="{{ $clearance->conversionrate }}" disabled class=""/>
                                <x-input-numeric title="Insurance" name="insurance"  value="{{ $clearance->insurance }}" disabled class=""/>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-date title="Mac. Date" name="machine_date" value="{{ $clearance->machine_date->format('Y-m-d') }}" disabled />
                                <x-input-text title="Machine #" name="machineno" value="{{ $clearance->machineno }}" disabled />
                                <x-input-date title="GD Date" name="gd_date" req required />
                                    <x-input-text title="GD #" name="gdno" value="" req required />
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges" value="{{ $clearance->bankcharges }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Cust Coll" name="collofcustom" value="{{ $clearance->collofcustom }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ex Tax of" name="exataxoffie" value="{{ $clearance->exataxoffie }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" value="{{ $clearance->lngnshipdochrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Lcl Cartage" name="localcartage" value="{{ $clearance->localcartage }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" value="{{ $clearance->miscexplunchetc }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Custom Sepoy" name="customsepoy" value="{{ $clearance->customsepoy }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Weigh Bridge" name="weighbridge" value="{{ $clearance->weighbridge }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp" name="miscexpenses" value="{{ $clearance->miscexpenses }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" value="{{ $clearance->agencychrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Other Chgs" name="otherchrgs" value="{{ $clearance->otherchrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="banktotal" value="{{ $clearance->otherchrgs }}" disabled />

                            </div>
                        </fieldset>

                        {{-- Contract Details --}}
                        <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" onclick="calculate();calculate();calculate();">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>
                        </div>
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" onclick="validateForm()">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </x-button>
                        </div>

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
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        let rcvIsMoreThenPending = [] // if reciving is more then pending pcs
        const getDetails = @json(route('clearances.details'));
        const cid = @json("$clearance->id");
        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []

        // Bank Charges
        let bankcharges= document.getElementById("bankcharges")
        let collofcustom= document.getElementById("collofcustom")
        let exataxoffie= document.getElementById("exataxoffie")
        let lngnshipdochrgs= document.getElementById("lngnshipdochrgs")
        let localcartage= document.getElementById("localcartage")
        let miscexplunchetc= document.getElementById("miscexplunchetc")
        let customsepoy= document.getElementById("customsepoy")
        let weighbridge= document.getElementById("weighbridge")
        let miscexpenses= document.getElementById("miscexpenses")
        let agencychrgs= document.getElementById("agencychrgs")
        let otherchrgs= document.getElementById("otherchrgs")
        let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        var insurance = document.getElementById("insurance");
        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            // calculateButton.disabled = true
            submitButton.disabled = true
        })
        // Calculate Bank Charges [ onblur ]
        function calculateBankCharges()
        {
            var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) + parseFloat(otherchrgs.value)
            // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
            banktotal.value = t.toFixed(2)
            // console.log(banktotal.value);
        }
    </script>
@endpush

@push('scripts')
    <script>
        var calculate = function()
        {
            calculateBankCharges()
            rcvIsMoreThenPending = []
            // alert(dynamicTable.getData())
            const data = dynamicTable.getData()
            //  Get Ratio after price/length/pcs update
            var amtinpkrtotal = 0
            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
            });
            data.forEach(e => {
                //  make sure reciving is not more then pending
                if(e.pcs_rcv > e.pcs_pending || e.pcs_rcv === undefined)
                {
                    showSnackbar("Rcv Pcs is Required & cannot be more then PCS","error");
                    rcvIsMoreThenPending.push(true)
                    return;
                }
                var pcs = e.pcs
                var gdswt = e.gdswt
                var inkg = ((e.gdswt / e.pcs ) * 1000).toFixed(3)
                var length = e.length
                var gdsprice = e.gdsprice

                var amtindollar = gdsprice * gdswt
                var amtinpkr = conversionrate.value * amtindollar
                var itmratio = amtinpkr / amtinpkrtotal * 100
                var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var amountwithoutinsurance = ( amtindollar + insuranceperitem ) * parseFloat(conversionrate.value)
                var onepercentdutypkr = amountwithoutinsurance * 0.01
                var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)

                var cda = e.cd * pricevaluecostsheet / 100
                var rda = e.rd * pricevaluecostsheet / 100
                var acda = e.acd * pricevaluecostsheet / 100
                var sta = (pricevaluecostsheet + cda + rda + acda) * e.st / 100
                var asta = (pricevaluecostsheet + cda + rda + acda) * e.ast / 100
                var ita =(pricevaluecostsheet + cda + sta + rda + acda + asta) * e.it / 100
                var wsca = (pricevaluecostsheet * e.wse) /100
                var total = cda + rda + sta + acda + asta + ita + wsca
                var perft = (e.perpc / e.length).toFixed(2)
                var totallccostwexp = total + pricevaluecostsheet + (banktotal.value * itmratio / 100)
                var perpc = (e.totallccostwexp / e.pcs).toFixed(2)
                var perkg = (e.perpc / inkg).toFixed(2)

                e.pcs = pcs
                e.gdswt = gdswt
                e.inkg = inkg
                e.length = length
                e.gdsprice = gdsprice

                e.amtindollar = amtindollar
                e.amtinpkr = amtinpkr
                e.itmratio = itmratio
                e.insuranceperitem = insuranceperitem
                e.amountwithoutinsurance = amountwithoutinsurance
                e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
                e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)

                e.cda = (cda).toFixed(2)
                e.rda = (rda).toFixed(2)
                e.acda = (acda).toFixed(2)
                e.sta = (sta).toFixed(2)
                e.asta = (asta).toFixed(2)
                e.ita = (ita).toFixed(2)
                e.wsca = (wsca).toFixed(2)
                e.total = (total).toFixed(2)
                e.perkg = perkg
                e.totallccostwexp = totallccostwexp
                e.perpc = perpc
                e.perft = (perpc / length )
                e.otherexpenses = e.otherexpenses
            })
            dynamicTable.setData(data)

            rcvIsMoreThenPending.forEach(e => {
                if(e === true)
                {
                    submitButton.disabled = true
                }
            })
            if(rcvIsMoreThenPending.length <= 0)
            {
                submitButton.disabled = false
            }
        }
        //  Dynamic Table [User data]
        dynamicTable = new Tabulator("#dynamicTable", {
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            ajaxParams: function(){
                return {id:cid, status:1};
            },
            ajaxURL: getDetails,
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
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
                        {   title:"Total Pcs",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs",
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Pcs Pending",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs_pending",
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Pcs This Doc",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs_rcv",
                            editor:"number",
                            headerVertical:true,
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Wt(mt)",
                            field:"gdswt",
                            responsive:0,
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            cssClass:"bg-green-200 font-semibold",
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
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"Other.Exp",
                            field:"otherexpenses",
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
            ajaxResponse:function(getDetails, params, response){
                return response.data;
            },
        })
        // Validation & Post
        function validateForm()
        {
            var invoicedate = document.getElementById("invoicedate")
            var invoiceno = document.getElementById("invoiceno")
            var machineno = document.getElementById("machineno")
            var machine_date = document.getElementById("machine_date")
            var gdno = document.getElementById("gdno")
            var gd_date = document.getElementById("gd_date")

            if(gdno.value === ''){
                showSnackbar("gdno # required ","error");
                gdno.focus()
                return
            }
            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

            // disableSubmitButton(true);
            var data = {
                'commercial_invoice_id':@json($clearance->commercial_invoice_id),
                'clearance_id':@json($clearance->id),
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'invoiceno' : invoiceno.value,
                'machineno' : machineno.value,
                'machine_date' :machine_date.value,
                'gdno' : gdno.value,
                'gd_date' :gd_date.value,
                'invoicedate' : invoicedate.value,
                'bankcharges' : parseFloat(bankcharges.value).toFixed(2),
                'collofcustom' : parseFloat(collofcustom.value).toFixed(2),
                'exataxoffie' : parseFloat(exataxoffie.value).toFixed(2),
                'lngnshipdochrgs' : parseFloat(lngnshipdochrgs.value).toFixed(2),
                'localcartage' : parseFloat(localcartage.value).toFixed(2),
                'miscexplunchetc' : parseFloat(miscexplunchetc.value).toFixed(2),
                'customsepoy' : parseFloat(customsepoy.value).toFixed(2),
                'weighbridge' : parseFloat(weighbridge.value).toFixed(2),
                'miscexpenses' : parseFloat(miscexpenses.value).toFixed(2),
                'agencychrgs' : parseFloat(agencychrgs.value).toFixed(2),
                'otherchrgs' : parseFloat(otherchrgs.value).toFixed(2),
                'total' : parseFloat(banktotal.value).toFixed(2),
                'dutyclearance' : dynamicTableData
            };
            // All Ok - Proceed
            fetch(@json(route('clearances.update',$clearance->id)),{
                credentials: 'same-origin', // 'include', default: 'omit'
                method: 'PUT', // 'GET', 'PUT', 'DELETE', etc.
                // body: formData, // Coordinate the body type with 'Content-Type'
                body:JSON.stringify(data),
                headers: new Headers({
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token":csrfToken
                }),
            })
            .then(response => response.json())
            .then( response => {
                if (response == 'success')
                {
                    window.open(window.location.origin + "/clearances","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }
    </script>
@endpush

</x-app-layout>
