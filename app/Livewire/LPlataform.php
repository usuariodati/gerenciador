<?php

namespace App\Livewire;

use App\Models\Plataform;
use Livewire\Component;
use Livewire\WithPagination;

class LPlataform extends Component
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
        $plataforms = Plataform::where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'PlataformPage');
        return view('livewire.l-plataform', compact(
            'plataforms'
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

        Plataform::updateOrCreate(['id' => $this->category_id], [
            'name' => $this->name,
        ]);

        session()->flash('success', $this->category_id ? 'Plataform updated' : 'Plataform cretad');
        $this->close();
    }

    public function edit($id) {
        $plataform = Plataform::findOrFail($id);

        $this->category_id = $plataform->id;
        $this->name = $plataform->name;

        $this->open = true;
    }

    public function delete($id) {
        $plataform = Plataform::findOrFail($id);
        $plataform->delete();

        session()->flash('Plataform removed!');
    }
}
