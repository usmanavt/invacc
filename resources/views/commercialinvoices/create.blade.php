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

                                <x-input-date title="Invoice Date" name="invoicedate" req required class="col-span-2"/>

                                <x-input-text title="Invoice #" name="invoiceno" req required class="col-span-2"/>
                                <x-input-text title="Challan #" name="challanno" req required class="col-span-2"/>

                            </div>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Conversion Rate" name="conversionrate"  req required class="col-span-2"/>
                                <x-input-numeric title="Insurance" name="insurance"  req required class="col-span-2"/>

                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Invoice Level Expenses</legend>
                            <div class="grid grid-cols-12 gap-2 py-2 items-center">

                                <x-input-numeric title="Bank Chrgs" name="bankcharges"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Cust Coll" name="collofcustom"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ex Tax of" name="exataxoffie"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Ship Doc Chg" name="lngnshipdochrgs"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Lcl Cartage" name="localcartage"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp Lunch" name="miscexplunchetc"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Custom Sepoy" name="customsepoy"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Weigh Bridge" name="weighbridge"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Misc Exp" name="miscexpenses"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Agency Chgs" name="agencychrgs"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Other Chgs" name="otherchrgs"  req required  onblur="calculateBankCharges()"/>
                                <x-input-numeric title="Total" name="total" disabled />

                            </div>
                        </fieldset>

                        {{-- Contract Details --}}
                        <x-tabulator-dynamic />

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button
                                id="submitbutton" onclick="validateForm()"
                                class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1 w-28 text-center">
                                <i class="fa fa-save fa-fw"></i>
                                Submit
                            </button>
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
        const getMaster = @json(route('cis.condet'));
        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        let modal = document.getElementById("myModal")
        console.log(getMaster);

        let dyanmicTable = ""; // Tabulator
        let dynamicTableData = [];
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
        let total= document.getElementById("total")
        // Important Rates
        var conversionrate = document.getElementById("conversionrate");
        var insurance = document.getElementById("insurance");

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
                showModal()
            }
        })
        // Calculate Bank Charges
        function calculateBankCharges()
        {
            var t =  parseFloat(bankcharges.value) + parseFloat(collofcustom.value) + parseFloat(exataxoffie.value) + parseFloat(lngnshipdochrgs.value) + parseFloat(localcartage.value) + parseFloat(miscexplunchetc.value) + parseFloat(customsepoy.value) + parseFloat(weighbridge.value) + parseFloat(miscexpenses.value) + parseFloat(agencychrgs.value) + parseFloat(otherchrgs.value)
            // var t = parseFloat(bankcharges.value) + parseFloat(collofcustom.value)
            total.value = t.toFixed(3)
            console.log(total.value);
        }
        // Ensure Buttons Are Closed
        function disableSubmitButton()
        {
            if(dynamicTableData.length <= 0 )
            {
                document.getElementById("submitbutton").disabled = true;
            }else {
                document.getElementById("submitbutton").disabled = false;
            }
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
        //  ------------------Dynamic Table----------------------//
        //  Adds actual data to row
        function pushDynamicData(data)
        {
            var inArray = dynamicTableData.filter( i => dynamicTableData.id == data.id)
            // console.log(inArray);

            dynamicTableData.push({ id:data.id,material:data.material_title})

            var vpcs = (data.bundle1 * data.pcspbundle1) + (data.bundle2 * data.pcspbundle2).toFixed(2)
            var vgdswt = data.gdswt
            var vwinkg = ((vgdswt / vpcs ) * 1000).toFixed(3)

            dynamicTable.addData([
                {
                    id:data.id,
                    material_title:data.material.title,
                    contract_id:data.contract_id,
                    material_id:data.material_id,
                    supplier_id:data.supplier_id,
                    user_id:data.user_id,
                    category_id:data.category_id,
                    sku_id:data.sku_id,
                    dimension_id:data.dimension_id,
                    source_id:data.source_id,
                    brand_id:data.brand_id,

                    pcs:vpcs,
                    gdswt:vgdswt,
                    inkg:vwinkg,
                    gdsprice:data.gdsprice,
                    amtindollar: data.gdswt * data.gdsprice ,
                    amtinpkr: ( data.gdswt *  data.gdsprice )* parseFloat(conversionrate.value),

                    hscode:data.material.hscodes.hscode,
                    cd:data.material.hscodes.cd,
                    st:data.material.hscodes.st,
                    rd:data.material.hscodes.rd,
                    acd:data.material.hscodes.acd,
                    ast:data.material.hscodes.ast,
                    it:data.material.hscodes.it,
                    wsc:data.material.hscodes.wse,

                    length:0,
                    itmratio:0,
                    insuranceperitem:0,
                    amountwithoutinsurance:0,
                    onepercentdutypkr:0,
                    pricevaluecostsheet:0,
                }
            ])
        }
    </script>
@endpush

@push('scripts')
    <script>
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
                {title:"ContID", field:"contract_id" , visible:true ,headerSort:false, responsive:0},
                {title:"MatID", field:"material_id" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
                {title:"Title", field:"material_title" ,  responsive:0},
                {title:"Category", field:"category" ,  responsive:0},
                {title:"Sku", field:"sku" ,  responsive:0},
                {title:"Brand", field:"brand" ,  responsive:0},
                // {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
                //     cellClick:function(e, cell){
                //         // window.open(window.location + "/" + cell.getRow().getData().id + "/delete" ,"_self");
                //     }
                // },
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
        //  Adds New row to dyanmicTable
        table.on('rowClick',function(e,row){
            var simple = {...row}
            var data = simple._row.data
            // console.log(data);
            //  Filter Data here .
            var result = dynamicTableData.filter( dt => dt.id == data.id)
            if(result.length <= 0)
            {
                pushDynamicData(data)
            }
        })
        //  customCount (Abbu Function)
        var customCalc = function(values, data, calcParams){
            //values - array of column values
            //data - all table data
            //calcParams - params passed from the column definition object
            var amtinpkrtotal = 0
            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                // console.log(amtinpkrtotal);
            });
            data.forEach(e => {
                var itmratio = e.amtinpkr / amtinpkrtotal * 100
                var insuranceperitem = parseFloat(insurance.value) * itmratio / 100
                var amountwithoutinsurance = ( e.amtindollar + insuranceperitem ) * parseFloat(conversionrate.value)
                var onepercentdutypkr = amountwithoutinsurance * 0.01
                var pricevaluecostsheet = parseFloat(onepercentdutypkr + amountwithoutinsurance)
                var cda = e.cd * pricevaluecostsheet / 100
                var rda = e.rd * pricevaluecostsheet / 100
                var acda = e.acd * pricevaluecostsheet / 100
                var sta = (pricevaluecostsheet + cda + rda + acda) * e.st / 100
                var asta = (pricevaluecostsheet + cda + rda + acda) * e.ast / 100
                var ita =(pricevaluecostsheet + cda + sta + rda + acda + asta) * e.it / 100
                var wsca = pricevaluecostsheet / e.wsc
                var total = cda + rda + sta + acda + asta + ita + wsca
                var perpc = total / e.pcs
                e.itmratio = itmratio
                e.insuranceperitem = insuranceperitem
                e.amountwithoutinsurance = parseFloat(amountwithoutinsurance).toFixed(2)
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
                e.perpc = (perpc).toFixed(2)
                e.perkg = (perpc / e.inkg).toFixed(2)
                e.perfeet = (length == 0 ? length: perpc / length).toFixed(2)
            })
        }
        //  Dynamic Table [User data]
        dynamicTable = new Tabulator("#dynamicTable", {
            layout:'fitDataTable',
            // data:dynamicTableData,
            responsiveLayout:"collapse",
            reactiveData:true,
            columns:[
                {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
                    cellClick:function(e, cell){
                        cell.getRow().delete();
                        dynamicTableData = dynamicTable.getData(); // Ensure that our data is clean
                        dynamicTable.redraw();
                        // disableSubmitButton();
                    }
                },
                {title:"Id",                field:"id", visible:false,            cssClass:"bg-gray-200 font-semibold"},
                {title:"Material",          field:"material_title", cssClass:"bg-gray-200 font-semibold"},
                {title:"contract_id",       field:"contract_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"material_id",       field:"material_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"supplier_id",       field:"supplier_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"user_id",           field:"user_id",        cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"sku_id",            field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"dimension_id",      field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"source_id",         field:"source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
                {title:"brand_id",          field:"brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
                {
                    title:'Quantity', headerHozAlign:"center",
                    columns:[
                        {   title:"Pcs",headerHozAlign :'center',
                            field:"pcs",
                            editor:"number",
                            headerVertical:true,
                            formatter:"money",
                            cssClass:"bg-green-200 font-semibold",
                            validator:["required","numeric"],
                            formatterParams:{thousand:",",precision:2},
                        },
                        {title:"Wt(mt)",            field:"gdswt",
                        headerVertical:true,         cssClass:"bg-gray-200 font-semibold"},
                        {title:"Wt(pcs/kg)",        field:"inkg", responsive:0,
                        headerVertical:true,        cssClass:"bg-gray-200 font-semibold"},
                        {   title:"Lng(pcs/feet)",
                            field:"length",
                            headerVertical:true,
                            editor:"number",
                            cssClass:"bg-green-200 font-semibold",
                            formatter:"money",
                            responsive:0,
                            formatterParams:{thousand:",",precision:3},
                            validator:["required","numeric"],
                            bottomCalcParams:{precision:3}  ,
                            cellEdited:function(cell){
                                var data = cell.getData();
                                var sum = Number(data.perpc) / Number(data.length)
                                var row = cell.getRow();
                                row.update({
                                    "perfeet": sum
                                });
                            }
                        },
                    ]
                },
                {
                    title:'Price',
                    columns:[
                        {title:"$/Ton",            field:"gdsprice",          cssClass:"bg-gray-200 font-semibold",formatter:"money" , formatterParams:{thousand:",",precision:2}},
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
                            formatterParams:{thousand:",",precision:2},
                        },
                        {   title:"Item Ratio(%)",
                            field:"itmratio",
                            headerVertical:true,
                            formatter:"money",
                            bottomCalc:customCalc,
                            formatterParams:{thousand:",",precision:2},
                        },
                    ]
                },
                {
                    title:"Insur/Item",
                    field:"insuranceperitem",
                    headerVertical:true,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },
                {
                    title:"Amt W/Insur (PKR)",
                    field:"amountwithoutinsurance",
                    headerVertical:true,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
                },
                {
                    title:"1% Duty (PKR)",
                    field:"onepercentdutypkr",
                    headerVertical:true,
                    formatter:"money",
                    formatterParams:{thousand:",",precision:2},
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
                        headerVertical:true,      cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"CD",                field:"cd",
                        headerVertical:true,       cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"ST",                field:"st",
                        headerVertical:true,         cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"RD",                field:"rd",
                        headerVertical:true,       cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"ACD",               field:"acd",
                        headerVertical:true,         cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"AST",               field:"ast",
                        headerVertical:true,       cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"IT",                field:"it",
                        headerVertical:true,       cssClass:"bg-gray-200 font-semibold", visible:false},
                        {title:"WSC",               field:"wsc",
                        headerVertical:true,        cssClass:"bg-gray-200 font-semibold", visible:false},
                    ]
                },
                {
                    title:'Duties Amount (PKR)', headerHozAlign:"center",
                    columns:[
                        {title:"CD",                field:"cda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},            cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"ST",                field:"sta", formatter:"money",
                    formatterParams:{thousand:",",precision:2},            cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"RD",                field:"rda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},            cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"ACD",               field:"acda", formatter:"money",
                    formatterParams:{thousand:",",precision:2},           cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"AST",               field:"asta",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},          cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"IT",                field:"ita",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},           cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"WSC",               field:"wsca",  formatter:"money",
                    formatterParams:{thousand:",",precision:2},          cssClass:"bg-gray-200 font-semibold", responsive:0},
                        {title:"Total",             field:"total",   formatter:"money",
                    formatterParams:{thousand:",",precision:2},         cssClass:"bg-gray-200 font-semibold", responsive:0},
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
                        {title:"Per Pc",    field:"perpc",         cssClass:"bg-gray-200 font-semibold", responsive:0 ,formatter:"money",
                    formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Kg",    field:"perkg",         cssClass:"bg-gray-200 font-semibold", responsive:0 , formatter:"money",
                    formatterParams:{thousand:",",precision:2}, },
                        {title:"Per Feet",  field:"perfeet",       cssClass:"bg-gray-200 font-semibold", responsive:0 ,formatter:"money",
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
            var challanno = document.getElementById("challanno")

            // var bankcharges  = document.getElementById("bankcharges")
            // var collofcustom  = document.getElementById("collofcustom")
            // var exataxoffie  = document.getElementById("exataxoffie")
            // var lngnshipdochrgs  = document.getElementById("lngnshipdochrgs")
            // var localcartage  = document.getElementById("localcartage")
            // var miscexplunchetc  = document.getElementById("miscexplunchetc")
            // var customsepoy  = document.getElementById("customsepoy")
            // var weighbridge  = document.getElementById("weighbridge")
            // var miscexpenses  = document.getElementById("miscexpenses")
            // var agencychrgs  = document.getElementById("agencychrgs")
            // var otherchrgs  = document.getElementById("otherchrgs")

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

            // if ( bankcharges.value <= 0 || collofcustom.value <= 0 || exataxoffie.value <= 0 || lngnshipdochrgs.value <= 0 || localcartage.value <= 0 || miscexplunchetc.value <= 0 || customsepoy.value <= 0 || weighbridge.value <= 0 || miscexpenses.value <= 0 || agencychrgs.value <= 0 || otherchrgs <= 0 )
            // {
            //     showSnackbar("Please provide value of Invoice Level Expenses other then '0' ","error");
            //     return;
            // }

            if(dynamicTableData.length == 0)
            {
                showSnackbar("You must have atleast 1 row of item to Proceed","info");
                return;
            }
            dynamicTableData = dynamicTable.getData();
            disableSubmitButton(true);
            var data = {
                'conversionrate' : parseFloat(conversionrate.value).toFixed(2),
                'insurance' : parseFloat(insurance.value).toFixed(2),
                'invoiceno' : invoiceno.value,
                'challanno' : challanno.value,
                'invoicedate' : parseFloat(invoicedate.value).toFixed(2),
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
                'total' : parseFloat(total.value).toFixed(2),
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
                disableSubmitButton(false);
            })
        }
    </script>
@endpush

</x-app-layout>
