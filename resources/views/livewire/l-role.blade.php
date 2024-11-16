<div class="card container-fluid p-3">
    @if (session()->has('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    @if ($open)
        <form class="mt-3" wire:submit.prevent="store">
            <div class="form-floating mt-3">
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                <label for="name">Nome<span class="text-danger">*</span></label>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            @forelse ($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" id="permission_{{ $permission->id }}"
                        class="form-check-input" wire:model="selectedPermissions"
                        value="{{ $permission->name }}"
                        @if(in_array($permission->name, $selectedPermissions)) checked @endif>
                    <label for="permission_{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                </div>
            @empty
                
            @endforelse

            <div class="mt-3 d-flex justify-content-evenly">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" wire:click="close">Cancelar</button>
            </div>
        </form>
    @else
    <div class="d-flex justify-content-evenly">
        <button class="mt-3 btn btn-primary" wire:click="create">Criar</button>
    </div>
    @endif

    <table class="mt-3 table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Permissões</th>
                <th>editar</th>
                <th>excluir</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @forelse ($role->permissions as $permission)
                            {{ $permission->name }} @if(!$loop->last), @endif
                        @empty
                            sem permissões
                        @endforelse
                    </td>
                    <td>
                        <button class="btn btn-warning" wire:click="edit({{ $role->id }})">Editar</button>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="edit({{ $role->id }})">Excluir</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Sem registros</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $roles->links(data: ['scrollTo' => false]) }}
</div>
