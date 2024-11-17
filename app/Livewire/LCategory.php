<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class LCategory extends Component
{
    use WithPagination;

    public $category_id;
    public $name;
    public $query = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }


    public function render()
    {
        $categories = Category::where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'CategoryPage');
        return view('livewire.l-category', compact(
            'categories'
        ));
    }

    public function clearFields() {
        $this->category_id = null;
        $this->name = '';
    }

    public function create() {
        $this->clearFields();
        $this->open = true;
    }

    public function close() {
        $this->open = false;
        $this->clearFields();
    }

    public function store() {
        $this->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Campo obrigatório',
        ]);

        Category::updateOrCreate(['id' => $this->category_id], [
            'name' => $this->name,
        ]);

        session()->flash('success', $this->category_id ? 'Category updated' : 'Category cretad');
        $this->close();
    }

    public function edit($id) {
        $category = Category::findOrFail($id);

        $this->category_id = $category->id;
        $this->name = $category->name;

        $this->open = true;
    }

    public function delete($id) {
        $category = Category::findOrFail($id);
        $category->delete();
    }
}
