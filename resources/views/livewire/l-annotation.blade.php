<div class="card container-fluid p-0">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="d-inline">Annotation</h3>
            <button class="btn btn-primary" wire:click="create">Criar</button>
        </div>
    </div>

    <div class="card-body">
        @if (session()->has('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif

        @if ($open)
            <div class="form-floating mt-3">
                <select id="course_id" class="form-select" wire:model="course_id">
                    <option>Selecione um curso</option>
                    @forelse ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @empty
                        <option>Sem cursos</option>
                    @endforelse
                </select>
                <label for="course_id">Nome<span class="text-danger">*</span></label>
                @error('course_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        
            <form class="mt-3" wire:submit.prevent="store">
                <div class="form-floating mt-3">
                    <input type="text" id="module" class="form-control" wire:model.defer="module">
                    <label for="module">Módulo<span class="text-danger">*</span></label>
                    @error('module')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="title" class="form-control" wire:model.defer="title">
                    <label for="title">Aula<span class="text-danger">*</span></label>
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <textarea id="content" cols="30" rows="10" class="form-control" wire:model="content"></textarea>
                    <label for="content">Conteúdo<span class="text-danger">*</span></label>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-3 d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" wire:click="close">Cancelar</button>
                </div>
            </form>
        @endif

        <input type="text" class="form-control mt-3" wire:model.live="courseQuery">

        <table class="mt-3 table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Curso</th>
                    <th>Módulo</th>
                    <th>Aula</th>
                    <th>Contéudo</th>
                    <th>editar</th>
                    <th>excluir</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($annotations as $annotation)
                    <tr>
                        <td>{{ $annotation->id }}</td>
                        <td>{{ $annotation->course->name }}</td>
                        <td>{{ $annotation->module }}</td>
                        <td>{{ $annotation->title }}</td>
                        <td>{{ $annotation->content }}</td>
                        <td>
                            <button class="btn btn-warning" wire:click="edit({{ $annotation->id }})">Editar</button>
                        </td>
                        <td>
                            <button class="btn btn-danger" wire:click="edit({{ $annotation->id }})">Excluir</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">Sem registros</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $annotations->links(data: ['scrollTo' => false]) }}
    </div>
</div>
