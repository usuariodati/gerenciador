<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LRole extends Component
{
    use WithPagination;

    public $role_id;
    public $name;
    public $selectedPermissions = [];
    public $query = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $roles = Role::with('permissions')
            ->where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'RolePage');
        $permissions = Permission::all();
        return view('livewire.l-role', compact(
            'roles',
            'permissions'
        ));
    }

    public function clearFields() {
        $this->role_id = null;
        $this->name = '';
        $this->selectedPermissions = [];
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

        $role = Role::updateOrCreate(['id' => $this->role_id], [
            'name' => $this->name,
        ]);

        $role->syncPermissions($this->selectedPermissions);

        session()->flash('success', $this->role_id ? 'Role updated' : 'Role cretad');
        $this->close();
    }

    public function edit($id) {
        $role = Role::findOrFail($id);

        $this->role_id = $role->id;
        $this->name = $role->name;

        $this->selectedPermissions = $role->permissions()->pluck('name')->toArray();

        $this->open = true;
    }
}
