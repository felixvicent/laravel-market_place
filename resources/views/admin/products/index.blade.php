@extends('layouts.app')

@section('content')

    <a href="{{ route('admin.products.create') }}" class="btn btn-ls btn-success">Criar produto</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Loja</th>
                <th>Ações</th>
            <tr>
        </thead>
        <tbody>

        @foreach($products as $product)
            <tr>
                <th>{{ $product->id }}</th>
                <th>{{ $product->name }}</th>
                <th>R$ {{ number_format($product->price, 2, ',', '.') }}</th>
                <th>{{ $product['store']->name }}</th>
                <th>
                    <div class="btn-group">
                        <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="post">
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

    {{ $products->links() }}
@endsection