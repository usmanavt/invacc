<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Group Relation') }}
            {{-- Create New Customer --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('grouprelations.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-9xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Search Form --}}
                <x-search >
                    {{ route('grouprelations.index') }}
                </x-search>

                {{-- Table --}}
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
						<div class="px-4 bg-white border-b border-gray-200">
                            <table class="min-w-full divided-y divide-gray-500">
								<thead>
									<tr>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</td>
										{{-- <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KnickName</td> --}}
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Size</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">W.House/Shop</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Unit</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">O/Balance</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Rate</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost Rate</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Status</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</td>
                                    </tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($grouprelations as $grouprelation)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->iname0}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->iname}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->sizename }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->srcname }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->brandname }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->locname }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->unitname }}</td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->obqty }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->purrate }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->costrate }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$grouprelation->sstatus }}</td>

                                        </td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
											    <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('grouprelations.edit',$grouprelation->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>
                                                    Edit
                                                </a>
                                                <a class="text-sm text-indigo-500 hover:text-red-900" href="{{route('grouprelation.destroy',$grouprelation->id)}}" >
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
                    {{ $subheads->links() }}
                </x-pagination> --}}

            </div>
        </div>
    </div>
</x-app-layout>

