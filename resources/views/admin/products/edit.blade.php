@extends('layouts.app')

@section('content')
    <h1>Atualizar loja</h1>

    <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")

        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}">

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ $product->description }}">

            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Conteudo</label>
            <textarea name="body" rows="10" class="form-control @error('body') is-invalid @enderror">{{ $product->body }}</textarea>
            
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Preço</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}">

            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="categories">Categorias</label>
            <select name="categories[]" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($product->categories->contains($category)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="photos"></label>
            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror" multiple>

            @error('photos.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success">Atualiza produto</button>
        </div>
    </form>

    <hr>

    <div class="row">
        @foreach ($product->photos as $photo)
            <div class="col-md-4 text-center">
                <img src="{{ asset('storage/' . $photo->image) }}" alt="" class="img-fluid">
                <form action="{{ route('admin.photo.remove') }}" method="POST">
                    <input type="hidden" name="photoName" value="{{$photo->image}}">
                    @csrf
                    <button type="submit" class="btn btn-lg btn-danger">REMOVER</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection