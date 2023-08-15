<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Commercial Invoice Imported
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

                                <x-input-date title="Inv. Date" id="invoicedate" name="invoicedate" req required class="col-span-2"/>

                                <x-input-text title="Invoice #" name="invoiceno" req required class=""/>
                                {{-- <x-input-text title="Challan #" name="challanno" req required class=""/> --}}

                                <x-input-numeric title="Duty.Conv. Rate" name="conversionrate"  req required class=""/>
                                <x-input-numeric title="Supp.Conv. Rate" name="sconversionrate"  req required class=""/>
                                <x-input-numeric title="Insurance" name="insurance"  req required class=""/>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-date title="G.D Date" name="machine_date" req required class="col-span-2"/>
                                <x-input-text title="G.D #" name="machineno" req required class="col-span-2"/>
                                {{-- <div class="col-sm-3 mt-3">
                                    <input class="radio" type="radio" checked="checked" name="unt" value="kg" > Duty as Per kg
                                    <input class="radio" type="radio" name="unt" value="pc" > Duty as Per Pc
                                </div> --}}
                                <x-label for="" value="Unit as Per Duty Calculation"/>
                                <select autocomplete="on" required name="dunitid" id ="dunitid"  required >
                                    <option value="" selected>--Unit</option>
                                    @foreach ($cd as $sku)
                                        <option value="{{ $sku->dunitid }}">{{ $sku->dunit }}</option>
                                    @endforeach
                                    {{-- <option value="1" selected>{{$sku->dunit}}</option> --}}
                                </select>



                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Cust Coll" name="collofcustom" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ex Tax of" name="exataxoffie" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Lcl Cartage" name="localcartage" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Custom Sepoy" name="customsepoy" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Weigh Bridge" name="weighbridge" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp" name="miscexpenses" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Other Chgs ($)" name="otherchrgs" hidden required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="banktotal" disabled />

                            </div>
                        </fieldset>
                        {{-- Contract Details --}}
                        <div class="flex flex-row px-4 py-2 items-center">
                            <x-label value="Add Pcs & Feet Size & Press"></x-label>
                            <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Calculate</x-button>
                            <x-label value="This will prepare your commercial invoice for Submission"></x-label>
                        </div>
                       <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <x-button id="submitbutton" type="button" onclick="validateForm()">
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
        let table;
        let searchValue = "";
        const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};
        const getMaster = @json(route('contracts.masterI'));
        const getDetails = @json(route('cis.condet'));
        // console.log(getMaster)
        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        //
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let contract_id = '';

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

        let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        var sconversionrate = document.getElementById("sconversionrate");
        var insurance = document.getElementById("insurance");
        var otherchrgs = document.getElementById("otherchrgs");
        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            calculateButton.disabled = true
            submitButton.disabled = true
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){
                if(conversionrate.value <= 0 || sconversionrate.value <= 0 )
                {
                    showSnackbar("Please add conversion rate before proceeding","error");
                    conversionrate.focus();
                    return;
                }
                if(insurance.value <= 0)
                {
                    showSnackbar("Please add insurance rate before proceeding","error");
                    insurance.focus();
                    return;
                }

                if(!adopted)
                {
                    showModal()
                }
            }
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
        window.onload = function() {
            var input = document.getElementById("invoicedate").focus();
        }

        // -----------------FOR MODAL -------------------------------//
        function showModal(){ modal.style.display = "block"}
        function closeModal(){ modal.style.display = "none"}
        //  When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        //  Table Filter
        function dataFilter(element)
        {
            searchValue = element.value;
            table.setData(getMaster,{search:searchValue});
        }
        //  The Table for Materials Modal
        table = new Tabulator("#tableData", {
            width:"1000px",
            height:"600px",
            autoResize:true,
            responsiveLayout:"collapse",
            // layout:"fitData",
            layout:'fitDataTable',

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
            // height:"100%",

            // {
            //     title:'Revise WSE', headerHozAlign:"center",
            //         columns:[
            //     {title:"WSE",  field:"wse",   formatter:"money",editor:"number",
            //             formatterParams:{thousand:",",precision:2},          responsive:0}]},

            //      {


          //      {
                //  title:'Revise WSE', headerHozAlign:"center",

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
                {title:"Invoice #", field:"invoiceno" , visible:true ,headerSort:false, responsive:0},
                {title:"Date", field:"invoice_date" , visible:true ,headerSort:false, responsive:0},
                {title:"Supplier", field:"supname", visible:true ,headerSort:false, responsive:0},

                {
                 title:'Total Contract Data', headerHozAlign:"center",
                 columns:[
                 {title:"Weight", field:"tweight" , visible:true ,headerSort:false, responsive:0},
                 {title:"TotalPcs", field:"ttotalpcs" , visible:true ,headerSort:false, responsive:0},
                 {title:"TotalVal($)", field:"tvalue" , visible:true ,headerSort:false, responsive:0},

                ]},

                {
                 title:'Pending Contract Data', headerHozAlign:"center",
                 columns:[
                 {title:"Weight", field:"pweight" , visible:true ,headerSort:false, responsive:0},
                 {title:"TotalPcs", field:"ptotalpcs" , visible:true ,headerSort:false, responsive:0},
                 {title:"TotalVal($)", field:"ptvalue" , visible:true ,headerSort:false, responsive:0},

                ]}
           ],
        // },
            // Extra Pagination Data for End Users
            ajaxResponse:function(getDataUrl, params, response){
                remaining = response.total;
                let doc = document.getElementById("example-table-info");
                doc.classList.add('font-weight-bold');
                doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
                return response;
            }
        })
        //  Adds New row to dynamicTable
        table.on('rowClick',function(e,row){
            var simple = {...row}
            var data = simple._row.data

            contract_id = data.contract_id
            // console.info(contract_id)
            detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
            calculateButton.disabled = false
            closeModal()
        })
    </script>
@endpush

@push('scripts')
    <script>
        // Populate Locations in Tabulator
        const locations = @json($locations);
        const hscodes = @json($hscodes);
        // Hscode List
        var hscodeList=[]
        hscodes.forEach(e => {
            hscodeList.push({ value:e.hscode, label:e.hscode, id:e.hscode})
        })
        // Locations List
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})
        });
        //  ------------------Dynamic Table----------------------//
        async function fetchDataFromServer(url)
        {
            var data =  await fetch(url,{
                method:"GET",
                headers: { 'Accept':'application/json','Content-type':'application/json'},
                })
                .then((response) => response.json()) //Transform data to json
                .then(function(response){
                    // console.log(response);
                    return response;
                })
                .catch(function(error){
                    console.log("Error : " + error);
            })
            //  Stremaline Data for Tabulator
            for (let index = 0; index < data.length; index++) {

                const obj = data[index];
                const mat = obj['material']
                // const hsc = mat['hscodes']

                contract_id = obj.contract_id
                // console.log(obj.bundle1 , obj.pcspbundle1 ,obj.bundle2 , obj.pcspbundle2);
                // var vpcs = ((obj.bundle1 * obj.pcspbundle1) + (obj.bundle2 * obj.pcspbundle2)).toFixed(2)
                var vpcs = obj.totpcs
                // console.log(vpcs);
                // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
                var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
                dynamicTable.addData([
                    {
                        id :                obj.id,
                        material_title :    obj.material_title,
                        contract_id :       obj.contract_id,
                        material_id :       obj.material_id,
                        supplier_id :       obj.supplier_id,
                        user_id :           obj.user_id,
                        category_id :       obj.category_id,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,



                        totpcs:             obj.totpcs,


                        purval:             0,
                        dutval:             0,
                        comval:             0,
                        invlvlchrgs:        0,


                        dimension_id :      obj.dimension_id,
                        dimension :         obj.dimension,
                        source_id :         obj.source_id,
                        brand_id :          obj.brand_id,
                        pcs :               vpcs,
                        gdswt :             obj.gdswt ,
                        dutygdswt :         obj.dutygdswt ,
                        inkg :              vwinkg,
                        length :            0,
                        gdsprice :          obj.gdsprice,
                        dtyrate :           obj.dtyrate,
                        invsrate:           obj.invsrate,
                        amtindollar :       obj.purval  ,
                        dtyamtindollar :       0,
                        comamtindollar :       0,

                        amtinpkr :          ( obj.gdswt *  obj.gdsprice  * conversionrate.value).toFixed(0),
                        dtyamtinpkr :        ( obj.gdswt *  obj.dtyrate  * conversionrate.value).toFixed(0),
                        comamtinpkr :        0,
                        itmratio:          0,
                        dtyitmratio:0,

                        insuranceperitem :  0,
                        dtyinsuranceperitem :  0,
                        amountwithoutinsurance : 0,
                        dtyamountwithoutinsurance : 0,
                        onepercentdutypkr : 0,
                        dtyonepercentdutypkr : 0,
                        pricevaluecostsheet : 0,
                        dtypricevaluecostsheet : 0,

                        totallccostwexp:    0,
                        perpc:              0,
                        perkg:              0,
                        perft:            0,
                        otherexpenses:    0,
                        qtyinfeet:0,
                        wse      : 0,
                        goods_received  :0,
                        total :0



                    }
                ])
            }
        }


        var calculate = function(){

            if(dunitid.value <= 0)
                {
                    showSnackbar("Please select Duty Unit","error");
                    dunitid.focus();
                    return;
                }



            calculateBankCharges()
            //  console.log($unt)
            // alert(dynamicTable.getData())
            const data = dynamicTable.getData()
            // Get Selected HSCode Value
            var hscode;
            //  First Iteration to calculate Basic Data
            data.forEach(e => {

                var pcs = e.pcs
                var total=e.total
                // var goods_received=e.goods_received
                var gdswt = e.gdswt
                var dutygdswt = e.dutygdswt
                var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
                var length = e.length
                var gdsprice = e.gdsprice
                var dtyrate = e.dtyrate
                var invsrate = e.invsrate
                var totpcs = e.totpcs
                var amtindollar=e.amtindollar
                var dtyamtindollar=e.dtyamtindollar
                var comamtindollar=e.comamtindollar

                var amtinpkr=e.amtinpkr
                var dtyamtinpkr=e.dtyamtinpkr
                var comamtinpkr=e.comamtinpkr
                var goods_received = e.goods_received
                // var total = e.total

                var dutval=e.dutval
                var purval=e.purval
                var comval=e.comval
                var wse=e.wse
                 e.pcs = pcs
                 e.gdswt = gdswt
                 e.inkg = inkg
                 e.length = length
                 e.dutygdswt=dutygdswt
                 e.gdsprice = gdsprice
                 e.dtyrate = dtyrate
                 e.purval=purval
                 e.dutval=dutval
                 e.comval=comval
                 e.amtinpkr=amtinpkr
                 e.dtyamtinpkr=dtyamtinpkr
                 e.comamtinpkr=comamtinpkr
                 e.goods_received=goods_received
                //  e.total = total
                 e.wse=wse
                //  console.log(e.dtyrate)

            var sid = document.getElementById("dunitid");
            var dunitid = sid.options[sid.selectedIndex];


            if(dunitid.value==1)
                   {
                        e.dutval = parseFloat(e.dutygdswt) * parseFloat(e.dtyrate)
                   }
                 else
                     {
                         e.dutval = parseFloat(e.pcs) * parseFloat(e.dtyrate)
                    }
                if(e.sku_id==1)
                   {
                        // e.dutval = parseFloat(e.dutygdswt) * parseFloat(e.dtyrate)
                        e.purval = parseFloat(e.gdswt) * parseFloat(e.gdsprice)
                        e.comval = parseFloat(e.gdswt) * parseFloat(e.invsrate)
                   }
                 else
                     {
                        //  e.dutval = parseFloat(e.pcs) * parseFloat(e.dtyrate)
                         e.purval = parseFloat(e.pcs) * parseFloat(e.gdsprice)
                         e.comval = parseFloat(e.pcs) * parseFloat(e.invsrate)
                    }
                        e.amtindollar=e.purval
                        e.dtyamtindollar=e.dutval
                        e.comamtindollar=e.comval

                        e.amtinpkr=e.amtindollar * sconversionrate.value
                        e.dtyamtinpkr=e.dtyamtindollar * conversionrate.value
                        e.comamtinpkr=e.comamtindollar * conversionrate.value

                // console.log(e.dtyamtinpkr)


                //   break
                ////////////////////////////////////////////////////////////////////////
                // Get Values of HSCode Selected in List and Populate Data
                ///////////////////////////////////////////////////////////////////////
                hscode = hscodes.find(  function(el) { return el.hscode === e.hscode })
                // e.cd = hscode.cd
                // e.st = hscode.st
                // e.rd = hscode.rd
                // e.acd = hscode.acd
                // e.ast = hscode.ast
                // e.it = hscode.it
                // e.wsc = hscode.wse

                var cd = hscode.cd
                var st = hscode.st
                var rd = hscode.rd
                var acd = hscode.acd
                var ast = hscode.ast
                var it = hscode.it
                // var wse = wse


                e.cd=cd
                e.st=st
                e.rd=rd
                e.acd=acd
                e.ast=ast
                e.it=it
                e.total=total
                // e.wse=wse
            })

            //  Get Ratio after price/length/pcs update
            var amtinpkrtotal = 0
            var dtyamtinpkrtotal = 0

            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                dtyamtinpkrtotal += parseFloat(e.dtyamtinpkr)
            });



            data.forEach(e => {

                var dtyamtinpkr = parseFloat(conversionrate.value) * parseFloat(e.dutval)
                var amtinpkr = sconversionrate.value * e.purval

                var itmratio = amtinpkr / amtinpkrtotal * 100
                var dtyitmratio = ( parseFloat(dtyamtinpkr) / parseFloat(dtyamtinpkrtotal) ) * 100

                var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var dtyinsuranceperitem = parseFloat(insurance.value) * dtyitmratio / 100

                var amountwithoutinsurance = (parseFloat(e.amtindollar) + parseFloat(insuranceperitem)) * parseFloat(conversionrate.value)
                var dtyamountwithoutinsurance = ( parseFloat(e.dtyamtindollar) + parseFloat(dtyinsuranceperitem) ) * parseFloat(conversionrate.value)


                var onepercentdutypkr = amountwithoutinsurance * 0.01
                var dtyonepercentdutypkr = dtyamountwithoutinsurance * 0.01

                var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)
                var dtypricevaluecostsheet = parseFloat(dtyonepercentdutypkr + dtyamountwithoutinsurance)


                var cda = parseFloat(e.cd) * dtypricevaluecostsheet / 100

                //  console.log(cda ,parseFloat(e.cd), dtypricevaluecostsheet)
                //  var tmpcda =  dtyamtinpkrtotal
                var rda = parseFloat(e.rd) * dtypricevaluecostsheet / 100
                // console.log(rda)

                var acda = parseFloat(e.acd) * dtypricevaluecostsheet / 100
                var sta = (dtypricevaluecostsheet + cda + rda + acda) * parseFloat(e.st) / 100
                var asta = (dtypricevaluecostsheet + cda + rda + acda) * parseFloat(e.ast) / 100
                var ita =(dtypricevaluecostsheet + cda + sta + rda + acda + asta) * parseFloat(e.it) / 100
                var wsca = (dtypricevaluecostsheet * parseFloat(e.wse)) /100

                goods_received = cda + rda + sta + acda + asta + ita + wsca


                var total=0
                var invlvlchrgs=0
                var totallccostwexp=0

                var perpc=0
                var perkg=0
                var perft=0
                var perft=0

                var qtyinfeet = (e.pcs * e.length).toFixed(2)
                var otherexpenses = 0







                e.amtindollar = e.purval
                e.amtinpkr = amtinpkr
                e.itmratio = itmratio
                e.dtyitmratio = dtyitmratio
                e.insuranceperitem = insuranceperitem
                e.dtyinsuranceperitem = dtyinsuranceperitem
                e.invlvlchrgs=invlvlchrgs
                e.amountwithoutinsurance = amountwithoutinsurance
                e.dtyamountwithoutinsurance = dtyamountwithoutinsurance
                e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
                e.dtyonepercentdutypkr = (dtyonepercentdutypkr).toFixed(2)
                e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)
                e.dtypricevaluecostsheet = (dtypricevaluecostsheet).toFixed(2)
                // e.tmpcda = (tmpcda).toFixed(2)
                e.cda = (cda).toFixed(2)
                e.rda = (rda).toFixed(2)
                e.acda = (acda).toFixed(2)
                e.sta = (sta).toFixed(2)
                e.asta = (asta).toFixed(2)
                e.ita = (ita).toFixed(2)
                e.wsca = (wsca).toFixed(2)
                e.total = (total).toFixed(2)
                e.goods_received = goods_received
                e.perkg = perkg
                e.totallccostwexp = totallccostwexp
                e.perpc = perpc
                e.perft = perft
                e.otherexpenses = otherexpenses
                e.qtyinfeet = qtyinfeet

                // e.inkg = inkg
            })

            var sumoftotdty = 0
            var totwt = 0

            data.forEach(e => {
                    sumoftotdty += parseFloat(e.goods_received)
                        totwt += parseFloat(e.gdswt)
                    });
            data.forEach(e => {
                //  var total = 1500
                 e.total = ( ( parseFloat(e.total) + parseFloat(sumoftotdty) ) / parseFloat(totwt) ) * parseFloat(e.gdswt)
                 e.invlvlchrgs = ( parseFloat(banktotal.value)/parseFloat(totwt) ) * parseFloat(e.gdswt)
                 e.totallccostwexp = e.total + e.amtinpkr + e.invlvlchrgs
                 e.perpc =  (( e.totallccostwexp + e.otherexpenses) / e.pcs).toFixed(2)
                 e.perkg = (( e.totallccostwexp + e.otherexpenses) / e.gdswt).toFixed(2)
                 e.perft =(( e.totallccostwexp + e.otherexpenses) / e.qtyinfeet).toFixed(2)
                //  console.log(e.totallccostwexp)
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
            height:"450px",
            width:"1000px",
            rowContextMenu: rowMenu,
            layout:'fitDataTable',
            responsiveLayout:"collapse",
             reactiveData:true,
            // movableRows:true,
            // groupBy:"material_title",
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"Id",           field:"id", visible:false},
                {title:"Material",     field:"material_title",responsive:0},
                {title:"dimension",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu},
                {title:"Unit",         field:"sku",responsive:0},
                {title:"Unitid",       field:"sku_id",visible:false},
                {title:"contract_id",  field:"contract_id",visible:false},
                {title:"material_id",  field:"material_id",visible:false},
                {title:"supplier_id",  field:"supplier_id",visible:false},
                {title:"user_id",      field:"user_id",visible:false},
                {title:"category_id",  field:"category_id",visible:false},
                {title:"sku_id",       field:"sku_id",visible:false},
                {title:"dimension_id", field:"dimension_id",visible:false},
                // {title:"source_id",    field:"source_id",visible:false},
                // {title:"brand_id",     field:"brand_id",visible:false},

                // {title:"totpcs",     field:"pcs",visible:true},
                // {title:"totwt",     field:"gdswt",visible:true},


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
                            bottomCalc:"sum",
                            formatter:"money",
                            // cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:0},
                        },
                        {   title:"Supp.Wt(Kg)",
                            field:"gdswt",
                            responsive:0,
                            editor:"number",
                            headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            // cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Duty.Wt(Kg)",
                            field:"dutygdswt",
                            responsive:0,
                            bottomCalc:"sum",
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            // cssClass:"bg-green-200 font-semibold",
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
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },

                        {   title:"QtyInFeet",
                            field:"qtyinfeet",
                            headerVertical:true,
                            // cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            responsive:0,
                            formatterParams:{thousand:",",precision:0},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:0}  ,
                        },


                    ]
                },

                {
                title:'Revise WSE', headerHozAlign:"center",
                    columns:[
                {title:"WSE",  field:"wse",   formatter:"money",editor:"number",
                        formatterParams:{thousand:",",precision:2},          responsive:0}]
                },

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
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                        },
                        {   title:"Supp.Val(Rs)",
                            field:"amtinpkr",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                        },

                        {   title:"Com.Invs.Price",
                            field:"invsrate",
                            responsive:0,
                            headerVertical:true,
                            editor:"number",
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
                             bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
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


                        {   title:"Duty.Price($)",
                            field:"dtyrate",
                            headerVertical:true,
                            formatter:"money",
                            editor:"number",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },

                        {   title:"Duty.Val($)",
                            field:"dtyamtindollar",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Duty.Val(Rs)",
                            field:"dtyamtinpkr",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                        },
                        {   title:"Insu.Ratio(%)",
                            field:"dtyitmratio",
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },

                {
                    title:"Insur/Item($)",
                    field:"dtyinsuranceperitem",
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"Amt W/Insur (PKR)",
                    field:"dtyamountwithoutinsurance",
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },
                 {
                    title:"1% Duty (PKR)",
                    field:"dtyonepercentdutypkr",
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },



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
                            {title:"DutyGDCal.", cssClass:"bg-green-200 font-semibold",  field:"goods_received", headerVertical:true,  formatter:"money",formatterParams:{thousand:",",precision:0},
                         responsive:0,bottomCalc:"sum",bottomCalcParams:{precision:0}},

              {
                    title:"PayableDuty",
                    headerVertical:true,
                    field:"total",
                     cssClass:"bg-green-200 font-semibold",
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    responsive:0,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:0},
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
                    formatterParams:{thousand:",",precision:0},
                },


                    ]
                },


                {   title:"OtherExpFrPaym.",
                            field:"otherexpenses",
                            headerVertical:true,
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            formatterParams:{thousand:",",precision:0},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:0}  ,
                        },





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
                        {title:"Per Pc",    field:"perpc",         responsive:0 ,formatter:"money",
                            formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Kg",    field:"perkg",         responsive:0 , formatter:"money",
                            formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Feet",  field:"perft",       responsive:0 ,formatter:"money",
                            formatterParams:{thousand:",",precision:2}, },
                    ]
                },
                // {title:"Material",     field:"material_title",responsive:2},
                // {title:"Size",         field:"dimension",responsive:2},
                // {title:"Unit",         field:"sku",responsive:2},
            ],
        })
        dynamicTable.on("dataLoaded", function(data){
            //data - all data loaded into the table
        });
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
            if(machineno.value === ''){
                showSnackbar("machineno # required ","error");
                machineno.focus()
                return;
            }
            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

            for (let index = 0; index < dynamicTableData.length; index++) {
                const element = dynamicTableData[index];

                if(element.location === undefined)
                {
                    showSnackbar("Location must be Enter","info");
                    return;
                }
            }

            // disableSubmitButton(true);
            var data = {
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                'sconversionrate' : parseFloat(sconversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'contract_id' : contract_id,
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
                'dunitid' : parseFloat(dunitid.value).toFixed(0),
                'total' : parseFloat(banktotal.value).toFixed(2),
                'comminvoice' : dynamicTableData
            };
            // All Ok - Proceed
            fetch(@json(route('cis.store')),{
                credentials: 'same-origin', // 'include', default: 'omit'
                method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
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
