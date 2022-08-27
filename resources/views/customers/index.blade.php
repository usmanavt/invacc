<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('customers.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Search Form --}}
                <x-search >
                    {{ route('customers.index') }}
                </x-search>

                {{-- Table --}}
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
						<div class="px-4 bg-white border-b border-gray-200">
                            <table class="min-w-full divided-y divide-gray-500">
								<thead>
									<tr>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</td>
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KnickName</td> --}}
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">O/Balance</td>
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FaxNo</td> --}}
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone-Office</td> --}}
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone-Res.</td> --}}
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NTN.No</td>
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rej.No</td> --}}
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Care of</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</td>

									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($customers as $customer)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cname}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->snname}}</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cemail}}</td>

											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
												@if($customer->gender=='M')
												MALE
												@elseif ($customer->gender=='F')
												FEMALE
												@elseif ($customer->gender=='O')
												OTHER
											@endif
											</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->obalance}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"> {{$customer->sfax}}</td> --}}
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cphoneoff}}</td> --}}
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cphoneres}}</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cpaddress}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->ntnno}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->staxNo}}</td>  --}}
									        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->cstatus}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->coname}}</td>
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
												{{-- <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('customers.show',$customer)}}">
                                                    <i class="fa fa-binoculars fa-fw"></i>
                                                    View
                                                </a> --}}
											    <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('customers.edit',$customer->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>
                                                    Edit
                                                </a>
                                                {{-- onsubmit="return confirm('Are you sure you want to delete Recorde?');" --}}
												{{-- <form class="inline-block" href="{{ route('customers.destroy',['id'=> $customer->id]) }}" >
                                                    <i class="fa fa-trash text-red-600 fa-fw "></i>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                                                    {{-- <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete"> --}}
                                                {{-- </form> --}}
                                                <a class="text-sm text-indigo-500 hover:text-red-900" href="{{route('customers.destroy',$customer->id)}}" >
                                                    <i class="fa fa-trash text-red-600 fa-fw "></i>
                                                    Delete
                                                </a>




                                            </td>

										</tr>
									@endforeach.
								</tbody>
							</table>

						</div>
					</div>
                </div>

                {{-- Pagination --}}
                {{-- <x-pagination>
                    {{ $customers->links() }}
                </x-pagination> --}}

            </div>
        </div>
    </div>
</x-app-layout>

