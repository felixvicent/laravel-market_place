@extends('layouts.front')

@section('content')
    
    <h2 class="alert alert-success">Muito obrigado!</h2>
    <h3 class="alert alert-success">Seu pedido foi processado, codigo do pedido: {{ request()->get('order') }}</h2>

@endsection 