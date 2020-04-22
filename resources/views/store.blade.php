@extends('layouts.front')

@section('content')
    <div class="row front">
        <div class="col-12">
            <div class="row">
                <div class="col-2">
                    @if($store->logo != null)
                        <img class="img-fluid" src="{{ asset('storage/' . $store->logo) }}" width=150px alt="">
                    @else
                        <img class="img-fluid" src="{{ asset('assets/img/no-photo.jpg') }}" width=150px alt="">
                    @endif
                </div>
                <div class="col-10">
                    <h2>{{ $store->name }}</h2>
                    <p>{{ $store->description }}</p>
                    <p>
                        <h4>Contatos:</h4>
                        <span>{{ $store->phone }}</span> | <span>{{ $store->mobile_phone }}</span>
                    </p>
                </div>
                <hr>
                <div class="col-12">
                    <h3>Produtos desta loja</h3>
                    <hr>
                </div>
            </div>
        </div>
        @forelse ($store->products as $product)
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
        @empty
            <h3 class="alert alert-warning">Nenhum produto nesta loja</h3>
        @endforelse
    </div>
@endsection