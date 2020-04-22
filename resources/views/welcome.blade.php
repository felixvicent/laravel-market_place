@extends('layouts.front')

@section('content')
    <div class="row front">
        @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 my-5">
                <div class="card" style="width: 98%;">
                    @if($product->photos->count())
                        <img src="{{ asset('storage/' . $product->photos->first()->image) }}" alt="" class="card-img-top">
                    @else
                        <img src="{{ asset('assets/img/no-photo.jpg') }}" alt="" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $product->name }}</h2>
                        <p class="card-text">{{ $product->description }}</p>
                        <h3>R$ {{ number_format($product->price, '2', ',', '.') }}</h3>
                        <a href="{{ route('product', ['slug' => $product->slug]) }}" class="btn btn-success">Ver produto</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}

    <div class="row">
        <div class="col-12 text-center">
            <h2>Lojas destaques</h2>
        </div>
        @foreach ($stores as $store)
            <div class="col-md-4 text-center">
                @if($store->logo != null)
                    <img class="img-fluid" width="100px" src="{{ asset('storage/' . $store->logo) }}" alt="">
                @else
                    <img class="img-fluid" src="https://via.placeholder.com/250X100.png?text=Loja%20sem%20logo" alt="">
                @endif
                <h3>{{ $store->name }}</h3>
                <p>{{ $store->description }}</p>
                <a href="{{ route('store', ['slug' => $store->slug]) }}" class="btn btn-sm btn-success">Ver loja</a>
            </div>   
        @endforeach
    </div>

@endsection