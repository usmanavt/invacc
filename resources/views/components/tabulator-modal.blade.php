{{-- Modal --}}
<div id="myModal" class="fixed hidden bg-gray-300 bg-opacity-70 duration-500 mx-auto z-10 h-full w-full top-0">

    <!-- Modal content -->
    <div class="max-w-3xl mx-auto mt-52 bg-white rounded shadow px-6">
        <div class="flex justify-between py-4">
            <h1 class="font-semibold">Material List</h1>
            <span class="close px-2 bg-gray-300 rounded-full text-white cursor-pointer hover:bg-gray-400" onclick="closeModal()">&times;</span>
        </div>
        <div class="">
            <div class="flex flex-row relative">
                <i class="fa fa-search fa-fw text-indigo-500 absolute top-1 left-1"></i>
                <input type="text" class="pl-8 border focus:ring focus:ring-indigo-500 h-8" id="data_filter" onkeyup="dataFilter(this)" placeholder="Search here...">
            </div>
                <div id="example-table-info" class="mr-2 text-sm text-gray-500"></div>
            </div>
            
            <div id="tableData">
                {{-- table data --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let table;
let searchValue = "";
//  ---------------- For MODAL -----------------------//
//  Table Filter
function dataFilter(element)
{
    searchValue = element.value;
    table.setData(getMaster,{search:searchValue});
}
// The Table for Materials Modal
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
    paginationSize:20,                      
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
    //  Filter Data here . 
    var result = dynamicTableData.filter( dt => dt.material_id == data.id)
    if(result.length <= 0)
    {
        pushDynamicData(data)
    }

})
// -----------------FOR MODAL -------------------------------//
//  Modal Functions
function showModal(){ modal.style.display = "block"}
function closeModal(){  modal.style.display = "none"}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
    modal.style.display = "none";
  }
} 

</script>
@endpush