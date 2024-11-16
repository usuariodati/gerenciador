<?php

namespace App\Livewire;

use App\Traits\PersonalTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class LPermission extends Component
{
    // use WithPagination, PersonalTrait;
    use WithPagination;

    public $permission_id;
    public $name;
    public $query = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $permissions = Permission::where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'PermissionPage');
        return view('livewire.l-permission', compact(
            'permissions'
        ));
    }

    public function clearFields() {
        $this->permission_id = null;
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
            'name.required' => 'Campo obrigatório'
        ]);

        Permission::updateOrCreate(['id' => $this->permission_id], [
            'name' => $this->name
        ]);

        session()->flash('success', $this->permission_id ? 'Permission updated' : 'Permission cretad');
        $this->close();
    }

    public function edit($id) {
        $permission = Permission::findOrFail($id);

        $this->permission_id = $permission->id;
        $this->name = $permission->name;

        $this->open = true;
    }
}
