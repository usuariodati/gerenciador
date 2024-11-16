<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class LUser extends Component
{
    use WithPagination;

    public $user_id;
    public $name;
    public $selectedRoles = [];
    public $query = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('roles')
            ->where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'UserPage');
        $roles = Role::all();
        return view('livewire.l-user',compact(
            'users',
            'roles'
        ));
    }

    public function clearFields() {
        $this->user_id = null;
        $this->name = '';
        $this->selectedRoles = [];
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

        $user = User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
        ]);

        $user->syncRoles($this->selectedRoles);

        session()->flash('success', $this->user_id ? 'User updated' : 'User cretad');
        $this->close();
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->name = $user->name;

        $this->selectedRoles = $user->roles()->pluck('name')->toArray();

        $this->open = true;
    }
}
