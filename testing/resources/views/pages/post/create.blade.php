<?php
 
use Livewire\Component;
use App\Models\Post;
 
new class extends Component {
    public string $title = '';
 
    public string $content = '';
 
    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create($validated);

        return $this->redirect('/posts');
    }
};
?>
 
<form wire:submit="save">
    <label>
        Title
        <input type="text" wire:model="title">
        @error('title') <span style="color: red;">{{ $message }}</span> @enderror
    </label>
 
    <label>
        Content
        <textarea wire:model="content" rows="5"></textarea>
        @error('content') <span style="color: red;">{{ $message }}</span> @enderror
    </label>
 
    <button type="submit">Save Post</button>
</form>
