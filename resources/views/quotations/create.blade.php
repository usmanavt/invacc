<x-app-layout>

    @push('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}"> --}}
    <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Price Quotation') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid grid-cols-1">
                        {{-- Contract Master --}}
                        <div class="grid grid-cols-12 gap-1 py-1 items-center">
                            {{-- onchange="return showcategory()" --}}
                            <label for="customer_id">Customer<x-req /></label>
                            <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id"    >
                                <option value = "" selected>--Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                @endforeach
                            </select>
                            {{-- <input type="text" title="t1"  id="p1" name="p1"    > --}}
                            <label for="saldate">Quotation Date<x-req /></label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="col-span-2"  id="saldate" name="saldate" required>

                            <label for="valdate">Valid Date<x-req /></label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="col-span-2"  id="valdate" name="valdate" required>

                            <label for="qutno">Quotation No <x-req /></label>
                            <input type="text" class="col-span-2" id="qutno" name="qutno" value="{{$maxdcno}}"    placeholder="qutno" required>

                            <label for="prno">P.R No#<x-req /></label>
                            <input type="text" class="col-span-2" id="prno" name="prno"  placeholder="prno" required>
                            <label for="">
                                Cash Customer <span class="text-red-500 font-semibold">(*)</span>
                            </label>
                            <textarea name="cashcustomer" id="cashcustomer" cols="20" rows="2" maxlength="100" required class="rounded"></textarea>

                            <label for="">
                                Cash Cust.Address <span class="text-red-500 font-semibold">(*)</span>
                            </label>
                            <textarea name="cashcustadrs" id="cashcustadrs" cols="30" rows="2" maxlength="150" required class="rounded"></textarea>
                        </div>

                        <div class="grid grid-cols-1">
                            {{-- Contract Master --}}

                            <fieldset class="border px-4 py-2 rounded">
                                <legend>Invoice Level Expenses</legend>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Discou(%)" name="discntper" id="discntper"    />
                                    <x-input-numeric title="Discount(Amount)" name="discntamt" id="discntamt"   />
                                    <x-input-numeric title="Receivable Amount" name="rcvblamount" disabled />
                                </div>
                                <div class="grid grid-cols-12 gap-2 py-2 items-center">
                                    <x-input-numeric title="Sale Tax(%)" name="saletaxper" required  onblur="tnetamount()"  />
                                    <x-input-numeric title="Sale Tax(Rs)" name="saletaxamt" disabled    />
                                    <x-input-numeric title="Cartage" name=cartage  required  onblur="tnetamount()"  />
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
    let customerid = document.getElementById('customer_id');
    let customerDropdown;
    let table;
    let searchValue = "";
    const deleteIcon = function(cell,formatterParams){return "<i class='fa fa-trash text-red-500'></i>";};

    window.onload = function() {
        customerDropdown = document.getElementById("customer_id").focus();
    }
// Populate sku in Tabulator
const skus = @json($skus);
        var newList1=[]
        skus.forEach(e => {
            newList1.push({value:e.title,label:e.title , id:e.id})

        });

    //  const getMaster = @json(route('materials.master'));
     const getMaster = @json(route('quotations.mmfrqut'));


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
                customerid.options[customerid.selectedIndex].value != ""
                ||
                customerid.options[customerid.selectedIndex].value != 0 )  {
                    console.log(customerid.options[customerid.selectedIndex].value)
                    showModal()
            }






            // showModal()
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
             discntamt.value=0;
             rcvblamount.value=0;
            discntamt.value=(tamount*discntper.value/100).toFixed(0);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            // +Number(cartage.value)
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }

        function tnetamount1()
        {
            discntper.value=0;
             rcvblamount.value=0;
             discntper.value=(discntamt.value/tamount*100).toFixed(2);
            rcvblamount.value= ( Number(tamount)-Number(discntamt.value) )  ;
            saletaxamt.value=(Number(rcvblamount.value) * Number(saletaxper.value) )/100 ;
            totrcvbamount.value=(Number(rcvblamount.value)+Number(saletaxamt.value)+Number(cartage.value)).toFixed(0);
        }




</script>
@endpush

@push('scripts')
<script>
    //  ---------------- For MODAL -----------------------//
    function showModal(){
        modal.style.display = "block"
        console.log(customerDropdown)
    }
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

                supp1:'',
                supp2:'',
                supp3:'',

                mrktprice1:0,
                mrktprice2:0,
                mrktprice3:0,

                bundle1:0,
                bundle2:0,
                pcspbundle1:data.pcspbundle1,
                pcspbundle2:0,
                gdswt:0,
                gdsprice:0,
                dtyrate:0,
                invsrate:0,
                gdspricetot:0,
                price:0,
                repname:'',
                mybrand:'',
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
        table.setData(getMaster,{search:searchValue,customerid:customerid.options[customerid.selectedIndex].value});
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue});
    }
    //  The Table for Materials Modal
    table = new Tabulator("#tableData", {
        //autoResize:true,
        width:"1200px",
        height:"600px",
        responsiveLayout:"collapse",
        layout:"fitData",
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
            return {search:searchValue,customerid:customerid.options[customerid.selectedIndex].value};
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",
        columns:[
            // Master Data
            {title:"Id", field:"id" , responsive:0},
          //  {title:"Customer", field:"custname" , headerSortStartingDir:"asc" , responsive:0},
            {title:"Material", field:"title" , headerSort:false, responsive:0},
            {title:"Searching Text", field:"srchb" ,  responsive:0},
            {title:"Items", field:"category" , headerSortStartingDir:"asc" , responsive:0},
            {title:"Category_Id", field:"category_id",visible:false ,headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension" ,  responsive:0},
            {title:"Category", field:"source" , headerSortStartingDir:"asc",visible:false , responsive:0},

            {title:"Last Sale Price", field:"pcspbundle1" ,  responsive:0},
            {title:"Unit", field:"sku" ,  responsive:0},
            // {title:"Brand", field:"brand" ,  responsive:0},
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

          var sum = (Number(data.bundle1) * Number(data.price))
          var sum2 = (Number(data.bundle1) * Number(data.price))

        row.update({

                "ttpcs": sum,
                // "gdspricetot": sum2
                totalVal: sum2
            });

    }

    var totalVal = function(values, data, calcParams){

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
            {title:"Material",          field:"title", cssClass:"bg-gray-200 font-semibold",width:300,responsive:0},
            {title:"Category_id",       field:"category_id",    cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Dimension",         field:"dimension_id",   cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Dimension",         field:"dimension",      cssClass:"bg-gray-200 font-semibold",width:120,responsive:0},
            {title:"Replace Description",field:"repname",       cssClass:"bg-gray-200 font-semibold",editor:true},
            {title:"Sku",               field:"sku_id",         cssClass:"bg-gray-200 font-semibold",visible:false},
            {title:"Brand",             field:"mybrand",          cssClass:"bg-gray-200 font-semibold",editor:true,visible:false},
            {title: "id",field: "skuid",visible:false},
            {title:"UOM", field:"sku" ,editor:"list" , editorParams:   {
                        values:newList1,
                        cssClass:"bg-green-200 font-semibold",
                        validator:["required"]
                    }
            },


            {title:"LastSalePrice",
                field:"pcspbundle1",
                // editor:"number",
                cssClass:"bg-gray-200 font-semibold",
                validator:"required",
                formatter:"money",
                formatterParams:{thousand:",",precision:2},
                // validator:["required","integer"],
                cellEdited: updateValues,
               },

            {
            title:'Market Suppliers', headerHozAlign:"center",
            columns:[

            {title:"1st",field:"supp1",width:200,editor:true,responsive:0,headerHozAlign:"center"},
            {title:"2nd",field:"supp2",width:200,editor:true,responsive:0,headerHozAlign:"center"},
            {title:"3rd",field:"supp3",width:200,editor:true,responsive:0,headerHozAlign:"center"},


        ]},


        {
            title:'Market Price', headerHozAlign:"center",
            columns:[

            {title:"1st",field:"mrktprice1",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
            {title:"2nd",field:"mrktprice2",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
            {title:"3rd",field:"mrktprice3",width:100,responsive:0,formatter:"money",headerHozAlign:"center",editor:"number"},
        ]},


        {
            title:'Sale', headerHozAlign:"center",
            columns:[

            {   title:"Quantity",
                field:"bundle1",
                editor:"number",
                responsive:0,
                validator:"required",
                formatter:"money",
                bottomCalc:"sum",
                formatterParams:{thousand:",",precision:2},
                // validator:["required","integer"],
                cellEdited: updateValues,
               },

            {   title:"Price", field:"price",editor:"number",responsive:0, validator:"required" ,formatter:"money",
             formatterParams:{thousand:",",precision:2},validator:["required","decimal(10,3)"] ,cellEdited: updateValues, },

             {   title:"Amount",field:"ttpcs",cssClass:"bg-gray-200 font-semibold",formatter:"money",formatterParams:{thousand:",",precision:2},
                formatter:function(cell,row)
                {
                    return (cell.getData().bundle1 * cell.getData().price) + (cell.getData().bundle2 * cell.getData().price)
                },
                bottomCalc:totalVal  },


        ]},







            //    {title:"MrktPrice1",
            //     field:"mrktprice1",
            //     editor:"number",
            //     responsive:0,
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     // validator:["required","integer"],
            //     cellEdited: updateValues,
            //    },

            //    {title:"Supplier2",
            //     field:"supp2",
            //     width:200,
            //     editor:true,
            //     // validator:"required",
            //     formatter:"money",
            //     responsive:0,
            //     // validator:["required","integer"],
            //     // cellEdited: updateValues,
            //    },

            //    {title:"MrktPrice2",
            //     field:"mrktprice2",
            //     editor:"number",
            //     responsive:0,
            //     // validator:"required",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     // validator:["required","integer"],
            //     cellEdited: updateValues,
            //    },

            //    {title:"Supplier3",
            //     field:"supp3",
            //     width:200,
            //     editor:true,
            //     // validator:"required",
            //     formatter:"money",
            //     responsive:0,
            //     // validator:["required","integer"],
            //     // cellEdited: updateValues,
            //    },

            //    {title:"MrktPrice3",
            //     field:"mrktprice3",
            //     editor:"number",
            //     responsive:0,
            //     // validator:"required",
            //     formatter:"money",
            //     formatterParams:{thousand:",",precision:2},
            //     // validator:["required","integer"],
            //     cellEdited: updateValues,
            //    },






        ],
    })

    // Validation & Post
    function validateForm()
    {
        var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        var saldate = document.getElementById("saldate");
        var qutno = document.getElementById("qutno");
        var prno = document.getElementById("prno");
        var valdate = document.getElementById("valdate");
        // var repcustname = document.getElementById("repcustname");
        // var repcustadrs = document.getElementById("repcustadrs");

        var discntper= document.getElementById("discntper");
        var cartage= document.getElementById("cartage");
        var discntamt= document.getElementById("discntamt");
        var rcvblamount= document.getElementById("rcvblamount");



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
        if(qutno.value == "")
        {
            showSnackbar("Please add qutno");
            qutno.focus();
            return;
        }

        // if(prno.value == "")
        // {
        //     showSnackbar("Please add prno");
        //     prno.focus();
        //     return;
        // }

        // if(gpno.value == "")
        // {
        //     showSnackbar("Please add gpno");
        //     gpno.focus();
        //     return;
        // }
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

            if(element.bundle1 == 0 || element.price == 0 || element.ttpcs == 0   )
            // || element.gdsprice == 0 || element.gdswt == 0 ttpcs
            {
                  showSnackbar( "Please fill Bundle,PcsBundle,Weight & Price all rows to proceed","info");

                return;
            }
        }
        disableSubmitButton(true);
        var data = { 'contracts' : dynamicTableData,'rcvblamount':rcvblamount.value,'cartage':cartage.value,'discntamt':discntamt.value,'discntper':discntper.value,'discntper':discntper.value ,
        'customer_id': customer_id.value,'saldate':saldate.value,'qutno':qutno.value,'prno':prno.value,
        'saletaxper':saletaxper.value,'saletaxamt':saletaxamt.value,'totrcvbamount':totrcvbamount.value,
        'valdate':valdate.value,'cashcustomer':cashcustomer.value,'cashcustadrs':cashcustadrs.value};
        // All Ok - Proceed
        fetch(@json(route('quotations.store')),{
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
                window.open(window.location.origin + "/quotations","_self" );
            }
        })
        .catch(error => {
            showSnackbar("Errors occured","red");
            disableSubmitButton(false);
        })
    }


    discntper.onblur=function(){
    per=false
    // discntamt.value=(100 * discntper.value/100).toFixed(0);
    // bankntotal.value= ( Number(100)-Number(discntamt.value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
    tnetamount();
}

discntamt.onblur=function(){
    // discntper.value=(discntamt.value/tamount * 100).toFixed(2);
    // bankntotal.value= ( Number(tamount)-Number("discntamt".value))+Number(exataxoffie.value) +Number(otherchrgs.value)  ;
    tnetamount1();
}



customer_id.addEventListener("change", () => {
    var sid = document.getElementById("customer_id");
        var customer_id = sid.options[sid.selectedIndex];
        p1.value=customer_id.value;
//  const value = customer_id.value
// console.log(value)
//   console.info(customer_id.value)
  //  const value = 6
// subhead.options.length = 0 // Reset List
// fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//             method:"GET",
//             headers: { 'Accept':'application/json','Content-type':'application/json'},
//             })
//             .then(response => response.json())
//             .then( data => {
//                 if(data.length > 0)
//                 {

//                     let a = 0;
//                     data.forEach(e => {

//                         a += 1;
//                         addSelectElement(subhead,e.Subhead,a + ' - '+ e.Subhead + ' - ' + e.title)
//                     });
//                     subhead.setAttribute('required','')
//                     subhead.removeAttribute('disabled','')
//                 }else{
//                     subhead.removeAttribute('required','')
//                     subhead.setAttribute('disabled','')
//                 }
//             })
//             .catch(error => console.error(error))
//         // break;

// // FOR CONTRACT FILL
// const getSubheadVoucherData1 = async (value) =>{
// let data = await fetch(funcstkos + `?head_id=${value} &source_id=${value1} &brand_id=${value3} `,{
//     method:"GET",
//     headers: { 'Accept':'application/json','Content-type':'application/json'},
//     })
//     .then(response => response.json())
//     .then( data => { return data })
//     .catch(error => console.error(error))
// }
// const getStkos1 =async  (value) => {
// const Stkos1 = await getSubheadVoucherData1(value)
// return Stkos1
// }

});

</script>


@endpush

{{-- required  onblur="Discper()" --}}
{{-- required  onblur="DiscAmount()" --}}






</x-app-layout>






