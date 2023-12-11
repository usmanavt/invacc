<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    {{-- <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet"> --}}
    {{-- <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script> --}}
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
                            <input type="text" class="col-span-2" id="number" name="number" placeholder="Invoice No" >

                                {{-- <label for="gpassno">GatePass #<x-req /></label> --}}
                                <input type="text" class="col-span-2" id="gpassno" name="gpassno" value="{{$maxgpno}}" hidden  placeholder="gpassno"
                                    >

                        </div>

                        <div class="grid grid-cols-1">
                            {{-- Contract Master --}}

                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Invoice Level Expenses</legend>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Discou(%)" name="insurance" id="insurance" disabled    />
                                    <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="per" id="per" onclick="EnableDisableTextBox(this)" >
                                    <x-input-numeric title="Discount(Amount)" name="collofcustom"     />
                                    <x-input-numeric title="Cartage/Loading Charges" name="exataxoffie" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Cutting/Reapair Charges" name="otherchrgs" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Payble Amount" name="bankntotal" disabled />
                                </div>
                            </fieldset>

                            <div class="flex flex-row px-4 py-2 items-center">
                                <x-label value="Add Pcs & Feet Size & Press"></x-label>
                                <x-button id="calculate" class="mx-2" type="button" onclick="calculate()">Generate Item Cost With Other Charges</x-button>
                                <x-label value="This will prepare your commercial invoice for Submission"></x-label>
                            </div>


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
    let supplierId = document.getElementById('supplier_id');
    let table;
    let searchValue = "";
    const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};


    // Populate Locations in Tabulator
  //  const locations = @json($locations);
  //      var newList=[]
  //      locations.forEach(e => {
  //          newList.push({value:e.title,label:e.title , id:e.id})

  //      });

        const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})

        });




    // const getMaster = @json(route('materials.master'));

    const getMaster = @json(route('locmat.master'));

    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let modal = document.getElementById("myModal")
    // console.log(getMaster);

    let dyanmicTable = ""; // Tabulator
    let dynamicTableData = [];

    // Add event handler to read keyboard key up event
    document.addEventListener('keyup', (e)=>{
        //  We are using ctrl key + 'ArrowUp' to show Modal
        if(e.ctrlKey && e.keyCode == 32){
            if (
                supplierId.options[supplierId.selectedIndex].value != ""
                ||
                supplierId.options[supplierId.selectedIndex].value != 0 )  {
                    // console.log(supplierId.options[supplierId.selectedIndex].value)
                    showModal()
            }
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

            if (insurance.disabled)
            {insurance.value=(collofcustom.value/tamount*100).toFixed(2)};

            if (!insurance.disabled)
            {collofcustom.value=(tamount*insurance.value/100).toFixed(0);};

            // collofcustom.value=(tamount*insurance.value/100).toFixed(0);
            bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
            // bankntotal.value=parseFloat( bankntotal.value ) + parseFloat(exataxoffie.values);
        }

</script>
@endpush

@push('scripts')
<script>
    //  ---------------- For MODAL -----------------------//
    function showModal(){ modal.style.display = "block" }
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
                // purunit:'',
                machineno:'',
                repname:'',
                forcust:'',
                purunit:'',

                 gdswt:0,
                 pcs:0,
                 qtyinfeet:0,
                 gdsprice:0,
                 length:0,
                 amtinpkr:0,
                 cstrt:0,
                 cstamt:0


            }
        ])
    }

var calculate = function(){
    const data = dynamicTable.getData()

    var amtinpkrtotal = 0
    var amtper = 0
    var cstrt=0
    var cstamt=0

    tnetamount();

            data.forEach(e => {
                amtinpkrtotal += parseFloat(e.amtinpkr)
                // dtyamtinpkrtotal += parseFloat(e.dtyamtinpkr)
            });

            data.forEach(e => {
                e.amtper = parseFloat(e.amtinpkr)/amtinpkrtotal*100
                e.cstamt= bankntotal.value * parseFloat(e.amtper)/100
                console.log(bankntotal.value)

                   if(e.sku==='KG')
                    {
                        e.cstrt=((bankntotal.value * parseFloat(e.amtper)/100)/e.gdswt).toFixed(3)
                    }
                    if(e.sku==='PCS')
                    {
                        e.cstrt=((bankntotal.value * parseFloat(e.amtper)/100)/e.pcs).toFixed(3)                    }
                    if(e.sku==='FEET')
                    {
                        e.cstrt=((bankntotal.value * parseFloat(e.amtper)/100)/e.qtyinfeet).toFixed(3)
                    }

                    cstrt=e.cstrt
                    cstamt=e.cstamt
                    // console.log(cstrt)
            });
            dynamicTable.setData(data)

        }

</script>
@endpush

@push('scripts')
<script>
    //  Table Filter
    function dataFilter(element)
    {
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue,supplierId:supplierId.options[supplierId.selectedIndex].value});
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
            return {search:searchValue,supplierId:supplierId.options[supplierId.selectedIndex].value};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
            {title:"Material", field:"title" , visible:true ,headerSort:false, responsive:0},
            {title:"Category", field:"source" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Category", field:"category" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Category_Id", field:"category_id" , visible:false ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,   responsive:0},
            {title:"Search Text", field:"srchi" ,   responsive:0},
            {title:"Unit", field:"sku" ,  responsive:0},
            {title:"sku_id", field:"sku_id",visible:false ,  responsive:0},
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
        // var leninft = Number(data.pcs) * Number(data.length)
        if(data.sku==='KG')
         {

            var sum =  Number(data.gdswt) * Number(data.gdsprice)
             var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
         }
         if(data.sku==='PCS')
         {
             var sum =  Number(data.pcs) * Number(data.gdsprice)
             var sum2 =  Number(data.pcs) * Number(data.gdsprice)
         }
         if(data.sku==='FEET')
         {
             var sum =  Number(data.qtyinfeet) * Number(data.gdsprice)
             var sum2 =  Number(data.qtyinfeet) * Number(data.gdsprice)
         }
         var crt=data.gdsprice
        // var sum = Number(data.gdswt) * Number(data.gdsprice)
        // var sum2 =  Number(data.gdswt) * Number(data.gdsprice)
        var row = cell.getRow();
        row.update({
            // "amtinpkr": sum,
            "amtinpkr": sum,
            "gdspricetot": sum2,
             "cstrt":crt,
            "cstamt":sum

            // "qtyinfeet":leninft
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

        // collofcustom.value=(calc*insurance.value/100).toFixed(0);
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

            // {title:"Id",                field:"id",    cssClass:"bg-gray-200 font-semibold"},
            {title:"Material",          field:"title", cssClass:"bg-gray-200 font-semibold"},
            {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Category",          field:"category",       cssClass:"bg-gray-200 font-semibold"},
            {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
            {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"M/Unit",            field:"sku",            cssClass:"bg-gray-200 font-semibold"},

            // {title: "id",field: "myid",visible:false},
            //     {title:"Location", field:"location" ,editor:"list" , editorParams:   {
            //             values:newList,
            //             cssClass:"bg-green-200 font-semibold",
            //             validator:["required"]
            //         }
            //     },

                {title: "id",field: "skuid",visible:false},
                {title:"UOM", field:"sku" ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        cellEdited: updateValues,
                        validator:["required"]
                    }
                },




            // {title:"PurUnit",           field:"purunit",        cssClass:"bg-gray-200 font-semibold",validator:"in:p|k|f",editor:true},


            {title:"Replace Description",field:"repname",       editor:true},
            {title:"Brand",              field:"machineno",     editor:true},
            {title:"ForCustomer",        field:"forcust",       editor:true},
            // {title:"Source",            field:"source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
            // {title:"Source",            field:"source",         cssClass:"bg-gray-200 font-semibold",visible:false},

            // {title:"Brand",             field:"brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
            // {title:"Brand",             field:"brand",          cssClass:"bg-gray-200 font-semibold"},




            {   title:"Weight",
                field:"gdswt",
                editor:"number",
                // cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
                bottomCalc:"sum"
               },

               {title:"Qty(Pcs)",
                field:"pcs",
                editor:"number",
                // cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
                bottomCalc:"sum"
               },

            //    {title:"Length",
            //     field:"length",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     validator:"required",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     validator:["required","integer"],
            //     cellEdited: updateValues,
            //    },



               {title:"Qty(Feet)",
                field:"qtyinfeet",
                editor:"number",
                // cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
                bottomCalc:"sum"
               },



               {title:"Price",
                field:"gdsprice",
                editor:"number",
                // cssClass:"bg-green-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,2)"] ,
                cellEdited: updateValues   ,
            },


            {   title:"Amount",
                field:"amtinpkr",
                cssClass:"bg-gray-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:0},
                cellEdited: updateValues   ,
                // formatter:function(cell,row)
                // {
                //     // return (cell.getData().bundle1 * cell.getData().pcspbundle1) + (cell.getData().bundle2 * cell.getData().pcspbundle2)

                //     return console.log(cell.getData().skuid.sku_id)


                // },
                bottomCalc:totalVal  },

                {title:"CostPrice",
                field:"cstrt",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:3},
                validator:["required","decimal(10,0)"] ,
                cellEdited: updateValues   ,
            },

            {title:"CostAmount",
                field:"cstamt",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,0)"] ,
                cellEdited: updateValues   ,
                bottomCalc:"sum",
            },





         ],
    })

    // Validation & Post
    function validateForm()
    {
        var sid = document.getElementById("supplier_id");
        var supplier_id = sid.options[sid.selectedIndex];
        var invoice_date = document.getElementById("invoice_date");
        var number = document.getElementById("number");
        var insurance= document.getElementById("insurance")
        var exataxoffie= document.getElementById("exataxoffie")
        var otherchrgs= document.getElementById("otherchrgs")
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
        // for (let index = 0; index < dynamicTableData.length; index++) {
        //     const element = dynamicTableData[index];

        //     // if(element.location === undefined || element.purunit==undefined)
        //     //    {
        //     //     showSnackbar("Location must be Enter","info");
        //     //     return;
        //     //    }

        //     // if(element.gdswt == 0 || element.pcs == 0 || element.qtyinfeet == 0 || element.gdsprice == 0 )

        //     // {
        //     //     showSnackbar("Please fill all Weight,Length,Pcs & Price all rows to proceed","info");
        //     //     return;
        //     // }
        // }
        disableSubmitButton(true);
        var data = { 'contracts' : dynamicTableData,'bankntotal':bankntotal.value,'otherchrgs':otherchrgs.value,'exataxoffie':exataxoffie.value,'collofcustom':collofcustom.value,'insurance':insurance.value ,'supplier_id': supplier_id.value,'invoice_date':invoice_date.value,'number':number.value,'gpassno':gpassno.value};
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


    window.onload = function() {
            var input = document.getElementById("supplier_id").focus();
        }

        function EnableDisableTextBox(per) {
        var insurance = document.getElementById("insurance");
        insurance.disabled = per.checked ? false : true;
        insurance.style.color ="black";
    }





  insurance.onblur=function(){
    per=false
    tnetamount();
    // collofcustom.value=(tamount * insurance.value/100).toFixed(0);
    // bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
}

collofcustom.onblur=function(){
    tnetamount();
    // insurance.value=(collofcustom.value/tamount * 100).toFixed(2);
    // bankntotal.value= ( Number(tamount)-Number(collofcustom.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
}

</script>



@endpush

{{-- required  onblur="Discper()" --}}
{{-- required  onblur="DiscAmount()" --}}






</x-app-layout>






