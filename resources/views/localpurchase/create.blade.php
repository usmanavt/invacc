<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Local Purchasing') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-2 py-2 items-center">

                            <label for="supplier_id">Supplier<x-req /></label>
                            <select autocomplete="on" class="col-span-2" name="supplier_id" id="supplier_id" required>
                                <option value="" selected>--Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}"> {{$supplier->title}} </option>
                                @endforeach
                            </select>

                            <label for="invoice_date">Invoice Date<x-req /></label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="col-span-2" id="invoice_date" name="invoice_date" required>

                            <label for="number">Invoice #<x-req /></label>
                            <input type="text" class="col-span-2" id="number" name="number" placeholder="Invoice No"
                                minlength="3" title="minimum 3 characters required" required>

                        </div>

                        <div class="grid grid-cols-1">
                            {{-- Contract Master --}}

                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Invoice Level Expenses</legend>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Discou(%)" name="bankcharges" id="bankcharges" required  onblur="tnetamount()" />
                                    <x-input-numeric title="Discount(Amount)" name="collofcustom" disabled   />
                                    <x-input-numeric title="Cartage" name="exataxoffie" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Payble Amount" name="bankntotal" disabled />
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


@push('scripts')
    <script src="{{ asset('js/tabulator.min.js') }}"></script>
@endpush

<x-tabulator-modal title="Materials" />

@push('scripts')
<script>
    let table;
    let searchValue = "";
    const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};

    // Populate Locations in Tabulator
    const locations = @json($locations);
        var newList=[]
        locations.forEach(e => {
            newList.push({value:e.title,label:e.title , id:e.id})

        });

        // value="{{$supplier->id}}"> {{$supplier->title}}


    const getMasterData = @json(route('materials.master'));
    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let modal = document.getElementById("myModal")
    console.log(getMasterData);

    let dyanmicTable = ""; // Tabulator
    let dynamicTableData = [];

    // Add event handler to read keyboard key up event
    document.addEventListener('keyup', (e)=>{
        //  We are using ctrl key + 'ArrowUp' to show Modal
        if(e.ctrlKey && e.keyCode == 32){
            showModal()
        }
    })
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

    var tamount=0;
    function tnetamount()
        {
            //  var crtg=0;
            //  crtg=parseFloat(exataxoffie.value).toFixed(0);
             collofcustom.value=0;
             bankntotal.value=0;

            // var discAmnt =  parseFloat(exataxoffie.value)*parseFloat(bankcharges.value)/100
            // collofcustom.value = discAmnt.toFixed(0)

            collofcustom.value=(tamount*bankcharges.value/100).toFixed(0);
            bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value)   ;
            // bankntotal.value=parseFloat( bankntotal.value ) + parseFloat(exataxoffie.values);
        }

        // function DiscAmount()
        // {
        //     bankcharges.value=0
        //     var discper =  parseFloat(collofcustom.value)/parseFloat(exataxoffie.value)*100
        //     bankcharges.value = discper.toFixed(1)
        //     // console.log(banktotal.value);
        // }




</script>
@endpush

@push('scripts')
<script>
    //  ---------------- For MODAL -----------------------//
    function showModal(){ modal.style.display = "block"}
    function closeModal(){  modal.style.display = "none"}
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

        dynamicTableData.push({ id:data.id})

        dynamicTable.addData([
            {
                id:data.id,
                title:data.title,
                category_id:data.category_id,
                category:data.category,

                source_id:data.source_id,
                source:data.source,

                brand_id:data.brand_id,
                brand:data.brand,

                sku_id:data.sku_id,
                sku:data.sku,

                dimension_id:data.dimension_id,
                dimension:data.dimension,

                bundle1:0,
                bundle2:0,
                pcspbundle1:0,
                pcspbundle2:0,
                gdswt:0,
                gdsprice:0,
                dtyrate:0,
                invsrate:0,
                gdspricetot:0
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
        ajaxURL: getMasterData,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Material", field:"title" , visible:true ,headerSort:false, responsive:0},
            {title:"Category", field:"category" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Source", field:"source" ,  responsive:0},
            {title:"Sku", field:"sku" ,  responsive:0},
            {title:"Brand", field:"brand" ,  responsive:0},
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
    var updateValues = (cell) => {
        var data = cell.getData();
        var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
        var row = cell.getRow();
        row.update({
            "ttpcs": sum,
            "gdspricetot": sum2
        });
    }

    var totalVal = function(values, data, calcParams){
        //values - array of column values
        //data - all table data
        //calcParams - params passed from the column definition object
        // console.log(data);
        var calc = 0;
        values.forEach(function(value){
            calc += value ;

        });
        tamount = calc;
        tnetamount();
        // collofcustom.value=(calc*bankcharges.value/100).toFixed(0);
        // bankntotal.value=calc - collofcustom.value ;
        return calc;

    }
    //  Dynamic Table [User data]
    dynamicTable = new Tabulator("#dynamicTable", {
        layout:'fitData',
        // data:dynamicTableData,
        reactiveData:true,
        columns:[
            {title:"Delete" , formatter:deleteIcon, headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    cell.getRow().delete();
                    dynamicTableData = dynamicTable.getData(); // Ensure that our data is clean
                    dynamicTable.redraw();
                    // disableSubmitButton();
                }
            },

            {title: "id",field: "myid",visible:false},
                {title:"Location", field:"location" ,editor:"list" , editorParams:   {
                        values:newList,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },




            {title:"Id",                field:"id",    cssClass:"bg-gray-200 font-semibold"},
            {title:"Material",          field:"title", cssClass:"bg-gray-200 font-semibold"},
            {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Category",          field:"category",       cssClass:"bg-gray-200 font-semibold"},
            {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
            {title:"Source",            field:"source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Source",            field:"source",         cssClass:"bg-gray-200 font-semibold"},
            {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Sku",               field:"sku",            cssClass:"bg-gray-200 font-semibold"},
            {title:"Brand",             field:"brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Brand",             field:"brand",          cssClass:"bg-gray-200 font-semibold"},

            {   title:"Quantity",
                field:"bundle1",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
               },

            {   title:"Rate",
                field:"pcspbundle1",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,2)"] ,
                cellEdited: updateValues   ,
            },

            // {   title:"Bundle2",
            //     field:"bundle2",
            //     editor:"number",
            //     cssClass:"bg-yellow-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     validator:["required","integer"],
            //     cellEdited: updateValues   ,
            // },

            // {   title:"Pcs/Bnd2",
            //     field:"pcspbundle2",
            //     editor:"number",
            //     cssClass:"bg-yellow-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     validator:["required","integer"],
            //     cellEdited: updateValues  ,
            // },

            {   title:"Amount",
                field:"ttpcs",
                cssClass:"bg-gray-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:3},
                formatter:function(cell,row)
                {
                    return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)
                },
                bottomCalc:totalVal  },

            // {   title:"Wt(MT)",
            //     field:"gdswt",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:3},
            //     validator:["required","numeric"],
            //     cellEdited:updateValues,
            //     bottomCalc:"sum",
            //     bottomCalcParams:{precision:3}  },

            // {   title:"Rs($)",
            //     field:"gdsprice",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:3},
            //     validator:["required","numeric"],
            //     cellEdited:updateValues,
            // },

            // {   title:"DutyRs($)",
            //     field:"dtyrate",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:3},
            //     validator:["required","numeric"],
            //     cellEdited:updateValues,
            // },

            // {   title:"ComInvRs($)",
            //     field:"invsrate",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:3},
            //     validator:["required","numeric"],
            //     cellEdited:updateValues,
            // },







            // {   title:"Val($)",
            //     field:"gdspricetot",
            //     cssClass:"bg-gray-200 font-semibold",
            //     bottomCalc:totalVal,
            //     bottomCalcParams:{precision:3} ,
            //     formatter:"money",
            //     formatterParams:{
            //         decimal:".",
            //         thousand:",",
            //         symbol:"$",
            //         precision:3     },
            //     formatter:function(cell,row)
            //     {
            //         return (cell.getData().gdswt * cell.getData().gdsprice)
            //     }
            // },

        ],
    })

    // Validation & Post
    function validateForm()
    {
        var sid = document.getElementById("supplier_id");
        var supplier_id = sid.options[sid.selectedIndex];
        var invoice_date = document.getElementById("invoice_date");
        var number = document.getElementById("number");
        var bankcharges= document.getElementById("bankcharges")
        var exataxoffie= document.getElementById("exataxoffie")
        var collofcustom= document.getElementById("collofcustom")
        var bankntotal= document.getElementById("bankntotal")



        // Required
        if(supplier_id.value <= 0)
        {
            showSnackbar("Please select From Supplier");
            supplier_id.focus();
            return;
        }
        if(invoice_date.value === "")
        {
            showSnackbar("Please select From Invoice Date");
            invoice_date.focus();
            return;
        }
        if(number.value == "")
        {
            showSnackbar("Please add Invoice Number");
            number.focus();
            return;
        }
        if(dynamicTableData.length == 0)
        {
            showSnackbar("You must have atleast 1 row of item to Proceed","info");
            return;
        }
        dynamicTableData = dynamicTable.getData();
        // Qty Required
        for (let index = 0; index < dynamicTableData.length; index++) {
            const element = dynamicTableData[index];

            if(element.location === undefined)
               {
                showSnackbar("Location must be Enter","info");
                return;
               }




            if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.ttpcs == 0 )
            // || element.gdsprice == 0 || element.gdswt == 0 ttpcs
            {
                showSnackbar("Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");
                return;
            }
        }
        disableSubmitButton(true);
        var data = { 'contracts' : dynamicTableData,'bankntotal':bankntotal.value,'exataxoffie':exataxoffie.value,'collofcustom':collofcustom.value,'bankcharges':bankcharges.value ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'number':number.value};
        // All Ok - Proceed
        fetch(@json(route('localpurchase.store')),{
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
                window.open(window.location.origin + "/localpurchase","_self" );
            }
        })
        .catch(error => {
            showSnackbar("Errors occured","red");
            disableSubmitButton(false);
        })
    }
</script>


@endpush/

{{-- required  onblur="Discper()" --}}
{{-- required  onblur="DiscAmount()" --}}






</x-app-layout>






