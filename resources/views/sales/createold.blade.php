<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Sales Invoice') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-1 py-2 items-center">

                            <label for="customer_id">Customer<x-req /></label>
                            <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" required>
                                <option value="" selected>--Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>
.
                            <label for="invoice_date">Invoice Date<x-req /></label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="col-span-4"  id="saldate" name="saldate" required>

                            <label for="dcno">Delivery Chln# <x-req /></label>
                            <input type="text" class="col-span-2" id="dcno" name="dcno" value="{{$maxdcno}}"    placeholder="dcno" required>
                        </div>


                        <div>
                            <label for="billno">Sale Bill#<x-req /></label>
                            <input type="text" class="col-span-2" id="billno" name="billno" value="{{$maxblno}}" placeholder="billno" required>

                            <label for="gpno">Gate Pass#<x-req /></label>
                            <input type="text" class="col-span-2" id="gpno" name="gpno" value="{{$maxgpno}}" placeholder="gpno" required>
                        </div>





                        <div class="grid grid-cols-1">
                            {{-- Contract Master --}}

                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Invoice Level Expenses</legend>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Discou(%)" name="discntper" id="discntper" required  onblur="tnetamount()" />
                                    <x-input-numeric title="Discount(Amount)" name="discntamt" disabled   />
                                    <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Receivable Amount" name="rcvblamount" disabled />
                                </div>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                    <x-input-numeric title="Total Amount" name="totrcvbamount" disabled />
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


// Populate sku in Tabulator
const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})

        });




    const getMaster = @json(route('materials.master'));
    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    let modal = document.getElementById("myModal")
    console.log(getMaster);

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
            //  crtg=parseFloat(cartage.value).toFixed(0);
             discntamt.value=0;
             rcvblamount.value=0;

            // var discAmnt =  parseFloat(cartage.value)*parseFloat(ba nkcharges.value)/100
            // discntamt.value = discAmnt.toFixed(0)

            discntamt.value=(tamount*discntper.value/100).toFixed(0);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )+Number(cartage.value)  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)).toFixed(0);

            // rcvblamount.value=parseFloat( rcvblamount.value ) + parseFloat(cartage.values);
        }

        // function DiscAmount()
        // {
        //     bankcharges.value=0
        //     var discper =  parseFloat(discntamt.value)/parseFloat(cartage.value)*100
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

                // source_id:data.source_id,
                // source:data.source,

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
        ajaxURL: getMaster,
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
        //   var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
        var row = cell.getRow();
        // console.info(data.sku);
        if( data.sku == "KG")
          {
          var sum = (Number(data.bundle1) * Number(data.pcspbundle1))
          var sum2 = (Number(data.bundle1) * Number(data.pcspbundle1))
          }

          if(data.sku == "Pcs")
          {
          var sum = (Number(data.bundle2) * Number(data.pcspbundle1))
           var sum2 = (Number(data.bundle2) * Number(data.pcspbundle1))
          }

          if(data.sku == "Feet")
          {
          var sum = (Number(data.pcspbundle2) * Number(data.pcspbundle1))
           var sum2= (Number(data.pcspbundle2) * Number(data.pcspbundle1))
          }
        row.update({

                "ttpcs": sum,
                // "gdspricetot": sum2
                totalVal: sum2
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
        // discntamt.value=(calc*bankcharges.value/100).toFixed(0);
        // rcvblamount.value=calc - discntamt.value ;
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

                {title: "id",field: "skuid",visible:false},
                {title:"skus", field:"sku" ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
                },


            // {title:"Id",                field:"id",    cssClass:"bg-gray-200 font-semibold"},
            {title:"Material",          field:"title", cssClass:"bg-gray-200 font-semibold"},
            {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Category",          field:"category",       cssClass:"bg-gray-200 font-semibold"},
            {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold"},
            {title:"Replace Description",field:"repname",       cssClass:"bg-gray-200 font-semibold",editor:true},
            // {title:"Source",            field:"source_id",      cssClass:"bg-gray-200 font-semibold",visible:false},
            // {title:"Source",            field:"source",         cssClass:"bg-gray-200 font-semibold"},
            {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Std. Unit",         field:"sku",            cssClass:"bg-gray-200 font-semibold"},
            {title:"Brand",             field:"brand_id",       cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Brand",             field:"brand",          cssClass:"bg-gray-200 font-semibold"},



            // {   title:"Replace Description",
            //     field:"repname",
            //     editor:"number",
            //     cssClass:"bg-green-200 font-semibold",
            //     // validator:"required",
            //     // formatter:"money",
            //     // formatterParams:{thousand:",",precision:2},
            //     // validator:["required","integer"],
            //     // cellEdited: updateValues,
            //    },







            {   title:"Qty(Kg)",
                field:"bundle1",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues,
               },

               { title:"Qty(Pcs)",
                field:"bundle2",
                editor:"number",
                cssClass:"bg-yellow-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues   ,
            },

            {   title:"Qty(Feet)",
                field:"pcspbundle2",
                editor:"number",
                cssClass:"bg-yellow-200 font-semibold",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","integer"],
                cellEdited: updateValues  ,
            },




               { title:"Rate",
                field:"pcspbundle1",
                editor:"number",
                cssClass:"bg-green-200 font-semibold",
                validator:"required" ,
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                validator:["required","decimal(10,3)"] ,
                cellEdited: updateValues   ,
            },





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
        var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        var saldate = document.getElementById("saldate");
        var dcno = document.getElementById("dcno");
        var billno = document.getElementById("billno");
        var gpno = document.getElementById("gpno");

        var discntper= document.getElementById("discntper")
        var cartage= document.getElementById("cartage")
        var discntamt= document.getElementById("discntamt")
        var rcvblamount= document.getElementById("rcvblamount")



        // Required
        if(customer_id.value < 0)
        {
            showSnackbar("Please select From Customer");
            customer_id.focus();
            return;
        }
        if(saldate.value === "")
        {
            showSnackbar("Please select From Invoice Date");
            saldate.focus();
            return;
        }
        if(dcno.value == "")
        {
            showSnackbar("Please add dcno");
            dcno.focus();
            return;
        }

        if(billno.value == "")
        {
            showSnackbar("Please add billno");
            billno.focus();
            return;
        }

        if(gpno.value == "")
        {
            showSnackbar("Please add gpno");
            gpno.focus();
            return;
        }
        // sid.options[sid.selectedIndex]
        if(dynamicTableData.length == 0)
        {
            showSnackbar("You must have atleast 1 row of item to Proceed","info");
            return;
        }
        dynamicTableData = dynamicTable.getData();
        // Qty Required
        for (let index = 0; index < dynamicTableData.length; index++) {
            const element = dynamicTableData[index];

            if(element.bundle1 == 0 || element.pcspbundle1 == 0 || element.ttpcs == 0   )
            // || element.gdsprice == 0 || element.gdswt == 0 ttpcs
            {
                  showSnackbar( "Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");

                return;
            }
        }
        disableSubmitButton(true);
        var data = { 'contracts' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value ,
        'customer_id': customer_id.value,'saldate':saldate.value,'dcno':dcno.value,'billno':billno.value,'gpno':gpno.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value};
        // All Ok - Proceed
        fetch(@json(route('sales.store')),{
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
                window.open(window.location.origin + "/sales","_self" );
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






