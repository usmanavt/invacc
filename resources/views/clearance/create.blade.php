<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Duties Clearance
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

                                {{-- <x-input-date title="Inv. Date" id="invoicedate" name="invoicedate" req required class="col-span-2" disabled/> --}}
                                <x-input-text title="Invoice #" name="invoiceno"  req required class="" disabled/>
                                {{-- <x-input-date title="Mac. Date" name="machine_date" id="machine_date" req required class="col-span-2" disabled/> --}}
                                <x-input-text title="Mac. No" name="machineno" req required class="col-span-2" disabled/>
                                <x-input-date title="Mac. Date" name="machine_date" req required class="col-span-2" disabled/>
                                <x-input-date title="Clearance Date" name="invoice_date" req required class="col-span-2" />


                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-date title="GD Date" name="gd_date"  req required />
                                    <x-input-text title="GD #" name="gdno" value="" req required />
                                    <x-input-numeric title="" name="cominvsid" hidden   />
                                <x-input-numeric title="Conversion Rate" name="conversionrate"  req required class=""/>
                                {{-- <x-input-numeric title="Supp.Conv. Rate" name="sconversionrate"  req required class=""/> --}}
                                <x-input-numeric title="Insurance" name="insurance"  req required class=""/>

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

                        {{-- <fieldset class="border px-4 py-2 rounded">
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
                                <x-input-numeric title="Agency Chgs" name="agencychrgs" required  onblur="calculateBankCharges()"/> --}}
                                {{-- <x-input-numeric title="Other Chgs ($)" name="otherchrgs" required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="banktotal" disabled />

                            </div>
                        </fieldset>
                        Contract Details --}}

                        <div class="grid grid-cols-12 gap-2 py-2 items-center">
                            {{-- <label for="">Debit to </label>
                            <select autocomplete="on" name="bank_id" id="bank_id" required>
                                <option disabled selected value="">--Select</option>
                                @foreach ($bnk as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->title }}</option>
                                @endforeach
                            </select> --}}

                            <label for="autocompleted" >Supplier<x-req /></label>
                            <div class="w-96 relative"   onclick="event.stopImmediatePropagation();" >
                                <input id="autocompleted" placeholder="Select Bank" class=" px-5 py-3 w-full border border-gray-400 rounded-md"
                                onkeyup="onkeyUp(event)" />
                                <div>
                                    <select  id="bank_id" name="bank_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </select>
                                </div>
                            </div>






                            <x-input-date title="cheque date" name="cheque_date" req required />
                            <x-input-numeric title="cheque no" name="cheque_no" req required    />

                        </div>

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
        // const getMaster = @json(route('contracts.masterI'));
        const getMaster = @json(route('dutyclear.master'));

        const getDetails = @json(route('cis3.condet'));
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
        // let cominvsid='';

        let invoiceno= document.getElementById("invoiceno")
        // let machine_date= document.getElementById("machine_date")
        // let invoicedate= document.getElementById("invoicedate")

        // Bank Charges
        // let bankcharges= document.getElementById("bankcharges")
        // let collofcustom= document.getElementById("collofcustom")
        // let exataxoffie= document.getElementById("exataxoffie")
        // let lngnshipdochrgs= document.getElementById("lngnshipdochrgs")
        // let localcartage= document.getElementById("localcartage")
        // let miscexplunchetc= document.getElementById("miscexplunchetc")
        // let customsepoy= document.getElementById("customsepoy")
        // let weighbridge= document.getElementById("weighbridge")
        // let miscexpenses= document.getElementById("miscexpenses")
        // let agencychrgs= document.getElementById("agencychrgs")

        // let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        // var sconversionrate = document.getElementById("sconversionrate");
        var insurance = document.getElementById("insurance");
        // var otherchrgs = document.getElementById("otherchrgs");
        //  Add Event on  Page Load
        document.addEventListener('DOMContentLoaded',()=>{
            calculateButton.disabled = true
            submitButton.disabled = true
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){
                // if(conversionrate.value <= 0 || sconversionrate.value <= 0 )
                // {
                //     showSnackbar("Please add conversion rate before proceeding","error");
                //     conversionrate.focus();
                //     return;
                // }
                // if(insurance.value <= 0)
                // {
                //     showSnackbar("Please add insurance rate before proceeding","error");
                //     insurance.focus();
                //     return;
                // }

                if(!adopted)
                {
                    showModal()

                }
            }
        })
        // Calculate Bank Charges [ onblur ]

        function calculateBankCharges()
        {
            // var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) //+ parseFloat(otherchrgs.value)
            // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
            // banktotal.value = t.toFixed(2)
            // banktotal.value = 0
        }
    </script>
@endpush

@push('scripts')
    <script>
        window.onload = function() {
            var input = document.getElementById("gdno").focus();
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
                {title:"Machine No", field:"machineno" , responsive:0},
                {title:"Machine Date", field:"machine_date" , responsive:0},


                {title:"Invoice #", field:"invoiceno" , visible:true ,headerSort:false, responsive:0},
                {title:"Date", field:"invoice_date" , visible:true ,headerSort:false, responsive:0},
                {title:"Supplier", field:"supname", visible:true ,headerSort:false, responsive:0},

                {
                 title:'Com.Invs.Duty.Data', headerHozAlign:"center",
                 columns:[
                 {title:"PKG", field:"packingwt" , visible:true ,headerSort:false, responsive:0},
                 {title:"Weight", field:"tweight" , visible:true ,headerSort:false, responsive:0},
                 {title:"Duty", field:"tvalue" , visible:true ,headerSort:false, responsive:0},

                ]},

                {
                 title:'Pending Duty Clearance', headerHozAlign:"center",
                 columns:[
                 {title:"PKG Bal", field:"packingwtbal" , visible:true ,headerSort:false, responsive:0},
                 {title:"Weight", field:"pweight" , visible:true ,headerSort:false, responsive:0},
                 {title:"Duty", field:"ptvalue" , visible:true ,headerSort:false, responsive:0},

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

            // Fill Master Data

            // console.log(data.machine_date);
            invoiceno.value = data.invoiceno
            // invoicedate.value=data.invoicedate
            machineno.value = data.machineno
            machine_date.value=data.machine_date
            cominvsid.value = data.id

            // invoicedate = data.invoice_date->format('dd/mm/YYYY')

            //***********************
            // contract_id = data.contract_id
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

                        // const hscodes = @json($hscodes);
                        // // Hscode List
                        // var hscodeList=[]
                        // hscodes.forEach(e => {
                        //     hscodeList.push({ value:e.hscode, label:e.hscode, id:e.hscode})
                        // })
        // Locations List
        // var newList=[]
        // locations.forEach(e => {
        //     newList.push({value:e.title,label:e.title , id:e.id})
        // });
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

                // contract_id = obj.contract_id
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
                        // contract_id :       obj.contract_id,
                        material_id :       obj.material_id,
                        supplier_id :       obj.supplier_id,
                        user_id :           obj.user_id,
                        category_id :       obj.category_id,
                        sku_id :            obj.sku_id,
                        sku:                obj.sku,
                        // cominvsid:          obj.comer


                        // totpcs:             obj.totpcs,


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
                        hscode :            obj.hscode,

                        packing:    obj.packing,
                        packingwtbal:   obj.packingwtbal,
                        pcsbal: obj.pcsbal,


                        inkg :              vwinkg,
                        length :            0,
                        gdsprice :          obj.gdsprice,
                        dtyrate :           obj.dtyrate,
                        invsrate:           obj.invsrate,
                        amtindollar :       obj.purval  ,
                        dtyamtindollar :    obj.dtyamtindollar,
                        comamtindollar :    0,


                        bundle1        :    obj.bundle1,
                        pcspbundle1    :    obj.pcspbundle1 ,
                        bundle2        :    obj.bundle2 ,
                        pcspbundle2    :    obj.pcspbundle2 ,



                        // amtinpkr :          ( obj.gdswt *  obj.gdsprice  * conversionrate.value).toFixed(0),
                        dtyamtinpkr :        ( obj.gdswt *  obj.dtyrate  * conversionrate.value).toFixed(0),
                        comamtinpkr :        0,
                        itmratio:          0,
                        dtyitmratio:0,

                        insuranceperitem :  0,
                        dtyinsuranceperitem :  0,
                        dtyinsuranceperitemrs :  0,
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

                        cd       : obj.cd,
                        st       : obj.st,
                        rd       : obj.rd,
                        acd       : obj.acd,
                        ast       : obj.ast,
                        it       : obj.it,
                        wse      : obj.wse






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
                if(conversionrate.value <= 0)
                {
                    showSnackbar("conversionrate must be greater than 0","error");
                    conversionrate.focus();
                    return;
                }

                if(gdno.value === '' )
                {
                    showSnackbar("GD # required ","error");
                    gdno.focus();
                    return;
                }

            // calculateBankCharges()
            //  console.log($unt)
            // alert(dynamicTable.getData())
            const data = dynamicTable.getData()
            // Get Selected HSCode Value
            // var hscode;
            //  First Iteration to calculate Basic Data
            data.forEach(e => {



                var bundle1 = e.bundle1
                var pcspbundle1 = e.pcspbundle1
                var bundle2 = e.bundle2
                var pcspbundle2 = e.pcspbundle2


                var pcs = e.pcs
                var gdswt = e.gdswt
                var dutygdswt = e.dutygdswt
                var hscode = e.hscode

                var packing = e.packing
                var packingwtbal = e.packingwtbal
                var pcsbal = e.pcsbal





                var cd = e.cd
                var st = e.st
                var rd = e.rd
                var acd = e.acd
                var ast = e.ast
                var it = e.it
                var wse = e.wse

                var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
                var length = e.length
                var gdsprice = e.gdsprice
                var dtyrate = e.dtyrate
                var invsrate = e.invsrate
                var totpcs = e.totpcs
                var amtindollar=e.amtindollar
                var dtyamtindollar=e.dtyamtindollar
                var comamtindollar=e.comamtindollar

                // var amtinpkr=e.amtinpkr
                var dtyamtinpkr=e.dtyamtinpkr
                var comamtinpkr=e.comamtinpkr

                var dutval=e.dutval
                var purval=e.purval
                var comval=e.comval


                e.bundle1 =     bundle1
                e.pcspbundle1 = pcspbundle1
                e.bundle2 =     bundle2
                e.pcspbundle2 = pcspbundle2




                 e.pcs = pcs
                 e.gdswt = gdswt
                 e.inkg = inkg
                 e.length = length
                 e.dutygdswt=dutygdswt
                 e.hscode=hscode

                 e.packing=packing
                 e.packingwtbal=packingwtbal
                 e.pcsbal=pcsbal









                 e.cd =     cd
                 e.st =     st
                 e.rd =     rd
                 e.acd =    acd
                 e.ast =    ast
                 e.it =     it
                 e.wse =    wse
                 e.gdsprice = gdsprice
                 e.dtyrate = dtyrate
                 e.purval=purval
                 e.dutval=dutval
                 e.comval=comval
                //  e.amtinpkr=amtinpkr
                 e.dtyamtinpkr=dtyamtinpkr
                 e.comamtinpkr=comamtinpkr

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
                // if(e.sku_id==1)
                //    {
                //         // e.dutval = parseFloat(e.dutygdswt) * parseFloat(e.dtyrate)
                //         e.purval = parseFloat(e.gdswt) * parseFloat(e.gdsprice)
                //         // e.comval = parseFloat(e.gdswt) * parseFloat(e.invsrate)
                //    }
                //  else
                //      {
                //         //  e.dutval = parseFloat(e.pcs) * parseFloat(e.dtyrate)
                //          e.purval = parseFloat(e.pcs) * parseFloat(e.gdsprice)
                //          e.comval = parseFloat(e.pcs) * parseFloat(e.invsrate)
                //     }
                        // e.amtindollar=e.purval
                         e.dtyamtindollar=e.dutval
                        // e.dtyamtindollar=e.dtyamtindollar
                        // e.comamtindollar=e.comval

                        // e.amtinpkr=e.amtindollar * sconversionrate.value
                        e.dtyamtinpkr=e.dtyamtindollar * conversionrate.value
                        // e.comamtinpkr=e.comamtindollar * conversionrate.value

                // console.log(e.dtyamtinpkr)








                //   break
                ////////////////////////////////////////////////////////////////////////
                // Get Values of HSCode Selected in List and Populate Data
                ///////////////////////////////////////////////////////////////////////
                            // hscode = hscodes.find(  function(el) { return el.hscode === e.hscode })
                // e.cd = hscode.cd
                // e.st = hscode.st
                // e.rd = hscode.rd
                // e.acd = hscode.acd
                // e.ast = hscode.ast
                // e.it = hscode.it
                // e.wsc = hscode.wse

                                // var cd = hscode.cd
                                // var st = hscode.st
                                // var rd = hscode.rd
                                // var acd = hscode.acd
                                // var ast = hscode.ast
                                // var it = hscode.it
                // var wse = wse


                                    // e.cd=cd
                                    // e.st=st
                                    // e.rd=rd
                                    // e.acd=acd
                                    // e.ast=ast
                                    // e.it=it
                // e.wse=wse
            })

            //  Get Ratio after price/length/pcs update
            var amtinpkrtotal = 0
            var dtyamtinpkrtotal = 0

            data.forEach(e => {
                // amtinpkrtotal += parseFloat(e.amtinpkr)
                dtyamtinpkrtotal += parseFloat(e.dtyamtinpkr)
            });

            data.forEach(e => {

                var dtyamtinpkr = parseFloat(conversionrate.value) * parseFloat(e.dutval)
                // var amtinpkr = sconversionrate.value * e.purval

                //  var itmratio = amtinpkr / amtinpkrtotal * 100
                var dtyitmratio = (( parseFloat(dtyamtinpkr) / parseFloat(dtyamtinpkrtotal) ) * 100).toFixed(2)

                // var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var dtyinsuranceperitem =  ( parseFloat(insurance.value) * dtyitmratio / 100 ).toFixed(2)

                var dtyinsuranceperitemrs = ( ( parseFloat(insurance.value) * dtyitmratio / 100 ) * conversionrate.value ).toFixed(0)


                // var amountwithoutinsurance = (parseFloat(e.amtindollar) + parseFloat(insuranceperitem)) * parseFloat(conversionrate.value)
                var dtyamountwithoutinsurance = ( parseFloat(e.dtyamtindollar) + parseFloat(dtyinsuranceperitem) ) * parseFloat(conversionrate.value)


                // var onepercentdutypkr = amountwithoutinsurance * 0.01
                var dtyonepercentdutypkr = dtyamountwithoutinsurance * 0.01

                // var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)
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
                var total = cda + rda + sta + acda + asta + ita
                // var perft = (e.perpc / e.length).toFixed(2)
                // var totallccostwexp = total + dtypricevaluecostsheet + (banktotal.value * dtyitmratio / 100)
                // var totallccostwexp = total + amtinpkr + (banktotal.value * itmratio / 100)
                // var invlvlchrgs =(banktotal.value * itmratio / 100)
                // var otherexpenses = ( sconversionrate.value * otherchrgs.value ) * itmratio / 100
                // var perpc =  (( totallccostwexp+otherexpenses) / e.pcs).toFixed(2)


                // var perkg = (perpc / e.inkg).toFixed(2)
                // var qtyinfeet = (e.pcs * e.length).toFixed(2)







                e.amtindollar = e.purval
                // e.amtinpkr = amtinpkr
                // e.itmratio = itmratio
                e.dtyitmratio = dtyitmratio
                // e.insuranceperitem = insuranceperitem
                e.dtyinsuranceperitem = dtyinsuranceperitem
                e.dtyinsuranceperitemrs = dtyinsuranceperitemrs

                // e.invlvlchrgs=invlvlchrgs
                // e.amountwithoutinsurance = amountwithoutinsurance
                e.dtyamountwithoutinsurance = dtyamountwithoutinsurance
                // e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
                e.dtyonepercentdutypkr = (dtyonepercentdutypkr).toFixed(2)
                // e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)
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
                // e.perkg = perkg
                // e.totallccostwexp = totallccostwexp
                // e.perpc = perpc
                // e.perft = (perpc / parseFloat(e.length)  )
                // e.otherexpenses = otherexpenses
                // e.qtyinfeet = qtyinfeet

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

var updateValues = (cell) => {
        var data = cell.getData();
        // var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))

        var row = cell.getRow();
        row.update({
            //  "pcs": sum,
            // "gdspricetot": sum2,
            // "gdspricedtytot":sum3

        });
    }






        dynamicTable = new Tabulator("#dynamicTable", {
            height:"550px",
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
                {title:"S.No",            field:"sno", formatter:"rownum",responsive:0},
                {title:"Id",           field:"id", visible:false},
                {title:"Packaging Type",     field:"packing",responsive:0},
                {title:"supplier_id",  field:"supplier_id",visible:false},

                {
                    title:'Quantity', headerHozAlign:"center",
                    columns:[
                        // {title: "id",field: "myid",visible:false},
                        // {   title:"Location",headerHozAlign :'center',
                        //     field:"location" ,
                        //     editor:"list",
                        //     responsive:0 ,
                        //     headerVertical:true,
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     editorParams:   {
                        //         values:newList,
                        //         validator:["required"]
                        //     }
                        // },
                        {   title:"HS code",headerHozAlign :'center',
                            field:"hscode",
                            // editor:"list",
                            width:120,
                            responsive:0,
                            headerVertical:true,
                            // cssClass:"bg-green-200 font-semibold",
                            // editorParams:   {
                            //     values:hscodeList,
                            //     validator:["required"]
                            // }
                        },

                        {   title:"Nos Of Bundles",headerHozAlign :'center',
                            width:80,
                            responsive:0,
                            field:"packingwtbal",
                            editor:"number",
                            headerVertical:true,
                            bottomCalc:"sum",
                            formatter:"money",
                            // cellEdited: updateValues,
                            validator:["required","numeric"],
                            cssClass:"bg-green-200 font-semibold",
                            formatterParams:{thousand:",",precision:0},
                        },

                        // {   title:"Pcs/Bund",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"pcspbundle1",
                        //     headerVertical:true,
                        //     // bottomCalc:"sum",
                        //     formatter:"money",
                        //     cellEdited: updateValues,
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        // {   title:"Bundle2",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"bundle2",
                        //     editor:"number",
                        //     cellEdited: updateValues,
                        //     headerVertical:true,
                        //     bottomCalc:"sum",
                        //     formatter:"money",
                        //      cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        // {   title:"Pcs/Bund",headerHozAlign :'center',
                        //     responsive:0,
                        //     field:"pcspbundle2",
                        //     // editor:"number",
                        //     headerVertical:true,
                        //     cellEdited: updateValues,
                        //     // bottomCalc:"sum",
                        //     formatter:"money",
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     validator:["required","numeric"],
                        //     formatterParams:{thousand:",",precision:0},
                        // },

                        {   title:"Pcs",headerHozAlign :'center',
                            width:120,
                            responsive:0,
                            field:"pcsbal",
                            // editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            visible:false,
                            // cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:0},
                            formatter:function(cell,row)
                            {
                                // return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)
                            },bottomCalc:"sum",


                        },

                        {   title:"Duty.Wt(Kg)",
                            field:"dutygdswt",
                            width:120,
                            responsive:0,
                            bottomCalc:"sum",
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            // cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },

                        {   title:"Duty.Price($)",
                            field:"dtyrate",
                            headerVertical:true,
                            formatter:"money",
                            editor:"number",
                            width:120,
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },

                        {   title:"Duty.Val($)",
                            field:"dtyamtindollar",
                            width:150,
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Duty.Val(Rs)",
                            field:"dtyamtinpkr",
                            width:150,
                            responsive:0,
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            // bottomCalcFormatter:"money",
                            formatterParams:{thousand:",",precision:0},
                        },




                        // {   title:"Wt(pcs/kg)",
                        //     field:"inkg",
                        //     responsive:0,
                        //     headerVertical:true,
                        // },

                        // {   title:"Lng(pcs/feet)",
                        //     field:"length",
                        //     headerVertical:true,
                        //     editor:"number",
                        //     formatter:"money",
                        //     responsive:0,
                        //     formatterParams:{thousand:",",precision:2},
                        //     validator:["required","numeric"],
                        //     bottomCalcParams:{precision:2}  ,
                        // },

                        // {   title:"QtyInFeet",
                        //     field:"qtyinfeet",
                        //     headerVertical:true,
                        //     // cssClass:"bg-green-200 font-semibold",
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     responsive:0,
                        //     formatterParams:{thousand:",",precision:0},
                        //     validator:["required","numeric"],
                        //     bottomCalcParams:{precision:0}  ,
                        // },


                    ]
                },

                {   title:"Item Ratio(%)",
                            field:"dtyitmratio",
                            width:100,
                            responsive:0,

                            bottomCalc:"sum",bottomCalcParams:{precision:0},
                            headerVertical:true,
                            formatter:"money",
                            formatterParams:{thousand:",",precision:2},
                },

                {
                    title:"Insurance/Item($)",
                    field:"dtyinsuranceperitem",
                    width:100,
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },
                {
                    title:"Insurance/Item(Rs)",
                    field:"dtyinsuranceperitemrs",
                    width:100,
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },

                {
                    title:"Amt W/Insurance (Rs)",
                    field:"dtyamountwithoutinsurance",
                    width:100,
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },
                 {
                    title:"1% Duty (PKR)",
                    field:"dtyonepercentdutypkr",
                    width:100,
                    responsive:0,
                    bottomCalc:"sum",bottomCalcParams:{precision:0},
                    headerVertical:true,
                    formatter:"money",
                },


                {title:"WSE",  field:"wse",   formatter:"money",editor:"number",
                        formatterParams:{thousand:",",precision:2}, visible:false},
                        //]},

                // {
                //     title:'Price',
                //     columns:[
                //         {   title:"Supp.Price($)",
                //             field:"gdsprice",
                //             formatter:"money" ,
                //             // editor:"number",
                //             responsive:0,
                //             headerVertical:true,
                //             // cssClass:"bg-green-200 font-semibold",
                //             validator:["required","numeric"],
                //             formatterParams:{thousand:",",precision:2}
                //         },

                //     ]
                // },

                 {
                    title:'Amount', headerHozAlign:"center",
                    columns:[
                        // {   title:"Supp.Val($)",
                        //     field:"amtindollar",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        // },
                        // {   title:"Supp.Val(Rs)",
                        //     field:"amtinpkr",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:0},
                        // },






                        // {   title:"Com.Invs.Price",
                        //     field:"invsrate",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     editor:"number",
                        //     formatter:"money",
                        //     // bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        // },

                        // {   title:"Com.Invs.Val($)",
                        //     field:"comamtindollar",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //      bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:2},
                        // },

                        // {   title:"Com.Invs.Val(Rs)",
                        //     field:"comamtinpkr",
                        //     responsive:0,
                        //     headerVertical:true,
                        //     formatter:"money",
                        //      bottomCalc:"sum",bottomCalcParams:{precision:0},
                        //     // bottomCalcFormatter:"money",
                        //     formatterParams:{thousand:",",precision:0},
                        // },




                        {title:"CD",                field:"cda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"ST",                field:"sta", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"RD",                field:"rda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},             responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"ACD",               field:"acda", formatter:"money",
                        formatterParams:{thousand:",",precision:0},            responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"AST",               field:"asta",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},           responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"IT",                field:"ita",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},            responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"WSE",visible:false,               field:"wsca",  formatter:"money",
                        formatterParams:{thousand:",",precision:0},           responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},
                            {title:"Total Duty", cssClass:"bg-green-200 font-semibold",  field:"total", headerVertical:true,  formatter:"money",formatterParams:{thousand:",",precision:0},
                         responsive:0,width:120,bottomCalc:"sum",bottomCalcParams:{precision:0}},



                // {
                //     title:"Invoice Level Exp.",
                //     headerVertical:true,
                //     field:"invlvlchrgs",
                //     cssClass:"bg-green-200 font-semibold",
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     responsive:0,
                //     formatter:"money",
                //     formatterParams:{thousand:",",precision:0},
                // },




                // {
                //     title:"Tot Cost(Rs)",
                //     headerVertical:true,
                //     field:"totallccostwexp",
                //     cssClass:"bg-green-200 font-semibold",
                //     bottomCalc:"sum",bottomCalcParams:{precision:0},
                //     responsive:0,
                //     formatter:"money",
                //     formatterParams:{thousand:",",precision:0},
                // },



                    ]
                },


                // {   title:"OtherExpFrPaym.",
                //             field:"otherexpenses",
                //             headerVertical:true,
                //             cssClass:"bg-green-200 font-semibold",
                //             formatter:"money",
                //             responsive:0,
                //             bottomCalc:"sum",bottomCalcParams:{precision:0},
                //             formatterParams:{thousand:",",precision:0},
                //             validator:["required","numeric"],
                //             bottomCalcParams:{precision:0}  ,
                //         },





                {title:"CD",                field:"cd",editor:"number",responsive:0,
                headerVertical:true,        visible:true},
                {title:"ST",                field:"st",editor:"number",responsive:0,
                headerVertical:true,          visible:true},
                {title:"RD",                field:"rd",editor:"number",responsive:0,
                headerVertical:true,        visible:true},
                {title:"ACD",               field:"acd",editor:"number",responsive:0,
                headerVertical:true,          visible:true},
                {title:"AST",               field:"ast",editor:"number",responsive:0,
                headerVertical:true,        visible:true},
                {title:"IT",                field:"it",editor:"number",responsive:0,
                headerVertical:true,        visible:true},
                // {title:"WSE",               field:"wse",
                // headerVertical:true,         visible:true},


                // {
                //     title:'Cost Rate/Unit', headerHozAlign:"center",
                //     columns:[
                //         {title:"Per Pc",    field:"perpc",         responsive:0 ,formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //         {title:"Per Kg",    field:"perkg",         responsive:0 , formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //         {title:"Per Feet",  field:"perft",       responsive:0 ,formatter:"money",
                //             formatterParams:{thousand:",",precision:2}, },
                //     ]
                // },
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

            // var invoicedate = document.getElementById("invoicedate")
            var invoiceno = document.getElementById("invoiceno")
            var gdno = document.getElementById("gdno")
            var machineno = document.getElementById("machineno")
            var cominvsid = document.getElementById("cominvsid")

            // var machine_date = document.getElementById("machine_date")
            var conversionrate = document.getElementById("conversionrate")

            var sid = document.getElementById("bank_id");
            var bank_id = sid.options[sid.selectedIndex];

            if(bank_id.value <= 0)
            {
                showSnackbar("Please select From Bank");
                bank_id.focus();
                return;
            }





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

            if(gdno.value === ''){
                showSnackbar("GD # required ","error");
                gdno.focus()
                return;
            }

            if(conversionrate.value === ''){
                showSnackbar("conversionrate # required ","error");
                conversionrate.focus()
                return;
            }



            const dynamicTableData = dynamicTable.getData();
            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }

            // for (let index = 0; index < dynamicTableData.length; index++) {
            //     const element = dynamicTableData[index];

            //     if(element.location === undefined)
            //     {
            //         showSnackbar("Location must be Enter","info");
            //         return;
            //     }
            // }

            // disableSubmitButton(true);
            var data = {
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                // 'sconversionrate' : parseFloat(sconversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                // 'contract_id' : contract_id,
                'cominvsid':cominvsid.value,
                'invoiceno' : invoiceno.value,
                // 'challanno' : challanno.value,
                'machineno' : machineno.value,
                // 'machine_date' :machine_date.value,
                'invoice_date' : invoice_date.value,
                'gdno' : gdno.value,
                'gd_date' : gd_date.value,
                'dunitid' : parseFloat(dunitid.value).toFixed(0),
                'cheque_no' : cheque_no.value,
                'cheque_date' :cheque_date.value,
                'bank_id' :bank_id.value,


                // 'total' : parseFloat(banktotal.value).toFixed(2),

                'comminvoice' : dynamicTableData

            };
            // All Ok - Proceed
            fetch(@json(route('clearance.store')),{
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
                    window.open(window.location.origin + "/clearance","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }



//    *********************** For Search List Box

const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

myarray=@json($resultArray);
const contries = myarray;
function onkeyUp(e)
{
    let keyword= e.target.value;
    var bank_id = document.getElementById("bank_id");
    bank_id.classList.remove("hidden");

    let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));
    console.log(filteredContries);
    renderOptions(filteredContries);

}


document.addEventListener('DOMContentLoaded',()=> {
    hidedropdown();
        });

function renderOptions(xyz){

    let dropdownEl=document.getElementById("bank_id");

                dropdownEl.length = 0
                xyz.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.title)
                });
}

document.addEventListener("click" , () => {
    hidedropdown();
});


function hidedropdown()
{
    var bank_id = document.getElementById("bank_id");
    bank_id.classList.add("hidden");
}


bank_id.addEventListener("click", () => {

    let bank_id= document.getElementById("bank_id");
    let input= document.getElementById("autocompleted");
    input.value=bank_id.options[bank_id.selectedIndex].text;
    hidedropdown();
});


bank_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
event.preventDefault();

let bank_id= document.getElementById("bank_id");
    let input= document.getElementById("autocompleted");
    input.value=bank_id.options[bank_id.selectedIndex].text;
    hidedropdown();

}
});






    </script>
@endpush

</x-app-layout>
