<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Commercial Invoice
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

                                <x-input-date title="Inv. Date" name="invoicedate" req required class="col-span-2"/>

                                <x-input-text title="Invoice #" name="invoiceno" req required class=""/>
                                <x-input-text title="Challan #" name="challanno" req required class=""/>

                                <x-input-numeric title="Conv. Rate" name="conversionrate"  req required class=""/>
                                <x-input-numeric title="Insurance" name="insurance"  req required class=""/>
                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                <x-input-date title="G.D Date" name="machine_date" req required class="col-span-2"/>
                                <x-input-text title="G.D #" name="machineno" req required class="col-span-2"/>

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
                                <x-input-numeric title="Other Chgs ($)" name="otherchrgs" required  onblur="calculateBankCharges()"/>
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
     //   let otherchrgs= document.getElementById("otherchrgs")
        let banktotal= document.getElementById("banktotal")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
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
                if(conversionrate.value <= 0)
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
                {title:"Id", field:"id" , responsive:0},
                {title:"Invoice #", field:"number" , visible:true ,headerSort:false, responsive:0},
                {title:"Supplier", field:"supplier.title" , visible:true ,headerSort:false, responsive:0},
            ],
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
                const hsc = mat['hscodes']

                contract_id = obj.contract_id

                // console.log(obj.bundle1 , obj.pcspbundle1 ,obj.bundle2 , obj.pcspbundle2);
                var vpcs = ((obj.bundle1 * obj.pcspbundle1) + (obj.bundle2 * obj.pcspbundle2)).toFixed(2)
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
                        dimension_id :      obj.dimension_id,
                        source_id :         obj.source_id,
                        brand_id :          obj.brand_id,

                        pcs :               vpcs,
                        // gdswt :             obj.gdswt * 1000,
                        gdswt :             obj.gdswt ,
                        inkg :              vwinkg,
                        length :            0,

                        // gdsprice :          obj.gdsprice/1000,
                        gdsprice :          obj.gdsprice,

                        // dtyrate :          obj.dtyrate/1000,
                        dtyrate :          obj.dtyrate,

                        amtindollar :       obj.gdswt * obj.gdsprice ,
                        dtyamtindollar :       obj.gdswt * obj.dtyrate,

                        amtinpkr :          ( obj.gdswt *  obj.gdsprice  * conversionrate.value).toFixed(0),
                        dtyamtinpkr :        ( obj.gdswt *  obj.dtyrate  * conversionrate.value).toFixed(0),

                        itmration:          0,

                        insuranceperitem :  0,
                        amountwithoutinsurance : 0,
                        onepercentdutypkr : 0,
                        pricevaluecostsheet : 0,

                        hscode :            hsc.hscode,
                        cd :                hsc.cd,
                        st :                hsc.st,
                        rd :                hsc.rd,
                        acd :               hsc.acd,
                        ast :               hsc.ast,
                        it :                hsc.it,
                        wsc :               hsc.wse,

                        totallccostwexp:    0,
                        perpc:              0,
                        perkg:              0,
                        perft:            0,
                        otherexpenses:    0,
                        qtyinfeet:0,
                        tmpcda : 0,

                    }
                ])
            }
        }
        var calculate = function(){
            calculateBankCharges()
            // alert(dynamicTable.getData())
            const data = dynamicTable.getData()
            //  First Iteration to calculate Basic Data
            data.forEach(e => {



                var pcs = e.pcs
                var gdswt = e.gdswt
                var inkg = ((e.gdswt / e.pcs ) ).toFixed(3)
                var length = e.length
                var gdsprice = e.gdsprice
                var dtyrate = e.dtyrate

                var tmpcda = e.tmpcda
                //  update data element




                e.pcs = pcs
                e.gdswt = gdswt
                e.inkg = inkg
                e.length = length
                e.gdsprice = gdsprice
                e.dtyrate = dtyrate
            })
            //  Get Ratio after price/length/pcs update
            var amtinpkrtotal = 0
            var dtyamtinpkrtotal = 0
            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                dtyamtinpkrtotal += parseFloat(e.dtyamtinpkr)
            });



            data.forEach(e => {
                var dtyamtinpkr = conversionrate.value * e.dtyrate * e.gdswt
                var amtinpkr = conversionrate.value * e.gdsprice * e.gdswt


                var itmratio = amtinpkr / amtinpkrtotal * 100
                var dtyitmratio = dtyamtinpkr / dtyamtinpkrtotal * 100

                var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var dtyinsuranceperitem = parseFloat(insurance.value) * dtyitmratio / 100

                var amountwithoutinsurance = ( e.amtindollar + insuranceperitem ) * parseFloat(conversionrate.value)
                var dtyamountwithoutinsurance = ( e.dtyamtindollar + dtyinsuranceperitem ) * parseFloat(conversionrate.value)


                var onepercentdutypkr = amountwithoutinsurance * 0.01
                var dtyonepercentdutypkr = dtyamountwithoutinsurance * 0.01

                var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)
                var dtypricevaluecostsheet = parseFloat(dtyonepercentdutypkr + dtyamountwithoutinsurance)

                var cda = e.cd * dtypricevaluecostsheet / 100
                var tmpcda =  dtyamtinpkrtotal
                var rda = e.rd * dtypricevaluecostsheet / 100
                var acda = e.acd * dtypricevaluecostsheet / 100
                var sta = (dtypricevaluecostsheet + cda + rda + acda) * e.st / 100
                var asta = (dtypricevaluecostsheet + cda + rda + acda) * e.ast / 100
                var ita =(dtypricevaluecostsheet + cda + sta + rda + acda + asta) * e.it / 100
                var wsca = (dtypricevaluecostsheet * e.wsc) /100
                var total = cda + rda + sta + acda + asta + ita + wsca
                var perft = (e.perpc / e.length).toFixed(2)
                var totallccostwexp = total + dtypricevaluecostsheet + (banktotal.value * dtyitmratio / 100)
                var otherexpenses = ( conversionrate.value * otherchrgs.value ) * dtyitmratio / 100
                var perpc = (( totallccostwexp+otherexpenses) / e.pcs).toFixed(2)
                var perkg = (perpc / e.inkg).toFixed(2)
                var qtyinfeet = (e.pcs * e.length).toFixed(2)


                e.amtindollar = e.gdswt * e.gdsprice
                e.amtinpkr = amtinpkr
                e.itmratio = itmratio
                e.insuranceperitem = insuranceperitem
                e.amountwithoutinsurance = amountwithoutinsurance
                e.onepercentdutypkr = (onepercentdutypkr).toFixed(2)
                e.pricevaluecostsheet = (pricevaluecostsheet).toFixed(2)
                e.tmpcda = (tmpcda).toFixed(2)
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
                e.perft = (perpc / e.length )
                e.otherexpenses = otherexpenses
                e.qtyinfeet = qtyinfeet

                // e.inkg = inkg
            })
            dynamicTable.setData(data)
            submitButton.disabled = false
        }
        //  Dynamic Table [User data]
        dynamicTable = new Tabulator("#dynamicTable", {
            layout:'fitDataTable',
            responsiveLayout:"collapse",
            reactiveData:true,
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                    }
                },
                {title:"Id",           field:"id", visible:false},
                {title:"Material",     field:"material_title"},
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
                    {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                            values:newList,
                            cssClass:"bg-green-200 font-semibold",
                            validator:["required"]
                        }
                    },







                    {   title:"Pcs",headerHozAlign :'center',
                            responsive:0,
                            field:"pcs",
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Wt(Kg)",
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

                        {   title:"QtyInFeet",
                            field:"qtyinfeet",
                            headerVertical:true,
                          //  editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },




                        {   title:"Other.Exp(pkr)",
                            field:"otherexpenses",
                            headerVertical:true,
                          //  editor:"number",
                            cssClass:"bg-green-200 font-semibold",
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
                            editor:"number",
                            responsive:0,
                            headerVertical:true,
                            cssClass:"bg-green-200 font-semibold",
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

                        {   title:"dutyrate",
                            field:"dtyrate",
                            headerVertical:true,
                            // editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:6}  ,
                        },
                        {   title:"tmpcdaa",
                            field:"tmpcda",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },





                        {   title:"CDRate",
                            field:"cd",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"STRate",
                            field:"st",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"RDRate",
                            field:"rd",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"ACDRate",
                            field:"acd",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },

                        {   title:"ASTRate",
                            field:"ast",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"ITRate",
                            field:"it",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
                        },
                        {   title:"WSCRate",
                            field:"wsc",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:2},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:2}  ,
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
                        {title:"Code",              field:"hscode",
                        headerVertical:true,       visible:true},


                        {title:"CD",                field:"cd",
                        headerVertical:true,        visible:false},
                        {title:"ST",                field:"st",
                        headerVertical:true,          visible:false},
                        {title:"RD",                field:"rd",
                        headerVertical:true,        visible:false},
                        {title:"ACD",               field:"acd",
                        headerVertical:true,          visible:false},
                        {title:"AST",               field:"ast",
                        headerVertical:true,        visible:false},
                        {title:"IT",                field:"it",
                        headerVertical:true,        visible:false},
                        {title:"WSC",               field:"wsc",
                        headerVertical:true,         visible:false},
                    ]
                },
                {
                    title:'Duties Amount (PKR)', headerHozAlign:"center",
                    columns:[
                 //       {title:"CDrate",                field:"cdrt", formatter:"money",
                 //   formatterParams:{thousand:",",precision:2},             responsive:0},


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
                    responsive:1,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },
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
            var challanno = document.getElementById("challanno")
            var machineno = document.getElementById("machineno")
            var machine_date = document.getElementById("machine_date")

            if(invoiceno.value === ''){
                showSnackbar("Invoice # required ","error");
                invoiceno.focus()
                return;
            }
            if(challanno.value === ''){
                showSnackbar("challanno # required ","error");
                challanno.focus()
                return;
            }
            if(machineno.value === ''){
                showSnackbar("machineno # required ","error");
                challanno.focus()
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
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'contract_id' : contract_id,
                'invoiceno' : invoiceno.value,
                'challanno' : challanno.value,
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
