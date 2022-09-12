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
