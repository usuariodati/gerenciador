@extends('layouts.app')

@section('content')
    <div class="row p-3">
        <div class="col-6">@livewire('l-permission')</div>
        <div class="col-6">@livewire('l-role')</div>
    </div>

    <div class="row p-3">
        <div class="col-6">@livewire('l-user')</div>
        <div class="col-6">@livewire('l-category')</div>
    </div>

    <div class="row p-3">
        <div class="col-6">@livewire('l-plataform')</div>
        {{-- <div class="col-6">@livewire('l-role')</div> --}}
    </div>
    
    <div class="p-3">
        <a href="{{ route('form') }}" class="btn btn-primary">Formulários</a>
    </div>

@endsection