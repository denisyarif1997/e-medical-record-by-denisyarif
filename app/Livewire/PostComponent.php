<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostComponent extends Component
{
    public $posts, $title, $content, $postId;
    public $isOpen = 0;

    public function render()
    {
        $this->posts = Post::all(); // Fetch all posts
        return view('livewire.post-component');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->content = '';
        $this->postId = null;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // If $postId is null, create a new post; otherwise, update the existing post
        Post::updateOrCreate(
            ['id' => $this->postId],
            [
                'title' => $this->title,
                'content' => $this->content,
            ]
        );

        session()->flash('message', $this->postId ? 'Post updated successfully.' : 'Post created successfully.');

        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->openModal();
    }

    public function delete($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully.');
    }
}
