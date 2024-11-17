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
    
@endsection