<x-app-layout>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    {{-- <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet"> --}}
    {{-- <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script> --}}

    @endpush


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Opening Stock
        </h2>
    </x-slot>

    <div class="py-2 ">
        <div class="max-w-full mx-auto sm:px-2 lg:px-4 ">
            <div class="bg-white overflow-hidden shadow-sm  sm:rounded-lg">
                {{-- Create Form --}}
                <div class="px-6 py-2">

                    <div class="grid">

                        {{-- <fieldset class="border px-4 py-2 rounded"> --}}
                            {{-- <legend>Invoice Level Entries</legend> --}}
                            {{-- <div class="grid grid-cols-12 gap-1 py-2 items-center"> --}}

                                {{-- <label for="customer_id">Customer<x-req /></label>
                                    <select autocomplete="on" class="col-span-2" name="customer_id" id="customer_id" >
                                        <option value="" selected>--Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}"> {{$customer->title}} </option>
                                        @endforeach
                                    </select> --}}
                                {{-- <x-input-text title="Customer Name" name="custname" id="custname" req required class="col-span-2" disabled  />
                                <x-input-text title="Quotation No" name="qutno" id="qutno" req required class="col-span-2" disabled  />
                                <x-input-date title="Quotation Date" name="qutdate" id="qutdate" req required class="col-span-2" disabled  />
                                <x-input-text title="P.R No" name="prno" id="prno" req required class="col-span-2" disabled  /> --}}

                            {{-- </div> --}}
                            {{-- <div class="grid grid-cols-12 gap-1 py-2 items-center"> --}}
                                {{-- <x-input-date title="P.O Date" id="podate" name="podate" req required class="col-span-2" />
                                <x-input-text title="P.O #" name="pono" id="pono" req required class="col-span-2"  />
                                <x-input-date title="Delivery Date" name="deliverydt" req required class="col-span-2"/>
                                <x-input-text title="P.O Seq.#" name="poseqno" id="poseqno" value="{{$maxposeqno}}"    placeholder="poseqno" required   /> --}}


                                {{-- <label for="">
                                    Remakrs <span class="text-red-500 font-semibold  ">(*)</span>
                                </label>
                                <textarea name="remarks" id="remarks" cols="100" rows="2" maxlength="150" required class="rounded"></textarea> --}}
                            {{-- </div> --}}
                        {{-- </fieldset> --}}

                        <fieldset  class="border px-4 py-2 rounded">
                            <legend>Item Description</legend>
                            <div class="grid grid-cols-16 gap-1 py-1 items-center ">
                                <x-input-text title="Material Name" name="material_title"  disabled    />
                                <x-input-text title="Dimension" name="dimension" disabled    />
                                <x-input-date title="O/Date" name="opdate"  />
                                <x-input-numeric title="" name="material_id" hidden  />
                            </div>
                        </fieldset>







                        <fieldset class="border px-4 py-2 rounded">
                            <legend>E - 13</legend>
                            <div class="grid grid-cols-12 gap-1 py-1  items-center">
                                <x-input-numeric title="InKg" name="ostkwte13"  onblur="tnetamount()"    />
                                <x-input-numeric title="InPcs" name="ostkpcse13" onblur="tnetamount()"     />
                                <x-input-numeric title="InFeet" name="ostkfeete13" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="e13"  id="e13" onclick="grp1(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>Gali No 2</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtgn2" onblur="tnetamount()"     />
                                <x-input-numeric title="InPcs" name="ostkpcsgn2" onblur="tnetamount()"     />
                                <x-input-numeric title="InFeet" name="ostkfeetgn2" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="gn2"  id="gn2" onclick="grp2(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>ALLAH MALIK SHOP</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtams" onblur="tnetamount()"     />
                                <x-input-numeric title="InPcs" name="ostkpcsams" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeetams" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="ams"  id="ams" onclick="grp3(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>E - 24</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwte24" onblur="tnetamount()"    />
                                <x-input-numeric title="InPcs" name="ostkpcse24" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeete24" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="e24"  id="e24" onclick="grp4(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>BOLTON SHOP</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtbs"  onblur="tnetamount()"   />
                                <x-input-numeric title="InPcs" name="ostkpcsbs" onblur="tnetamount()"    />
                                <x-input-numeric title="InFeet" name="ostkfeetbs" onblur="tnetamount()"  />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="bs"  id="bs" onclick="grp5(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>OTHERS</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwtoth"  onblur="tnetamount()"   />
                                <x-input-numeric title="InPcs" name="ostkpcsoth"  onblur="tnetamount()"   />
                                <x-input-numeric title="InFeet" name="ostkfeetoth" onblur="tnetamount()" />
                                <input class="checked:bg-blue-500 checked:border-blue-500 focus:outline-none" type="checkbox" name="oth"  id="oth" onclick="grp6(this)" >
                            </div>
                        </fieldset>

                        <fieldset class="border px-4 py-2 rounded">
                            <legend>TOTAL STOCK</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ostkwttot" disabled     />
                                <x-input-numeric title="InPcs" name="ostkpcstot" disabled     />
                                <x-input-numeric title="InFeet" name="ostkfeettot" disabled  />
                            </div>
                        </fieldset>




                        <fieldset class="border px-4 py-2 rounded">
                            <legend>COST</legend>
                            <div class="grid grid-cols-12 gap-1 py-1 items-center">
                                <x-input-numeric title="InKg" name="ocostwt"     />
                                <x-input-numeric title="InPcs" name="ocostpcs"     />
                                <x-input-numeric title="InFeet" name="ocostfeet"  />
                            </div>
                        </fieldset>


                        {{-- <x-tabulator-dynamic /> --}}

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


        const getMaster = @json(route('materials.mastermat'));
        var getDetails = @json(route('custorders.quotationsdtl'));

        let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        let modal = document.getElementById("myModal")
        let calculateButton = document.getElementById("calculate")
        let submitButton = document.getElementById("submitbutton")

        let dynamicTable = ""
        let dynamicTableData = []
        let adopted = false
        let detailsUrl = ''
        let quotation_id = '';
        let customer_id = '';


        // let prno= document.getElementById("prno")
        document.addEventListener('DOMContentLoaded',()=>{
        })
        // Add event handler to read keyboard key up event & conversionrate
        document.addEventListener('keyup', (e)=>{

            //  We are using ctrl key + 'ArrowUp' to show Modal
            if(e.ctrlKey && e.keyCode == 32){

                if(!adopted)
                {
                    // if (document.getElementById("woq").checked) {
                    //     var getMaster = @json(route('custorders.quotations')) ;
                        showModal()
                    // }else {
                    //     var getMaster = @json(route('materials.master')) ;
                    //     showModal()
                    // }
                }
            }
        })
    </script>
@endpush

@push('scripts')
    <script>



        // window.onload = function() {
        //     var input = document.getElementById("pono.focus").focus();
        // }

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

             columns:[
                // Master Data
                {title:"Id", field:"id" , responsive:0},
            {title:"Material", field:"title", headerSort:false, responsive:0},
            {title:"Category", field:"source" , headerSortStartingDir:"asc" , responsive:0},
            {title:"Items", field:"category" , headerSortStartingDir:"asc" , responsive:0},
            {title:"Category_Id", field:"category_id",visbile:false , headerSortStartingDir:"asc" , responsive:0},
            {title:"Dimesion", field:"dimension", responsive:0},
            {title:"Search Text", field:"srchb", responsive:0},

            // {title:"Source", field:"source" ,  responsive:0},
            {title:"Unit", field:"sku" ,  responsive:0},
            // {title:"Brand", field:"brand" ,  responsive:0},

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
            material_id.value=data.id
            material_title.value=data.title
            dimension.value=data.dimension
            id.value=data.id
            // customer_id=data.customer_id
            // quotation_id = data.id
            // qutdate.value=data.qutdate
            // customer_id=data.customer_id
            // prno.value = data.prno
            // qutno.value = data.qutno
            // discntper.value=data.discntper
            // custname.value=data.custname


            // discntper.value=data.discntper
            // discntamt.value=data.discntamt
            // cartage.value=data.cartage

            // saletaxper.value=data.saletaxper
            // saletaxamt.value=data.saletaxamt
            // rcvblamount.value=data.rcvblamount
            // totrcvbamount.value=data.totrcvbamount
            detailsUrl = `${getDetails}/?id=${data.id}`
            fetchDataFromServer(detailsUrl)
            adopted = true
            // calculateButton.disabled = false
            closeModal()
        })
    </script>
@endpush

@push('scripts')
    <script>

        //  ------------------Dynamic Table----------------------//
        // async function fetchDataFromServer(url)
        // {
        //     var data =  await fetch(url,{
        //         method:"GET",
        //         headers: { 'Accept':'application/json','Content-type':'application/json'},
        //         })
        //         .then((response) => response.json()) //Transform data to json
        //         .then(function(response){
        //             // console.log(response);
        //             return response;
        //         })
        //         .catch(function(error){
        //             console.log("Error : " + error);
        //     })
        //     //  Stremaline Data for Tabulator
        //     for (let index = 0; index < data.length; index++) {

        //         const obj = data[index];
        //         const mat = obj['material']
        //         var vpcs = obj.totpcs
        //         // console.log(vpcs);
        //         // var vwinkg = ((obj.gdswt / vpcs ) * 1000).toFixed(3)
        //         var vwinkg = ((obj.gdswt / vpcs ) ).toFixed(3)
        //         dynamicTable.addData([
        //             {
        //                 id :                obj.id,
        //                 material_title :    obj.material_title,
        //                 quotation_id :      obj.quotation_id,
        //                 material_id :       obj.material_id,
        //                 customer_id :       obj.customer_id,
        //                 user_id :           obj.user_id,
        //                 sku_id :            obj.sku_id,
        //                 sku:                obj.sku,
        //                 // pono:               '',

        //                 dimension_id :      obj.dimension_id,
        //                 dimension :         obj.dimension,
        //                 mybrand :           obj.mybrand,
        //                 repname :           obj.repname,
        //                 saleqty :           obj.saleqty ,
        //                 price   :           obj.price,
        //                 saleamnt:           obj.saleamnt,
        //                 balqty:             obj.balqty,
        //                 varqty:             obj.varqty,

        //             }
        //         ])
        //     }
        // }



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

// var headerMenu = function(){
//     var menu = [];
//     var columns = this.getColumns();

//     for(let column of columns){

//         //create checkbox element using font awesome icons
//         let icon = document.createElement("i");
//         icon.classList.add("fas");
//         icon.classList.add(column.isVisible() ? "fa-check-square" : "fa-square");

//         //build label
//         let label = document.createElement("span");
//         let title = document.createElement("span");

//         title.textContent = " " + column.getDefinition().title;

//         label.appendChild(icon);
//         label.appendChild(title);

//         //create menu item
//         menu.push({
//             label:label,
//             action:function(e){
//                 //prevent menu closing
//                 e.stopPropagation();

//                 //toggle current column visibility
//                 column.toggle();

//                 //change menu item icon
//                 if(column.isVisible()){
//                     icon.classList.remove("fa-square");
//                     icon.classList.add("fa-check-square");
//                 }else{
//                     icon.classList.remove("fa-check-square");
//                     icon.classList.add("fa-square");
//                 }
//             }
//         });
//     }

//    return menu;
// };


    function tnetamount()
        {
            // if (discntper.disabled)
            // {discntper.value=(discntamt.value/tamount*100).toFixed(2)};

            // if (!discntper.disabled)
            // {discntamt.value=(tamount*discntper.value/100).toFixed(0);};

        ostkwttot.value=Number(ostkwte13.value)+Number(ostkwtgn2.value)+Number(ostkwtams.value)+Number(ostkwte24.value)+Number(ostkwtbs.value)+Number(ostkwtoth.value)
        ostkpcstot.value=Number(ostkpcse13.value)+Number(ostkpcsgn2.value)+Number(ostkpcsams.value)+Number(ostkpcse24.value)+Number(ostkpcsbs.value)+Number(ostkpcsoth.value)
        ostkfeettot.value=Number(ostkfeete13.value)+Number(ostkfeetgn2.value)+Number(ostkfeetams.value)+Number(ostkfeete24.value)+Number(ostkfeetbs.value)+Number(ostkfeetoth.value)

        }

// var updateValues = (cell) => {
//         var data = cell.getData();
//         // var sum = (Number(data.bundle1) * Number(data.pcspbundle1)) + (Number(data.bundle2) * Number(data.pcspbundle2))
//         var sum = (Number(data.saleqty) * Number(data.price))
//         var varqty = ( Number(data.balqty) - Number(data.saleqty) )
//         var row = cell.getRow();
//         row.update({
//              "saleamnt": sum,
//              "varqty":varqty,
//              totalVal: sum

//         });
//     }

    // var totalVal = function(values, data, calcParams){
    //     var calc = 0;
    //     values.forEach(function(value){
    //         calc += Number(value) ;
    //     });
    //     tamount = calc;
    //     tnetamount();
    //     return calc;

    // }




        // dynamicTable = new Tabulator("#dynamicTable", {
        //     height:"350px",
        //     width:"1000px",
        //     rowContextMenu: rowMenu,
        //     layout:'fitDataTable',
        //     responsiveLayout:"collapse",
        //     reactiveData:true,
        //     // movableRows:true,
        //     // groupBy:"material_title",
        //     columns:[
        //         {title:"Del" , formatter:deleteIcon, headerSort:false, responsive:0,
        //             cellClick:function(e, cell){
        //                 cell.getRow().delete();
        //             }
        //         },
        //         {title:"Id",           field:"id", visible:false},
        //         {title:"Material Name",     field:"material_title",responsive:0},
        //         {title:"Material Size",    field:"dimension",responsive:0,frozen:true, headerMenu:headerMenu},
        //         {title:"UOM",         field:"sku",responsive:0, hozAlign:"center"},
        //         {title:"Unitid",       field:"sku_id",visible:false},
        //         // {title:"contract_id",  field:"contract_id",visible:false},
        //         {title:"material_id",  field:"material_id",visible:false},
        //         {title:"supplier_id",  field:"supplier_id",visible:false},
        //         {title:"user_id",      field:"user_id",visible:false},
        //         {title:"category_id",  field:"category_id",visible:false},
        //         {title:"sku_id",       field:"sku_id",visible:false},
        //         {title:"dimension_id", field:"dimension_id",visible:false},


        //         {title:"StockQty", field:"balqty"},



        //         {title:"Variance", field:"varqty",cellEdited: updateValues,},

        //         {
        //             title:'Quantity', headerHozAlign:"center",
        //             columns:[
        //                 {   title:"Replace Name",headerHozAlign :'center',
        //                     field:"repname",
        //                     // editor:"list",
        //                     responsive:0,
        //                     // headerVertical:true,
        //                     editor:true,
        //                 },

        //                 {   title:"Brand",headerHozAlign :'center',
        //                     field:"mybrand",
        //                     // editor:"list",
        //                     responsive:0,
        //                     // headerVertical:true,
        //                     editor:true,
        //                 },





        //                 {   title:"Sale Qty",
        //                     headerHozAlign :'right',
        //                     hozAlign:"right",
        //                     responsive:0,
        //                     field:"saleqty",
        //                     editor:"number",
        //                     // headerVertical:true,
        //                     bottomCalc:"sum",
        //                     formatter:"money",
        //                     cellEdited: updateValues,
        //                     validator:["required","numeric"],
        //                     // cssClass:"bg-green-200 font-semibold",
        //                     formatterParams:{thousand:",",precision:0},
        //                 },

        //                 {   title:"Sale Price",
        //                     headerHozAlign :'right',
        //                     hozAlign:"right",
        //                     responsive:0,
        //                     field:"price",
        //                     editor:"number",
        //                     // headerVertical:true,
        //                     bottomCalc:"sum",
        //                     formatter:"money",
        //                     cellEdited: updateValues,
        //                     validator:["required","numeric"],
        //                     // cssClass:"bg-green-200 font-semibold",
        //                     formatterParams:{thousand:",",precision:0},
        //                 },


        //                 {title:"Sale Amount",
        //                 headerHozAlign :'right',
        //                 hozAlign:"right",
        //                 field:"saleamnt",
        //                 cssClass:"bg-gray-200 font-semibold",
        //                 formatter:"money",
        //                 cssClass:"bg-green-200 font-semibold",
        //                 formatterParams:{thousand:",",precision:3},
        //                 formatter:function(cell,row)
        //                 {
        //                     return (cell.getData().saleqty * cell.getData().price).toFixed(0)
        //                 },
        //                 bottomCalc:totalVal  },


        //             ]
        //         },


        //     ],
        // })
        // dynamicTable.on("dataLoaded", function(data){
        //     //data - all data loaded into the table
        // });
        // Validation & Post
        function validateForm()
        {

             var material_title = document.getElementById("material_title")
            // var poseqno = document.getElementById("poseqno")
            // var per= document.getElementById("per");

            if(material_id.value === 0)
            {
                showSnackbar("Material Required","error");
                material_title.focus();
                return;
            }

            if(ocostwt.value == 0 || ocostpcs.value == 0|| ocostfeet.value == 0)
            {
                showSnackbar("Material Cost Required","error");
                ocostwt.focus();
                return;
            }





            var data = { 'openinggodownstock' : dynamicTableData,'opdate':opdate.value,
            'ostkwte13':ostkwte13.value,'ostkpcse13':ostkpcse13.value,'ostkfeete13':ostkfeete13.value,
            'ostkwtgn2':ostkwtgn2.value,'ostkpcsgn2':ostkpcsgn2.value,'ostkfeetgn2':ostkfeetgn2.value,
            'ostkwtams':ostkwtams.value,'ostkpcsams':ostkpcsams.value,'ostkfeetams':ostkfeetams.value,
            'ostkwte24':ostkwte24.value,'ostkpcse24':ostkpcse24.value,'ostkfeete24':ostkfeete24.value,
            'ostkwtbs':ostkwtbs.value,'ostkpcsbs':ostkpcsbs.value,'ostkfeetbs':ostkfeetbs.value,'material_id':material_id.value,
            'ostkwtoth':ostkwtoth.value,'ostkpcsoth':ostkpcsoth.value,'ostkfeetoth':ostkfeetoth.value,
            'ostkwttot':ostkwttot.value,'ostkpcstot':ostkpcstot.value,'ostkfeettot':ostkfeettot.value,
            'ocostwt':ocostwt.value,'ocostpcs':ocostpcs.value,'ocostfeet':ocostfeet.value
            };

        // ostkwttot.value=Number(ostkwte13.value)+Number(ostkwtgn2.value)+Number(ostkwtams.value)+Number(ostkwte24.value)+Number(ostkwtbs.value)+Number(ostkwtoth.value)
        // ostkpcstot.value=Number(ostkpcse13.value)+Number(ostkpcsgn2.value)+Number(ostkpcsams.value)+Number(ostkpcse24.value)+Number(ostkpcsbs.value)+Number(ostkpcsoth.value)
        // ostkfeettot.value=Number(ostkfeete13.value)+Number(ostkfeetgn2.value)+Number(ostkfeetams.value)+Number(ostkfeete24.value)+Number(ostkfeetbs.value)+Number(ostkfeetoth.value)



            // All Ok - Proceed
            fetch(@json(route('openinggodownstock.store')),{
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
                    window.open(window.location.origin + "/openinggodownstock","_self" );
                }
            })
            .catch(error => {
                showSnackbar("Errors occured","red");
                // disableSubmitButton(false);
            })
        }

        function grp1(e13) {
        var ostkwte13 = document.getElementById("ostkwte13");
        var ostkpcse13 = document.getElementById("ostkpcse13");
        var ostkfeete13 = document.getElementById("ostkfeete13");

        ostkwte13.disabled = e13.checked ? true : false;
        ostkpcse13.disabled = e13.checked ? true : false;
        ostkfeete13.disabled = e13.checked ? true : false;

        ostkwte13.style.color ="black";
        ostkpcse13.style.color ="black";
        ostkfeete13.style.color ="black";
        }


        function grp2(gn2) {
        var ostkwtgn2 = document.getElementById("ostkwtgn2");
        var ostkpcsgn2 = document.getElementById("ostkpcsgn2");
        var ostkfeetgn2 = document.getElementById("ostkfeetgn2");

        ostkwtgn2.disabled = gn2.checked ? true : false;
        ostkpcsgn2.disabled = gn2.checked ? true : false;
        ostkfeetgn2.disabled = gn2.checked ? true : false;

        ostkwtgn2.style.color ="black";
        ostkpcsgn2.style.color ="black";
        ostkfeetgn2.style.color ="black";
    }


        function grp3(ams) {
        var ostkwtams = document.getElementById("ostkwtams");
        var ostkpcsams = document.getElementById("ostkpcsams");
        var ostkfeetams = document.getElementById("ostkfeetams");

        ostkwtams.disabled = ams.checked ? true : false;
        ostkpcsams.disabled = ams.checked ? true : false;
        ostkfeetams.disabled = ams.checked ? true : false;

        ostkwtams.style.color ="black";
        ostkpcsams.style.color ="black";
        ostkfeetams.style.color ="black";
    }


function grp4(e24) {
        var ostkwte24 = document.getElementById("ostkwte24");
        var ostkpcse24 = document.getElementById("ostkpcse24");
        var ostkfeete24 = document.getElementById("ostkfeete24");

        ostkwte24.disabled = e24.checked ? true : false;
        ostkpcse24.disabled = e24.checked ? true : false;
        ostkfeete24.disabled = e24.checked ? true : false;

        ostkwte24.style.color ="black";
        ostkpcse24.style.color ="black";
        ostkfeete24.style.color ="black";
    }

function grp5(bs) {
        var ostkwtbs = document.getElementById("ostkwtbs");
        var ostkpcsbs = document.getElementById("ostkpcsbs");
        var ostkfeetbs = document.getElementById("ostkfeetbs");

        ostkwtbs.disabled = bs.checked ? true : false;
        ostkpcsbs.disabled = bs.checked ? true : false;
        ostkfeetbs.disabled = bs.checked ? true : false;

        ostkwtbs.style.color ="black";
        ostkpcsbs.style.color ="black";
        ostkfeetbs.style.color ="black";
    }

function grp6(bs) {
        var ostkwtoth = document.getElementById("ostkwtoth");
        var ostkpcsoth = document.getElementById("ostkpcsoth");
        var ostkfeetoth = document.getElementById("ostkfeetoth");

        ostkwtoth.disabled = oth.checked ? true : false;
        ostkpcsoth.disabled = oth.checked ? true : false;
        ostkfeetoth.disabled = oth.checked ? true : false;

        ostkwtoth.style.color ="black";
        ostkpcsoth.style.color ="black";
        ostkfeetoth.style.color ="black";
    }










//     discntper.onblur=function(){
//     per=false
//      tnetamount();
// discntamt.onblur=function(){
//      tnetamount();

// }
    </script>
@endpush

</x-app-layout>
