<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Materials
            <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('materials.create')}}">
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
                    {{ route('materials.index') }}
                </x-search>

                {{-- Table --}}
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto">
						<div class="px-4 bg-white border-b border-gray-200">
                            <table class="min-w-full divided-y divide-gray-500">
								<thead>
									<tr>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</td>
										<td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nick</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dimension</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sku</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</td>
                                        <td class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</td>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">
									@foreach($materials as $material)
										<tr class="border-b">
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->title}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->nick}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->category}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->brand}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->source}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->dimension}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->sku}}</td>
											<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$material->status == 1 ? 'Active':'Deactive'}}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a class="text-sm text-green-500 hover:text-gray-900" href="{{route('materials.copy',$material)}}">
                                                    <i class="fa fa-copy fa-fw"></i>
                                                    Copy
                                                </a>
                                                <a class="text-sm text-indigo-500 hover:text-gray-900" href="{{route('materials.edit',$material->id)}}">
                                                    <i class="fa fa-edit fa-fw"></i>
                                                    Edit
                                                </a>
                                                <a class="text-sm text-indigo-500 hover:text-red-900" href="#" >
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
                    {{ $materials->links() }}
                </x-pagination>

            </div>
        </div>
    </div>
</x-app-layout>
