<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Commercial Invoice | {{ $i->id }}
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

                                <x-input-date title="Inv. Date" name="invoicedate" value="{{ $i->invoice_date->format('Y-m-d') }}" req required class="col-span-2"/>

                                <x-input-text title="Invoice #" name="invoiceno" value="{{ $i->invoiceno }}" req required class=""/>
                                {{-- <x-input-text title="Challan #" name="challanno" value="{{ $i->challanno }}" req required class=""/> --}}

                                <x-input-numeric title="Duty.Conv.Rate" name="conversionrate" value="{{ $i->conversionrate }}" req required class=""/>
                                <x-input-numeric title="Supp.Conv.Rate" name="sconversionrate" value="{{ $i->sconversionrate }}"  req required class=""/>
                                <x-input-numeric title="Insurance" name="insurance"  value="{{ $i->insurance }}" req required class=""/>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-date title="Mac. Date" name="machine_date" value="{{ $i->machine_date->format('Y-m-d') }}" req required class="col-span-2"/>
                                <x-input-text title="Machine #" name="machineno" value="{{ $i->machineno }}" req required class="col-span-2"/>

                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges" value="{{ $i->bankcharges }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Cust Coll" name="collofcustom" value="{{ $i->collofcustom }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ex Tax of" name="exataxoffie" value="{{ $i->exataxoffie }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" value="{{ $i->lngnshipdochrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Lcl Cartage" name="localcartage" value="{{ $i->localcartage }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" value="{{ $i->miscexplunchetc }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Custom Sepoy" name="customsepoy" value="{{ $i->customsepoy }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Weigh Bridge" name="weighbridge" value="{{ $i->weighbridge }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp" name="miscexpenses" value="{{ $i->miscexpenses }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" value="{{ $i->agencychrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Other Chgs($)" name="otherchrgs" value="{{ $i->otherchrgs }}"  required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="banktotal" value="{{ $i->total}}"  disabled />

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
        const getDetails = @json("$i->commericalInvoiceDetails");
        const cid = @json("$i->id");

        // Populate Locations in Tabulator
        const locations = @json($locations);
        const hscodes = @json($hscodes);

        // Hscode List
        var hscodeList=[]
        hscodes.forEach(e => {
            hscodeList.push({ value:e.hscode, label:e.hscode, id:e.hscode})
        })

        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})

        });





        // console.info(cid)
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
     //   let otherchrgs= document.getElementById("otherchrgs")
        let banktotal= document.getElementById("banktotal")
        // Important Rates
        let conversionrate = document.getElementById("conversionrate");
        let sconversionrate = document.getElementById("sconversionrate");

        var insurance = document.getElementById("insurance");
        var otherchrgs = document.getElementById("otherchrgs");

        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            // calculateButton.disabled = true
            submitButton.disabled = true
        })
        // Calculate Bank Charges [ onblur ]
        function calculateBankCharges()
        {
            var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) //+ parseFloat(otherchrgs.value)
            // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
            banktotal.value = t.toFixed(2)
            // console.log(banktotal.value);
        }
    </script>
@endpush

@push('scripts')
    <script>

        var calculate = function(){
            calculateBankCharges()
            // alert(dynamicTable.getData())
            const data = dynamicTable.getData()
            //  Get Ratio after price/length/pcs update

            //   var dtyrate = e.dtyrate
            //   var dtyamtindollar = gdswt * dtyrate
            //   var dtyamtinpkr = ( gdswt *  dtyrate  * conversionrate.value).toFixed(0),

            var hscode;
            var amtinpkrtotal = 0
            var dtyamtinpkrtotal = 0

            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                // dtyamtinpkrtotal +=   conversionrate.value * e.dtyrate * e.gdswt
                dtyamtinpkrtotal +=  parseFloat(e.dtyamtinpkr)
            });
            data.forEach(e => {
        /// before edit
                // var pcs = e.pcs
                // var gdswt = e.gdswt
                // var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
                // var length = e.length
                // var gdsprice = e.gdsprice
                // var dtyrate = e.dtyrate
                // var totpcs = e.totpcs
                // var purval = e.purval
                // var dutval = e.dutval


                // var amtindollar = gdsprice * gdswt
                // var dtyamtindollar = dtyrate * gdswt

                var pcs = e.pcs
                var gdswt = e.gdswt
                var dutygdswt = e.dutygdswt
                var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
                var length = e.length
                var gdsprice = e.gdsprice
                var dtyrate = e.dtyrate
                var invsrate = e.invsrate
                var totpcs = e.totpcs
                var amtindollar=e.amtindollar
                var comamtindollar=e.comamtindollar
                var invlvlchrgs=e.invlvlchrgs



                var dtyamtindollar=e.dtyamtindollar
                var amtinpkr=e.amtinpkr
                var comamtinpkr=e.comamtinpkr
                var dtyamtinpkr=e.dtyamtinpkr
                var dutval=e.dutval
                var purval=e.purval
                var wse=e.wse


                e.pcs = pcs
                 e.gdswt = gdswt
                 e.inkg = inkg
                 e.length = length
                 e.dutygdswt=dutygdswt
                 e.gdsprice = gdsprice
                 e.dtyrate = dtyrate
                 e.invsrate = invsrate

                 e.purval=purval
                 e.dutval=dutval
                 e.amtinpkr=amtinpkr
                 e.comamtinpkr=comamtinpkr

                 e.invlvlchrgs=invlvlchrgs


                 e.dtyamtinpkr=dtyamtinpkr
                 e.wse=wse

                 if(e.sku_id==1)
                   {
                        e.dutval = parseFloat(e.dutygdswt) * parseFloat(e.dtyrate)
                        e.purval = parseFloat(e.gdswt) * parseFloat(e.gdsprice)
                        e.comamtindollar = parseFloat(e.gdswt) * parseFloat(e.invsrate)
                 }
                 else
                     {
                         e.dutval = parseFloat(e.pcs) * parseFloat(e.dtyrate)
                         e.purval = parseFloat(e.pcs) * parseFloat(e.gdsprice)
                         e.comamtindollar = parseFloat(e.pcs) * parseFloat(e.invsrate)
                    }
                e.amtindollar=e.purval
                e.dtyamtindollar=e.dutval

                e.amtinpkr=e.amtindollar * sconversionrate.value
                e.dtyamtinpkr=e.dtyamtindollar * conversionrate.value
                e.comamtinpkr=e.comamtindollar * conversionrate.value

                hscode = hscodes.find(  function(el) { return el.hscode === e.hscode })

                var cd = hscode.cd
                var st = hscode.st
                var rd = hscode.rd
                var acd = hscode.acd
                var ast = hscode.ast
                var it = hscode.it
                // var wse = hscode.wse

                e.cd=cd
                e.st=st
                e.rd=rd
                e.acd=acd
                e.ast=ast
                e.it=it
                // e.wse=wse

                // var amtindollar = e.amtindollar
                // var dtyamtindollar = e.dtyamtindollar



                // var amtinpkr = sconversionrate.value * amtindollar
                // var dtyamtinpkr = conversionrate.value * dtyamtindollar

                var itmratio = parseFloat(dtyamtinpkr) / parseFloat(dtyamtinpkrtotal) * 100
                //   var dtyitmratio =parseFloat(dtyamtinpkr) / parseFloat(dtyamtinpkrtotal) * 100
                // console.log(dtyamtinpkrtotal)
                var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var amountwithoutinsurance = ( parseFloat(dtyamtindollar) + parseFloat(insuranceperitem )) * parseFloat(conversionrate.value)
                var onepercentdutypkr = parseFloat(amountwithoutinsurance) * 0.01
                var pricevaluecostsheet = parseFloat(onepercentdutypkr) + parseFloat(amountwithoutinsurance)

                var cda = (parseFloat(e.cd) * parseFloat(pricevaluecostsheet)) / 100

                var rda = e.rd * pricevaluecostsheet / 100
                var acda = e.acd * pricevaluecostsheet / 100
                var sta = (pricevaluecostsheet + cda + rda + acda) * e.st / 100
                var asta = (pricevaluecostsheet + cda + rda + acda) * e.ast / 100
                var ita =(pricevaluecostsheet + cda + sta + rda + acda + asta) * e.it / 100
                var wsca = (pricevaluecostsheet * e.wse) /100
                var total = cda + rda + sta + acda + asta + ita + wsca
                var perft = (e.perpc / e.length).toFixed(2)
                // var totallccostwexp = total + pricevaluecostsheet + (banktotal.value * itmratio / 100)
                var totallccostwexp = total + amtinpkr + (banktotal.value * itmratio / 100)
                var invlvlchrgs =(banktotal.value * itmratio / 100)
                var otherexpenses = ( sconversionrate.value * otherchrgs.value ) * itmratio / 100
                var perpc = ((e.totallccostwexp+otherexpenses) / e.pcs).toFixed(2)
                var perkg = (e.perpc / inkg).toFixed(2)
                var qtyinfeet = (e.pcs * e.length).toFixed(2)

                // e.pcs = pcs
                // e.gdswt = gdswt
                // e.inkg = inkg
                // e.length = length
                // e.gdsprice = gdsprice
                // e.dtyrate = dtyrate

                // e.amtindollar = amtindollar
                // e.amtinpkr = amtinpkr
                // e.dtyrate = dtyrate
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
                // e.perkg = perkg
                e.totallccostwexp = totallccostwexp
                e.perpc = perpc
                e.perft = (perpc / length )
                e.otherexpenses = otherexpenses
                e.qtyinfeet = qtyinfeet
                // e.inkg = inkg
            })
            dynamicTable.setData(data)
            submitButton.disabled = false
        }
        //  Dynamic Table [User data]



        var rowMenu = [
    {
        label:"<i class='fas fa-user'></i> Change Name",
        action:function(e, row){
            row.update({name:"Steve Bobberson"});
        }
    },
    {
        label:"<i class='fas fa-check-square'></i> Select Row",
        action:function(e, row){
            row.select();
        }
    },
    {
        separator:true,
    },
    {
        label:"Admin Functions",
        menu:[
            {
                label:"<i class='fas fa-trash'></i> Delete Row",
                action:function(e, row){
                    row.delete();
                }
            },
            {
                label:"<i class='fas fa-ban'></i> Disabled Option",
                disabled:true,
            },
        ]
    }
]

var headerMenu = function(){
    var menu = [];
    var columns = this.getColumns();

    for(let column of columns){

        //create checkbox element using font awesome icons
        let icon = document.createElement("i");
        icon.classList.add("fas");
        icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

        //build label
        let label = document.createElement("span");
        let title = document.createElement("span");

        title.textContent = " " + column.getDefinition().title;

        label.appendChild(icon);
        label.appendChild(title);

        //create menu item
        menu.push({
            label:label,
            action:function(e){
                //prevent menu closing
                e.stopPropagation();

                //toggle current column visibility
                column.toggle();

                //change menu item icon
                if(column.isVisible()){
                    icon.classList.remove("fa-square");
                    icon.classList.add("fa-check-square");
                }else{
                    icon.classList.remove("fa-check-square");
                    icon.classList.add("fa-square");
                }
            }
        });
    }

   return menu;
};


        dynamicTable = new Tabulator("#dynamicTable", {
            height:"550px",
            width:"1000px",
            rowContextMenu: rowMenu,
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            movableRows:true,
            groupBy:"material_title",
            data:getDetails,
            // reactiveData:true,
            columns:[
                // {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                //     cellClick:function(e, cell){
                //         cell.getRow().delete();
                //     }
                // },

                // {title: "id",field: "myid",visible:false},
                // {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                //         values:newList,
                //         cssClass:"bg-green-200 font-semibold",
                //         validator:["required"]
                //     }
                // },

                {title:"Id",           field:"material_id", visible:false},
                // {title:"Material",     field:"material.title"},
                {title:"dimension",    field:"material.dimension",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"Unit",         field:"material.sku",responsive:0},
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

                    {title: "id",field: "myid",visible:false},
                        {   title:"Location",headerHozAlign :'center',
                            field:"location" ,
                            editor:"list",
                            responsive:0 ,
                            headerVertical:true,
                            // cssClass:"bg-green-200 font-semibold",
                            editorParams:   {
                                values:newList,
                                validator:["required"]
                            }
                        },
                        {   title:"HS code",headerHozAlign :'center',
                            field:"hscode",
                            editor:"list",
                            responsive:0,
                            headerVertical:true,
                            // cssClass:"bg-green-200 font-semibold",
                            editorParams:   {
                                values:hscodeList,
                                validator:["required"]
                            }
                        },

                    {   title:"Pcs",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs",
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:0},
                        },
                        {   title:"Supp.Wt(Kg)",
                            field:"gdswt",
                            responsive:0,
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Duty.Wt(Kg)",
                            field:"dutygdswt",
                            responsive:0,
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",
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
                            // selectContents:true,
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            // bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"QtyInFeet",
                            field:"qtyinfeet",
                            headerVertical:true,
                          //  editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:0}  ,
                        },


                    ]
                },

                // {
                // title:'Revise WSE', headerHozAlign:"center",
                    // columns:[
                {title:"Rvs WSE Rate",  field:"wse",headerVertical:true,   formatter:"money",editor:"number",
                        formatterParams:{thousand:",",precision:2},          responsive:0},
                    // ]
                // },

                {
                    title:'Price',
                    columns:[
                        {   title:"Supp.Price($)",
                            field:"gdsprice",
                            formatter:"money" ,
                            // editor:"number",
                            responsive:0,
                            headerVertical:true,
                            // cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2}
                        },

                    ]
                },


                {
                    title:'Amount', headerHozAlign:"center",
                    columns:[
                        {   title:"Supp.Val($)",
                            field:"amtindollar",
                            headerVertical:true,
                            formatter:"money",
                            responsive:0,
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                        },
                        {   title:"Supp.Val(Rs)",
                            field:"amtinpkr",
                            headerVertical:true,
                            formatter:"money",
                            responsive:0,
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                        },

                        {   title:"Duty.Price($)",
                            field:"dtyrate",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },

                        {   title:"Duty.Val($)",
                            field:"dtyamtindollar",
                            formatter:"money",
                            headerVertical:true,
                            responsive:0,
                            bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                        },
                        {   title:"Duty.Val(Rs)",
                            field:"dtyamtinpkr",
                            headerVertical:true,
                            formatter:"money",
                            responsive:0,
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                        },

                        {   title:"Com.Invs.Price",
                            field:"invsrate",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            // bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Com.Invs.Val($)",
                            field:"comamtindollar",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:2},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Com.Invs.Val(Rs)",
                            field:"comamtinpkr",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {
                    title:'Duties Amount (PKR)', headerHozAlign:"center",
                    columns:[
                        {title:"CD",                field:"cda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"ST",                field:"sta", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"RD",                field:"rda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"ACD",               field:"acda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},            responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"AST",               field:"asta",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},           responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"IT",                field:"ita",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},            responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"WSE",               field:"wsca",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},           responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"Total Duty", cssClass:"bg-green-200 font-semibold",  field:"total", headerVertical:true,  formatter:"money",formatterParams:{thousand:",",precision:0},
                         responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                    ]
                },

                {
                    title:"Invoice Level Exp.",
                    headerVertical:true,
                    field:"invlvlchrgs",
                    cssClass:"bg-green-200 font-semibold",
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    responsive:0,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:0},
                },


                {
                    title:"Tot Cost(Rs)",
                    headerVertical:true,
                    field:"totallccostwexp",
                    cssClass:"bg-green-200 font-semibold",
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    responsive:0,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },



                        {   title:"Item Ratio(%)",
                            field:"itmratio",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                    ]
                },
                {
                    title:"Insurance Val($)",
                    field:"insuranceperitem",
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    responsive:0,
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"Amt W/Insur (PKR)",
                    field:"amountwithoutinsurance",
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    responsive:0,
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"1% Duty (PKR)",
                    field:"onepercentdutypkr",
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },
                // {
                //     title:"Price value (CS)",
                //     headerVertical:true,
                //     field:"pricevaluecostsheet",
                //     formatter:"money",
                //     formatterParams:{thousand:",",precision:2},
                // },

                {   title:"Other.Exp",
                            field:"otherexpenses",
                            headerVertical:true,
                            editor:"number",
                            bottomCalc:"sum",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                },





                       // {title:"Code",              field:"material.hscodes.hscode",
                        // headerVertical:true,       visible:true},
                        {title:"CD",                field:"cd",responsive:0,
                        headerVertical:true,        visible:true},
                        {title:"ST",                field:"st",responsive:0,
                        headerVertical:true,          visible:true},
                        {title:"RD",                field:"rd",responsive:0,
                        headerVertical:true,        visible:true},
                        {title:"ACD",               field:"acd",responsive:0,
                        headerVertical:true,          visible:true},
                        {title:"AST",               field:"ast",responsive:0,
                        headerVertical:true,        visible:true},
                        {title:"IT",                field:"it",responsive:0,
                        headerVertical:true,        visible:true},
                        // {title:"WSE",               field:"wse",
                        // headerVertical:true,         visible:true},



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
        // Validation & Post
        function validateForm()
        {

            var invoicedate = document.getElementById("invoicedate")
            var invoiceno = document.getElementById("invoiceno")
            // var challanno = document.getElementById("challanno")
            var machineno = document.getElementById("machineno")
            var machine_date = document.getElementById("machine_date")

            if(invoiceno.value === ''){
                showSnackbar("Invoice # required ","error");
                invoiceno.focus()
                return;
            }
            // if(challanno.value === ''){
            //     showSnackbar("challanno # required ","error");
            //     challanno.focus()
            //     return;
            // }
            if(machineno.value === ''){
                showSnackbar("machineno # required ","error");
                machineno.focus()
                return;
            }
            const dynamicTableData = dynamicTable.getData();

            //// Marking From Usman on 15-12-2022
            // if(dynamicTableData.length == 0)
            // {
            //     showSnackbar("You must have atleast 1 row of item to Proceed","info");
            //     return;
            // }
           // //**** Marking From Usman on 15-12-2022

            // disableSubmitButton(true);
            var data = {
                'commercial_invoice_id':@json($i->id),
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                'sconversionrate' : parseFloat(sconversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'invoiceno' : invoiceno.value,
                // 'challanno' : challanno.value,
                'machineno' : machineno.value,
                'machine_date' :machine_date.value,
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
                'comminvoice' : dynamicTableData
            };
            // All Ok - Proceed
            fetch(@json(route('cis.update','$i->id')),{
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
                    window.open(window.location.origin + "/cis","_self" );
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
