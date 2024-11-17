@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <div class="col-6">@livewire('l-plataform')</div>
        <div class="col-6">@livewire('l-course')</div>
    </div>

    <div class="row p-3">
        <div class="col-6">@livewire('l-annotation')</div>
        {{-- <div class="col-6">@livewire('l-role')</div> --}}
    </div>
    
    @hasrole('admin')
        <div class="p-3">
            <a href="{{ route('admin') }}" class="btn btn-primary">Página admin</a>
        </div>
    @endhasrole
@endsection