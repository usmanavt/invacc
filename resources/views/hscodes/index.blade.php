<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hscodes
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('hscodes.create')}}">
                {{-- Add Icon --}}
                <i class="fa fa-file fa-fw"></i>
                Add New Record
            </a>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Search Form --}}
                <x-search >
                    {{ route('hscodes.index') }}
                </x-search>

                {{-- Table --}}
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
						<div class="px-4 bg-white border-b border-gray-200">
                            <table class="min-w-full divided-y divide-gray-500">
								<thead>
									<tr>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hscode</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CD</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ST</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RD</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ACD</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AST</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IT</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WSE</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</td>
                                    </tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($hscodes as $HSCODE)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->hscode}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->cd}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->st}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->rd}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->acd}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->ast}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->it}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$HSCODE->wse}}</td>

											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('hscodes.edit',$HSCODE->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>Edit
                                                </a>
                                                
                                                <a class="text-sm text-indigo-500 hover:text-gray-900" href="#">
                                                    <i class="fa fa-trash text-red-600 fa-fw "></i>Delete
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
                    {{ $hscodes->links() }}
                </x-pagination>

            </div>
        </div>
    </div>
</x-app-layout>
