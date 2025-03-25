@extends('layouts.app')

@section('content')
    <div class="order-container">
        <h1>注文履歴</h1>

        <x-order :orders="$orders" />
    </div>
@endsection
