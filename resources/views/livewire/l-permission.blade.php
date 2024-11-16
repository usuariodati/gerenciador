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
                <th>editar</th>
                <th>excluir</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button class="btn btn-warning" wire:click="edit({{ $permission->id }})">Editar</button>
                    </td>
                    <td>
                        <button class="btn btn-danger" wire:click="edit({{ $permission->id }})">Excluir</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Sem regsitros</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $permissions->links(data: ['scrollTo' => false]) }}
</div>
