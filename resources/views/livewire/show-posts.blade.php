<div wire:init="loadPosts">

	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    	<!-- This example requires Tailwind CSS v2.0+ -->

    	<x-table>

    		<div class="px-6 py-3 flex items-center">

    			<div class="flex items-center">
    				<span>Show</span>

    				<select wire:model="quantity" class="mx-2 form-control">
    					<option value="10">10</option>
    					<option value="25">25</option>
    					<option value="50">50</option>
    					<option value="100">100</option>
    				</select>

    				<span>entries</span>
    			</div>

    			<x-jet-input class="flex-1 mx-4" placeholder="Find a post" type="text" wire:model="search" />
    			@livewire('create-post')
    		</div>

    		@if(count($posts))
		        <table class="min-w-full divide-y divide-gray-200">
		          	<thead class="bg-gray-50">
			            <tr>
			              	<th scope="col" class="w-24 cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" wire:click="order('id')">
			                	ID
			                	@if($sort == 'id')
				                	@if($direction == 'asc')
					                	<i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				                	@else
				                		<i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
				                	@endif
			                	@else
			                		<i class="fas fa-sort float-right mt-1"></i>
			                	@endif
			              	</th>
			              	<th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" wire:click="order('title')">
			                	Title
			                	@if($sort == 'title')
				                	@if($direction == 'asc')
					                	<i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				                	@else
				                		<i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
				                	@endif
			                	@else
			                		<i class="fas fa-sort float-right mt-1"></i>
			                	@endif
			              	</th>
			              	<th scope="col" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" wire:click="order('content')">
			                	Content
			                	@if($sort == 'content')
				                	@if($direction == 'asc')
					                	<i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
				                	@else
				                		<i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
				                	@endif
			                	@else
			                		<i class="fas fa-sort float-right mt-1"></i>
			                	@endif
			              	</th>
			              	<th scope="col" class="relative px-6 py-3">
			                	<span class="sr-only">Edit</span>
			              	</th>
			            </tr>
		          	</thead>
		          	<tbody class="bg-white divide-y divide-gray-200">
		          		@foreach($posts as $item)
				            <tr>
				              	<td class="px-6 py-4">
					                <div class="text-sm text-gray-900">
					                	{{ $item->id}}
					                </div>
				              	</td>
				              	<td class="px-6 py-4">
					                <div class="text-sm text-gray-900">
					                	{{ $item->title}}
					                </div>
				              	</td>
				      			<td class="px-6 py-4 text-sm text-gray-500">
				            		<div class="text-sm text-gray-900">
					                	{{ $item->content}}
					                </div>
				              	</td>
				              	<td class="px-6 py-4 text-sm font-medium">
				                	{{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}}
				                	<a class="btn btn-green" wire:click="edit({{ $item }})">
    									<i class="fas fa-edit"></i>
    								</a>
				              	</td>
				            </tr>
			            @endforeach

		            <!-- More people... -->
		          	</tbody>
		        </table>
			    @if($posts->hasPages())
				    <div class="px-6 py-3">
				    	{{ $posts->links() }}
				    </div>
			    @endif

		    @else
		    	<div class="flex justify-center">
		    		<i class="fas fa-fw fa-spinner fa-spin text-6xl text-gray-800 m-5" wire:loading></i>
		    	</div>
			    <div class="px-6 py-3" wire:loading.remove>
			    	Sorry, no results found for <b>'{{$search}}'</b>. Please, try another search.
	    		</div>
		    @endif
	    </x-table>
    </div>

    <x-jet-dialog-modal wire:model="open_edit">
    	<x-slot name="title">
    		Edit post
    	</x-slot>

    	<x-slot name="content">
    		<div wire:loading wire:target="image" class="mb-4 w-full bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
			 	<p class="font-bold">Uploading image</p>
			 	<p class="text-sm">Please wait a moment while the image upload.</p>
			  	<i class="fas fa-sync fa-spin"></i>
			</div>

			@if($image)
    			<img class="mb-4" src="{{ $image->temporaryUrl() }}">
    		@else
    			<img class="mb-4" src="{{ Storage::url($post->image) }}">
    		@endif

    		<div class="mb-4">
    			<x-jet-label value="Title"/>
    			<x-jet-input wire:model="post.title" type="text" class="w-full"/>
    			<x-jet-input-error for="title" />
    		</div>

    		<div class="mb-4">
    			<x-jet-label value="Content"/>
    			<textarea wire:model="post.content"class="form-control w-full" rows="6"></textarea>
    			<x-jet-input-error for="content" />
    		</div>

	    	<div class="mb-4">
				<input type="file" wire:model="image" id="{{ $identificator }}">
				<x-jet-input-error for="image" />
			</div>
    	</x-slot>

    	<x-slot name="footer">
    		<x-jet-secondary-button wire:click="$set('open_edit', false)">
    			Cancel
    		</x-jet-secondary-button>

			<x-jet-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="update, image" class="disabled:opacity-20">
				<i class="fas fa-fw fa-spinner fa-spin" wire:loading wire:target="update"></i> Save
    		</x-jet-danger-button>
    	</x-slot>
    </x-jet-dialog-modal>

</div>
