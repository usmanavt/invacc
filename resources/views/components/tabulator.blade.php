<div class="flex justify-between items-center py-2">
    <div class="flex flex-row relative">
        <i class="fa fa-search fa-fw text-indigo-500 absolute top-1 left-1"></i>
        <input type="text" class="pl-8 border focus:ring focus:ring-indigo-500 h-8" id="data_filter" onkeyup="dataFilter(this)" placeholder="Search here...">
    </div>
    <div id="example-table-info" class="mr-2 text-sm text-gray-500"></div>
</div>

<div id="tableData" class="py-2">
    {{-- tabulator Data --}}
</div>