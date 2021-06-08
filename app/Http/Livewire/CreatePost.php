<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;


class CreatePost  extends Component
{
	use WithFileUploads;

	public $open = false;
	public $title, $content, $image, $identificator;

	protected $rules = [
		'title' => 'required',
		'content' => 'required',
		'image' => 'required|image|max:2048'
	];

	public function mount()
	{
		$this->identificator = rand();
	}


	# Real time validation
	// public function updated($propertyName)
	// {
	// 	$this->validateOnly($propertyName);
	// }


	public function save()
	{
		$this->validate();

		$image = $this->image->store('posts');

		Post::create([
			'title' => $this->title,
			'content'  => $this->content,
			'image' => $image
		]);

		$this->reset(['open', 'title', 'content', 'image']);

		$this->identificator = rand();

		$this->emitTo('show-posts', 'render');
		$this->emit('alert', 'Post has been created!');
	}

    public function render()
    {
        return view('livewire.create-post');
    }
}
