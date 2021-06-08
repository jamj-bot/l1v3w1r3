<div>
    <a class="btn btn-green" wire:click="$set('open', true)">
    	<i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">
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
    		<x-jet-secondary-button wire:click="$set('open', false)">
    			Cancel
    		</x-jet-secondary-button>

			<x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-20">
				<i class="fas fa-fw fa-spinner fa-spin" wire:loading wire:target="save"></i> Save
    		</x-jet-danger-button>
    	</x-slot>
    </x-jet-dialog-modal>
</div>
