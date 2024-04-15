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


        <div class=" w-full h-[100vh] bg-slate-200 flex justify-center items-center flex-col ">
        <div class="w-96 relative" onkeyup="handleEvt(event,this, 1)"  onclick="event.stopImmediatePropagation();" >
            <input id="itemval" placeholder="itemval" />
            <input id="autocompleted" placeholder="Select Conuntry Name" class="px-5 py-3 w-full border border-gray-400 rounded-md"
            onkeyup="onkeyUp(event)"
            />
            <div id="dropdown" class="w-full h-60 border border-gray-300 rounded-md bg-white absolute overflow-y-scroll ">
            </div>




        </div>

        {{-- <div  class="w-96">
            <input placeholder="Select Conuntry Name" class="px-5 py-3 w-full border border-gray-400 rounded-md" />

        </div> --}}

    </div>


<div>

    {{-- let category[] = ''; --}}
    <label for="customer_id">Payment From<x-req /></label>
    <select autocomplete="on"  name="customer_id" id="customer_id" class="col-span-2" >
        @foreach($customers as $customer)
        <option value="{{$customer->id}}"> {{$customer->title}} </option>
        @endforeach

    </select>


</div>






<script>
// console.log($resultArray);
myarray=@json($resultArray);
// console.log(myarray);
// let contries=["PAKISTAN","INDIA","AMERACA","BRAZIL","JERMANY","SAPAIN","FRANCE","RUSSIA","POLAND","OMAN"]

//  let myarray='';
// let myarray=[{"code": "AF", "code3": "AFG", "name": "Afghanistan", "number": "004"},{"code": "AL", "code3": "ALB", "name": "Albania", "number": "008"}]

   const contries = myarray;
//    const contries=[{"code": "AF", "code3": "AFG", "name": "Afghanistan", "number": "004"},{"code": "AL", "code3": "ALB", "name": "Albania", "number": "008"}];
//    console.log(contries);


// dropdownEl.innerHTML=newHtml;



// const contries = [
// 	{"code": "AF", "code3": "AFG", "name": "Afghanistan", "number": "004"},
// 	{"code": "AL", "code3": "ALB", "name": "Albania", "number": "008"},
// 	{"code": "DZ", "code3": "DZA", "name": "Algeria", "number": "012"},
// 	{"code": "UM", "code3": "UMI", "name": "United States Minor Outlying Islands (the)", "number": "581"},
// 	{"code": "EH", "code3": "ESH", "name": "Western Sahara", "number": "732"},
// 	{"code": "YE", "code3": "YEM", "name": "Yemen", "number": "887"},
// 	{"code": "ZM", "code3": "ZMB", "name": "Zambia", "number": "894"},
// 	{"code": "ZW", "code3": "ZWE", "name": "Zimbabwe", "number": "716"},
// 	{"code": "AX", "code3": "ALA", "name": "Åland Islands", "number": "248"}
// ];





function onkeyUp(e)
{
    let keyword= e.target.value;
    var dropdown = document.getElementById("dropdown");
    dropdown.classList.remove("hidden");

    let filteredContries=contries.filter((c)=>c.title.toLowerCase().includes(keyword.toLowerCase()));

    renderOptions(filteredContries);
}


document.addEventListener('DOMContentLoaded',()=> {
    renderOptions(contries);

        });

function renderOptions(options){

    let dropdownEl=document.getElementById("dropdown");

    let newHtml=``;
    options.forEach((country) => {
        newHtml+=`<div onclick="selectOption('${country.title}','${country.id}')" class="px-6 py-3 w-full border-b border-gray-200   text-red-800 cursor-pointer hover:bg-slate-100 transition-colors "> ${country.title}</div>`;

    });

//    console.log(newHtml);
    dropdownEl.innerHTML=newHtml;
    console.log(outerHTML=newHtml);
}

document.addEventListener("click" , () => {
    hidedropdown();
});


function hidedropdown()
{
    var dropdown = document.getElementById("dropdown");
    dropdown.classList.add("hidden");
}


function selectOption(selectedOption,selectedOptionval)
{

    hidedropdown();
    let input= document.getElementById("autocompleted");
    let itemval= document.getElementById("itemval");

    input.value=selectedOption;

    itemval.value=selectedOptionval;

}


</script>






</x-app-layout>
