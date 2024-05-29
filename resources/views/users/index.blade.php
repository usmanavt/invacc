
<x-app-layout>

    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('users.create')}}">
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2> --}}

    </x-slot>


    @push('styles')
    <script scr="https://cdn.tailwindcss.com"></script>
    @endpush





    <div class="py-6">
        @extends('layouts.auth')
        <div class="max-w-3xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Search Form --}}
                <x-search >
                    {{ route('users.index') }}
                </x-search>

                {{-- Table --}}
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
						<div class="px-4 bg-white border-b border-gray-200">
                            <table class="min-w-full divided-y divide-gray-500">
								<thead>
									<tr>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</td>
                                    </tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($users as $user)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$user->name}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$user->email }}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('users.edit',$user->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>Edit
                                                </a>
                                                {{-- <a class="text-sm text-indigo-500 hover:text-gray-900" href="#">
                                                    <i class="fa fa-key text-red-600 fa-fw "></i>Chng Pass
                                                </a> --}}
                                            </td>

										</tr>
									@endforeach.
								</tbody>
							</table>

						</div>
					</div>
                </div>

                {{-- Pagination --}}
                <x-pagination>
                    {{ $users->links() }}
                </x-pagination>

            </div>
        </div>

        </div>


        {{-- <div class=" w-full h-[100vh] bg-slate-200 flex justify-center items-center flex-col ">
            <div class="w-96 relative"   onclick="event.stopImmediatePropagation();" >
                <input id="autocompleted" placeholder="Select Conuntry Name" class="px-5 py-3 w-full border border-gray-400 rounded-md"
                onkeyup="onkeyUp(event)" />
                <div>
                    <select  id="head_id" name="head_id" size="20"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </select>
                </div>
            </div>
        </div>

<script>
const addSelectElement = (select,id,value) => {
        var option = document.createElement('option')
        option.value = id
        option.text  = value
        select.appendChild(option)
    }

myarray=@json($resultArray);
const contries = myarray;
function onkeyUp(e)
{
    let keyword= e.target.value;
    var head_id = document.getElementById("head_id");
    head_id.classList.remove("hidden");

    let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));
    console.log(filteredContries);
    renderOptions(filteredContries);
    //  var vindx=-1;
}


// document.addEventListener('DOMContentLoaded',()=> {
//     renderOptions(contries);
//         });

function renderOptions(xyz){

    let dropdownEl=document.getElementById("head_id");

                dropdownEl.length = 0
                xyz.forEach(e => {
                    addSelectElement(dropdownEl,e.id,e.title)
                });
}

document.addEventListener("click" , () => {
    hidedropdown();
});


function hidedropdown()
{
    var head_id = document.getElementById("head_id");
    head_id.classList.add("hidden");
}


head_id.addEventListener("click", () => {

    let head_id= document.getElementById("head_id");
    let input= document.getElementById("autocompleted");
    input.value=head_id.options[head_id.selectedIndex].text;
    hidedropdown();
});


head_id.addEventListener("keyup", function(event) {
if (event.keyCode === 13) {
event.preventDefault();
let head_id= document.getElementById("head_id");
    let input= document.getElementById("autocompleted");
    input.value=head_id.options[head_id.selectedIndex].text;
    hidedropdown();

}
});


// autocompleted.addEventListener("keyup", function(event) {

// if (event.keyCode === 40) {
//     event.preventDefault();
//     vindx=vindx+1;
//     let head_id= document.getElementById("head_id");
//     // alert(vindx);
//     head_id.selectedIndex=vindx;
// }

// if (event.keyCode === 38) {
//     event.preventDefault();
//     vindx=vindx-1;
//     let head_id= document.getElementById("head_id");
//     // alert(vindx);
//     head_id.selectedIndex=vindx;
// }

// if (event.keyCode === 13) {
// event.preventDefault();
// let head_id= document.getElementById("head_id");
//     let input= document.getElementById("autocompleted");
//     input.value=head_id.options[head_id.selectedIndex].text;
//     hidedropdown();

// }

// }); --}}






</script>

</x-app-layout>
