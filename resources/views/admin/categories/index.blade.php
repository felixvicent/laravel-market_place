@extends('layouts.app')

@section('content')

    <a href="{{ route('admin.categories.create') }}" class="btn btn-ls btn-success">Criar categoria</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Ações</th>
            <tr>
        </thead>
        <tbody>

        @foreach($categories as $category)
            <tr>
                <th>{{ $category->id }}</th>
                <th>{{ $category->name }}</th>
                <th>
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-danger">REMOVER</button>
                        </form>
                    </div>
                </th>
            <tr>
        @endforeach

        </tbody>
    </table>
@endsection