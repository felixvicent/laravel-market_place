@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-6">
            @if($product->photos->count())
                <img src="{{ asset('storage/' . $product->photos->first()->image) }}" alt="" class="img-fluid" style="height:200px;">
                <div class="row" style="margin-top: 20px;">
                    @foreach ($product->photos as $photo)
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="" class="img-fluid">
                        </div>
                    @endforeach
                </div>
            @else
                <img src="{{ asset('assets/img/no-photo.jpg') }}" alt="" class="card-img-top">
            @endif
        </div>
        <div class="col-6">
            <div class="col-md-12">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <h3>R$ {{ number_format($product->price, '2', ',', '.') }}</h3>
                <span>{{ $product->store->name }}</span>
            </div>
            <div class="product-add col-md-12">
                <hr>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product[name]" value="{{ $product->name }}">
                    <input type="hidden" name="product[price]" value="{{ $product->price }}">
                    <input type="hidden" name="product[slug]" value="{{ $product->slug }}">
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="number" name="product[amount]" value="1" min="1" class="col-4 col-md-3 col-lg-2">
                    </div>
                    <button type="submit" class="btn btn-lg btn-danger">Comprar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
            {{ $product->body }}
        </div>
    </div>
@endsection