<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Item Size') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                {{-- Create Form --}}
                <div class="px-12 py-2" >
                    <form action="{{ route('itemsize.store') }}" method="post">
                        @csrf
                        <div class="flex flex-row justify-start space-x-12 items-center">
                            <x-label for="sizename" :value="__('Item Size ')" />
                            <x-input   id="sizename" class="block mt-2 bg-slate-200 w-96" type="text" />
                        </div>
                        <div class="flex flex-row justify-start space-x-12 items-center">
                            <x-label for="sizenname" :value="__('Knick Name')" />
                            <x-input  id="sizenname" class="block mt-2 bg-slate-200" type="text"/>
                        </div>

                        <div class="mt-2">
                            <button class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fa fa-save fa-fw bg-green-900"></i>
                                {{ __('Submit') }}
                            </button>
                        </div>


                        <div class="container">
                            <table id="mytable">
                                <thead>
                                    <tr>
                                        <th> Item Size </th>
                                        <th> Item Knick Name </th>
                                        <th> Age </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Populate dynamically --}}
                                </tbody>
                            </table>
                        </div>

                        <a onclick="addRow(event);" class="bg-indigo-600 text-white border p-1"> Add </a>
                        <a onclick="editRow(event);" class="bg-indigo-600 text-white border p-1"> Edit </a>
                        <a onclick="deleteRow(event);" class="bg-indigo-600 text-white border p-1"> Delete </a>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
<script>
    var rowIndex = 0;
    var tbodyEl;
    var sizename,sizenname;
    var submitAllowed=false;
    var table;

    document.addEventListener('DOMContentLoaded',function(){
        tbodyEl = document.querySelector('tbody');
        // table = document.getElementById("mytable")
        sizename=document.getElementById("sizename");
        sizenname=document.getElementById("sizenname");
    })
    //  Function in Use
    function checkEmptyInput()
    {
        if (sizename.value == "") {
            alert("First name cat not empty")
            sizename.focus();
            submitAllowed = false;
            return;
        }
        else if (sizenname.value == "") {
            alert("Last name cat not empty")
            sizenname.focus();
            submitAllowed = false;
            return;
        }
        else {
            submitAllowed = true;
        }

    }
    //  Function in Use
    function addRow(event)
    {
        event.preventDefault();
        checkEmptyInput();
        if(submitAllowed)
        {
            var tr = document.createElement('tr');
            tr.innerHTML = `
                <tr >
                    <td><input type="text" name="sizenamepost[]" id="sizenamepost"  value="${sizename.value}" /></td>
                    <td><input type="text" name="sizennamepost[]" id="sizennamepost" value="${sizenname.value}" /></td>
                    <td><select>
                        <option value="1">Hello</option>
                        <option value="2">SHello</option>
                        </select></td>
                </tr>
                `;  // Append Tr & TD directly
            tbodyEl.appendChild(tr);
            SelectedRowToInput();
            sizename.value = "";   // Clear
            sizenname.value = "";  // Clear
            sizename.focus();  // Set Focus on Input
        }

        // for(var i=1;i < table.rows.length;i++)
        // {
        //     table.rows[i].onclick=function()

        //     {
        //         rindex=this.rowIndex;
        //         // console.log(rindex);
        //         document.getElementById("sizenamepost").value=this.cells[0].innerHTML;
        //         document.getElementById("sizennamepost").value=this.cells[1].innerHTML;

        //     };
        // }
    }

    function edit(e)
    {
        console.log(e.parentElement.nodeName)
    }

    // SelectedRowToInput();
    function editRow(event)
    {
        event.preventDefault();
        // var fname = document.getElementById("fname").value,
        //     lname = document.getElementById("lname").value,
        //     age = document.getElementById("age").value;

        //     table.rows[rindex].cells[0].innerHTML = fname;
        //     table.rows[rindex].cells[1].innerHTML = lname;
        //     table.rows[rindex].cells[2].innerHTML = age;
        //     rindex=-1;
    }

    function deleteRow(event)
    {
        event.preventDefault();

        // table.deleteRow(rindex);
        // document.getElementById("fname").value="";
        // document.getElementById("lname").value="";
        // document.getElementById("age").value="";

    }


    function SelectedRowToInput()
{


for(var i=1;i < mytable.rows.length;i++)
{
    mytable.rows[i].onclick=function()

{
    rindex=this.rowIndex;
    // console.log(rindex);
    document.getElementById("sizename").value=this.cells[0].innerHTML;
    document.getElementById("sizenname").value=this.cells[1].innerHTML;
        console.log( " INDEX= " + rindex)
};

}

}






    </script>


