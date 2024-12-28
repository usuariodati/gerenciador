@extends('layouts.app')

@section('content')
        <div class="mt-3 p-3">@livewire('l-plataform')</div>
        <div class="mt-3 p-3">@livewire('l-course')</div>

        <div class="mt-3 p-3">@livewire('l-annotation')</div>
        {{-- <div class="mt-3 p-3">@livewire('l-role')</div> --}}
    
    @hasrole('admin')
        <div class="p-3">
            <a href="{{ route('admin') }}" class="btn btn-primary">Página admin</a>
        </div>
    @endhasrole
@endsection