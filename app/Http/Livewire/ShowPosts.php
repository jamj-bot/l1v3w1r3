<?php

namespace App\Http\Livewire;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;

	public $post, $image, $identificator;
    public $search = '';
	public $sort = 'id';
	public $direction = 'desc';
    public $open_edit = false;
    public $quantity = '10';
    public $readyToLoad = false;
	protected $listeners = ['render'];

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
        // 'image' => 'required|image|max:2048'
    ];

    protected $queryString = [
        'quantity' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];

    public function mount(Post $post)
    {
        $this->identificator = rand();
        $this->post = new Post();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        if ($this->readyToLoad) {
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->quantity);
        } else {
            $posts = [];
        }


        return view('livewire.show-posts', compact('posts'));
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function order($sort)
    {
    	if ($this->sort == $sort) {
    		if ($this->direction == 'desc') {
    			$this->direction = 'asc';
    		} else {
    			$this->direction = 'desc';
    		}
    	} else {
    		$this->sort = $sort;
    		$this->direction = 'asc';
    	}
    }

    public function edit(Post $post)
    {
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }

        $this->post->save();

        $this->reset(['open_edit', 'image']);

        $this->identificator = rand();

        $this->emit('alert', 'Post has been updated!');
    }
}
