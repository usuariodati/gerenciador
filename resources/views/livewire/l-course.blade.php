<div class="card container-fluid p-0">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="d-inline">Course</h3>
            <button class="btn btn-primary" wire:click="create">Criar</button>
        </div>
    </div>

    <div class="card-body">
        @if (session()->has('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        
        @if ($open)
            <form class="mt-3" wire:submit.prevent="store">
                <div class="form-floating mt-3">
                    <select id="plataform_id" class="form-select" wire:model="plataform_id">
                        <option>Selecione plataforma</option>
                        @forelse ($plataforms as $plataform)
                            <option value="{{ $plataform->id}}">{{ $plataform->name }}</option>
                        @empty
                            <option>Sem cursos</option>
                        @endforelse
                    </select>
                    <label for="plataform_id">Nome<span class="text-danger">*</span></label>
                    @error('plataform_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="name" class="form-control" wire:model.defer="name">
                    <label for="name">Nome<span class="text-danger">*</span></label>
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="total_modules" class="form-control" wire:model.defer="total_modules">
                    <label for="total_modules">Total de Módulos<span class="text-danger">*</span></label>
                    @error('total_modules')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="total_classes" class="form-control" wire:model.defer="total_classes">
                    <label for="total_classes">Total de Aulas<span class="text-danger">*</span></label>
                    @error('total_classes')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="done_modules" class="form-control" wire:model.defer="done_modules">
                    <label for="done_modules">Módulos feitos<span class="text-danger">*</span></label>
                    @error('done_modules')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="text" id="done_classes" class="form-control" wire:model.defer="done_classes">
                    <label for="done_classes">Aulas feitas<span class="text-danger">*</span></label>
                    @error('done_classes')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                @forelse ($categories as $category)
                    <div class="@if($loop->first) mt-3 @endif form-check">
                        <input type="checkbox" id="category_{{ $category->id }}"
                            class="form-check-input" wire:model="selectedCategories"
                            value="{{ $category->id }}"
                            @if(in_array($category->id, $selectedCategories)) checked @endif>
                        <label for="category_{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                    </div>
                @empty
                    sem perfis
                @endforelse

                <div class="mt-3 d-flex justify-content-evenly">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" wire:click="close">Cancelar</button>
                </div>
            </form>
        @endif

        <input type="text" class="form-control mt-3" wire:model.live="query">

        <table class="mt-3 table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Plataforma</th>
                    <th>Categorias</th>
                    <th>Total de módulos</th>
                    <th>Total de aulas</th>
                    <th>módulos feitos</th>
                    <th>aulas feitas</th>
                    <th>editar</th>
                    <th>excluir</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ Str::limit($course->name, 30) }}</td>
                        <td>
                            {{ $course->plataform->name }}
                        </td>
                        <td>
                            @forelse ($course->categories as $category)
                                {{ $category->name }} @if(!$loop->last), @endif
                            @empty
                                sem categorias
                            @endforelse
                        </td>
                        <td>{{ $course->total_modules }}</td>
                        <td>{{ $course->total_classes }}</td>
                        <td>{{ $course->done_modules }}</td>
                        <td>{{ $course->done_classes }}</td>
                        <td>
                            <button class="btn btn-warning" wire:click="edit({{ $course->id }})">Editar</button>
                        </td>
                        <td>
                            <button class="btn btn-danger" wire:click="edit({{ $course->id }})">Excluir</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9">Sem registros</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $courses->links(data: ['scrollTo' => false]) }}
    </div>
</div>
