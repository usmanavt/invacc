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
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">O/Balance</td>

										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NTN.No</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Care of</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</td>

									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($customers as $customer)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->title}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->email}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->obalance}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->address}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->ntn}}</td>
									        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->status == 1 ? 'Active':'Deactive'}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$customer->care->title}}</td>
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
											    <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('customers.edit',$customer->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>
                                                    Edit
                                                </a>
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
                <x-pagination>
                    {{ $customers->links() }}
                </x-pagination>

            </div>
        </div>
    </div>
</x-app-layout>

