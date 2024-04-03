<x-app-layout>

    @push('styles')

    <link rel="stylesheet" href="{{ asset('css/tabulator_simple.min.css') }}">
    {{-- <link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet"> --}}
    {{-- <script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script> --}}

    @endpush

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Materials
        </h2>
    </x-slot>





    <div class="py-6">
        <div class="max-w-7x3 mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p4">
            {{-- Create Form --}}
            <div class="p-6" >
                <div class="flex gap-4">

                    {{-- Form Data --}}
                    <div class="flex flex-col justify-start items-center border rounded-md px-2">
                        <form action="{{ route('materials.store') }}" method="post" >
                            @csrf

                            <input type="hidden" id="dimension" name="dimension" value="">
                            <input type="hidden" id="category" name="category" value="">
                            <input type="hidden" id="source" name="source" value="">
                            <input type="hidden" id="brand" name="brand" value="">
                            <input type="hidden" id="sku" name="sku" value="">

                                <x-label for="" value="Category"/>
                                <select autocomplete="on" required name="source_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Category</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source->id }}">{{ $source->title }}</option>
                                    @endforeach
                                </select>


                                <x-label for="" value="Item"/>
                                <select autocomplete="on" required name="category_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Item</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Dimension"/>
                                <select autocomplete="on" required name="dimension_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Dimension</option>
                                    @foreach ($dimensions as $dimension)
                                        <option value="{{ $dimension->id }}">{{ $dimension->title }}</option>
                                    @endforeach
                                </select>

                                <x-label for="" value="Specifications"/>
                                <select autocomplete="on" required name="brand_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--specification</option>
                                    @foreach ($specifications as $specification)
                                        <option value="{{ $specification->id }}">{{ $specification->title }}</option>
                                    @endforeach
                                </select>



                                <x-label for="" value="Unit"/>
                                <select autocomplete="on" required name="sku_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--Unit</option>
                                    @foreach ($skus as $sku)
                                        <option value="{{ $sku->id }}">{{ $sku->title }}</option>
                                    @endforeach
                                </select>


                                <x-label for="title" value="Complete Name"/>
                                <x-input id="title" class="bg-indigo-100 w-96" type="text" name="title" id="title"  value="{{request()->input('title')}}"   />
                                @if($errors->has('title'))<div class="text-red-500 text-xs">{{ $errors->first('title') }}</div>@endif

                                <x-label for="Nick Name" value="Nick"/>
                                <x-input id="nick" class="bg-indigo-100" type="text" name="nick" :value="old('nick')"  />
                                @if($errors->has('nick'))<div class="text-red-500 text-xs">{{ $errors->first('nick') }}</div>@endif

                                 {{-- <h1 style="color: blue"> TEXT BOXES FOR SEARCHING  </h1>
                                <x-label for="srchi" value="Searc Text For Imported Or Local Items"/>
                                <x-input id="srchi" class="bg-indigo-100 w-96" type="text" maxlength='15' name="srchi"  value="{{request()->input('srchi')}}"   />
                                @if($errors->has('srchi'))<div class="text-red-500 text-xs">{{ $errors->first('srchi') }}</div>@endif --}}

                                <x-label for="srchi" value="Searc Text For Local Items"/>
                                <x-input id="srchi" class="bg-indigo-100 w-96" type="text" maxlength='40' name="srchi"  value="{{request()->input('srchi')}}"   />
                                @if($errors->has('srchi'))<div class="text-red-500 text-xs">{{ $errors->first('srchi') }}</div>@endif

                                <x-label for="srchb" value="Searc Text For Both Items"/>
                                <x-input id="srchb"  class="bg-indigo-100 w-96" type="text" maxlength='40' name="srchb"  value="{{request()->input('srchb')}}"   />
                                @if($errors->has('srchb'))<div class="text-red-500 text-xs">{{ $errors->first('srchb') }}</div>@endif







                                {{-- <x-label for="" value="hscode"/>
                                <select autocomplete="on" required name="hscode_id" class="bg-indigo-100 w-full" required onchange="getHiddenValues(this)">
                                    <option value="" selected>--hscode</option>
                                    @foreach ($hscodes as $hscode)
                                        <option value="{{ $hscode->id }}">{{ $hscode->hscode }}</option>
                                    @endforeach
                                </select> --}}

                                {{-- <div >
                                    <x-label for="Qty(Kg)" value="Qty(Kg)"/>
                                    <x-input id="qtykg" class="bg-indigo-100" type="text" name="qtykg" :value="old('qtykg')"   />

                                    <x-label for="Cost(Kg)" value="Cost(Kg)"/>
                                    <x-input id="qtykgrt" class="bg-indigo-100" type="text" name="qtykgrt" :value="old('qtykgrt')"   />
                                </div>

                                <div >
                                    <x-label for="Qty(pcs)" value="Qty(pcs)"/>
                                    <x-input id="qtypcs" class="bg-indigo-100" type="text" name="qtypcs" :value="old('qtypcs')"   />

                                    <x-label for="Cost(pcs)" value="Cost(pcs)"/>
                                    <x-input id="qtypcsrt" class="bg-indigo-100" type="text" name="qtypcsrt" :value="old('qtypcsrt')"   />
                                </div>

                                <div >
                                    <x-label for="Qty(feet)" value="Qty(feet)"/>
                                    <x-input id="qtyfeet" class="bg-indigo-100" type="text" name="qtyfeet" :value="old('qtyfeet')"   />

                                    <x-label for="Cost(feet)" value="Cost(feet)"/>
                                    <x-input id="qtyfeetrt" class="bg-indigo-100" type="text" name="qtyfeetrt" :value="old('qtyfeetrt')"   />
                                </div> --}}

                                <div class="mt-2">
                                    <button class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fa fa-save fa-fw"></i>
                                        {{ __('Submit') }}
                                    </button>
                                </div>

                                <div class="mt-8" style="font-weight: bold;font-size:2rem">Reports Criteria</div>

                                {{-- <div class="mt-2">Reports Type</div> --}}

                                <x-label for="" value="Report Type"/>
                                <select autocomplete="on" required name="rptid" id= "rptid" class="bg-indigo-100 w-full" onchange="myFunction()" >
                                    {{-- <option value="" selected>--Report Type</option> --}}
                                    @foreach ($frmrptparamtrs as $frmrptparamtr)
                                        <option value="{{ $frmrptparamtr->id }}">{{ $frmrptparamtr->mytitle }}</option>
                                    @endforeach
                                </select>


                                <div  class="mt-2">
                                <x-label for="" value="Godown Selection"/>
                                <select autocomplete="on" required name="gdid" id= "gdid" class="bg-indigo-100 w-full"  >
                                    <option value="" selected>--Godown Selection</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->title }}</option>
                                    @endforeach
                                </select>
                             </div>


                                <div  class="mt-4 float-right">
                                    <x-input-date title="From" req id="fromdate" name="fromdate" required/>
                                </div>

                                <div  class="mt-2 float-right">
                                    <x-input-date title="To" req id="todate" name="todate" required/>
                                </div>

                                <div  class="mt-6">
                                    <x-button
                                        id="submitbutton" onclick="printselection()"
                                        class="bg-green-500 text-white rounded hover:bg-green-700 inline-flex items-center px-4 py-1  text-center float-right my-2">
                                        <i class="fa fa-print fa-fw"></i>
                                        Print Stock Reports
                                    </x-button>
                                    </div>

                            </form>
                            <input type="text" title="t1"  id="p1" name="p1" value="0" hidden   >
                        </div>





                    {{-- Listing --}}
                    <div class="px-4 pb-14 border rounded-md w-full">
                        {{-- tabulator component --}}
                        <x-tabulator />
                    </div>
                </div>
            </div>
        </div>
    </div>







@push('scripts')
<script src="{{ asset('js/tabulator.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>

@endpush





@push('scripts')
<script>

    var copyIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-copy text-red-600'></i>";};
    var editIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-edit text-blue-600'></i>";};
    var deleteIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-trash text-red-600'></i>";};
    var printIcon = function(cell, formatterParams, onRendered){ return "<i class='fa fa-print text-pink-500'></i>";};


    const getMaster = @json(route('materials.master'));

    let table;
    let searchValue = "";


    let csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
    function printselection()
    {

        var sid = document.getElementById("rptid");
            var rptid = sid.options[sid.selectedIndex].value;
            var fromdate = document.getElementById("fromdate").value;
            var todate = document.getElementById("todate").value;
            var gdid = document.getElementById("gdid").value;


        var selectedData = table.getSelectedData()
        var ids = []
        selectedData.forEach(e => {
            ids.push(e.id)
        });

        // console.log(rptid, fromdate, todate, ids )


        fetch(@json(route('materials.printselected')),{
            credentials: 'same-origin', // 'include', default: 'omit'
            method: 'POST', // 'GET', 'PUT', 'DELETE', etc.
            // body: formData, // Coordinate the body type with 'Content-Type'
            body:JSON.stringify({rptid: rptid, ids: ids , from: fromdate , to : todate,gdwn:gdid }),
            headers: new Headers({
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token":csrfToken
            }),
        })
        .then(response => response.blob() )
        .then( blob => {
            download(blob,"mulit-contract123.pdf")
        })
        .catch(error => {
            console.log(error)
            showSnackbar("Errors occured","red");
        })

    }


    //  Table Filter







    function dataFilter(element)
    {
        searchValue = element.value;
        table.setData(getMaster,{search:searchValue});
    }
    // The Table for Items Modal














    table = new Tabulator("#tableData", {
        width:"100px",
        autoResize:true,
        responsiveLayout:"collapse",
        layout:"fitData",
        index:"id",
        placeholder:"No Data Available",
        pagination:true,
        paginationMode:"remote",
        sortMode:"remote",
        filterMode:"remote",
        paginationSize:20,
        paginationSizeSelector:[10,25,50,100,500,1000],
        ajaxParams: function(){
            return {search:searchValue};
        },
        ajaxURL: getMaster,
        ajaxContentType:"json",
        initialSort:[ {column:"id", dir:"desc"} ],
        height:"100%",

        columns:[
            // Master Data
            {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
        cell.getRow().toggleSelect();
        }},


            {title:"Id", field:"id" , responsive:0},
            {title:"Category", field:"source" ,  responsive:0},
            {title:"Item", field:"category" ,  responsive:0},
            {title:"Dimension", field:"dimension" ,  responsive:0},
            {title:"Specification", field:"brand" ,  responsive:0},
            {title:"Complete Name", field:"title" , visible:true ,headerSortStartingDir:"asc" , responsive:0},
             {title:"Searching", field:"srchb" , headerSortStartingDir:"asc" , responsive:0},

            //  {title:"Nick", field:"nick" , visible:true , responsive:0},

            // {title:"source_id", field:"source_id",visible:false ,  responsive:0},
            // {title:"brand", field:"brand" ,  responsive:0},
            // {title:"Status", field:"status" ,  responsive:0,
            //     formatter:function(cell){
            //         if(cell.getData().status === 1)
            //         {
            //             table.hideColumn('unlock')
            //             table.showColumn('lock')
            //         }else{
            //             table.showColumn('unlock')
            //             table.hideColumn('lock')
            //         }
            //     return cell.getData().status === 1 ? 'Active':'Locked';
            // }},

            {title:"Copy",formatter:copyIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e,cell){
                          window.open(window.location + "/" + cell.getData().id + "/copyMaterial"  ,"_self");

                }
            },

            {title:"Edit" , formatter:editIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getData().id + "/edit" ,"_self");
            }},
            {title:"Delete" , formatter:deleteIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id + "/deleterec"   ,"_self");
                }
            },
            {title:"Print" , formatter:printIcon, hozAlign:"center",headerSort:false, responsive:0,
                cellClick:function(e, cell){
                    window.open(window.location + "/" + cell.getRow().getData().id + "/printcontract"  ,"_self");
                }
            },





            // {title:"Lock",field:'lock' , formatter:lockIcon, hozAlign:"center",headerSort:false, responsive:0,
            //     cellClick:function(e,cell){
            //         if(confirm('Do you really want to Lock this Bank?'))
            //         {
            //             window.open(window.location + "/" + cell.getData().id  ,"_self");
            //         }
            //     }
            // }

        ],

        // Extra Pagination Data for End Users
        ajaxResponse:function(getDataUrl, params, response){
            remaining = response.total;
            let doc = document.getElementById("example-table-info");
            doc.classList.add('font-weight-bold');
            doc.innerText = `Displaying ${response.from} - ${response.to} out of ${remaining} records`;
            return response;
        },
    })

</script>
@endpush

@push('scripts')
<script>
    const category = document.getElementById('category')
    const source = document.getElementById('source')
    const brand = document.getElementById('brand')
    const dimension = document.getElementById('dimension')
    const sku = document.getElementById('sku')

    function getHiddenValues(el)
    {
        switch (el.name)
        {
            case 'category_id':
                category.value = el.options[el.selectedIndex].innerText
                break;
            case 'sku_id':
                sku.value = el.options[el.selectedIndex].innerText
                break;
            case 'brand_id':
                brand.value = el.options[el.selectedIndex].innerText
                break;
            case 'source_id':
                source.value = el.options[el.selectedIndex].innerText
                break;
            case 'dimension_id':
                dimension.value = el.options[el.selectedIndex].innerText
                break;
        }
    }

    function myFunction() {
        var x = document.getElementById("rptid").value;
        p1.value=x;
        // document.getElementById("demo").innerHTML = x;
    }



</script>
@endpush




</x-app-layout>

