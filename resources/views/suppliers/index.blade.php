<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suppliers') }}
            {{-- Create New Supplier --}}
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('suppliers.create')}}">
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
                    {{ route('suppliers.index') }}
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
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</td>

									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($suppliers as $supplier)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->sname}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->snname}}</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->semail}}</td>

											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
												@if($customer->gender=='M')
												MALE
												@elseif ($customer->gender=='F')
												FEMALE
												@elseif ($customer->gender=='O')
												OTHER
											@endif
											</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->obalance}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"> {{$supplier->sfax}}</td> --}}
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->sphoneoff}}</td> --}}
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->sphoneres}}</td> --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->spaddress}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->ntnno}}</td>
											{{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->staxNo}}</td>  --}}
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$supplier->sstatus}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
											@if($supplier->srcId =="1")
											<a href="">
											<span class="badge badge-success">Local </span>
											@ELSE
											<a href="">
											<span class="badge badge-danger">Imported</span>
											@endif
											</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
												{{-- <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('suppliers.show',$supplier)}}">
                                                    <i class="fa fa-binoculars fa-fw"></i>
                                                    View
                                                </a> --}}
											    <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('suppliers.edit',$supplier)}}">
                                                    <i class="fa fa-edit fa-fw"></i>
                                                    Edit
                                                </a>
                                                {{-- onsubmit="return confirm('Are you sure you want to delete Recorde?');" --}}
												{{-- <form class="inline-block" href="{{ route('suppliers.destroy',['id'=> $supplier->id]) }}" >
                                                    <i class="fa fa-trash text-red-600 fa-fw "></i>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                                                    {{-- <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete"> --}}
                                                {{-- </form> --}}
                                                <a class="text-sm text-indigo-500 hover:text-red-900" href="{{route('suppliers.destroy',$supplier->id)}}" onsubmit="return confirm('Are you sure you want to delete Recorde?');">
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
                    {{ $suppliers->links() }}
                </x-pagination>

            </div>
        </div>
    </div>
</x-app-layout>
