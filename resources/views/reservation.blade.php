@extends('layouts.app')

@section('content')
<div class="container">
    <h1>予約設定</h1>
    <p>注文コード: {{ $orderCode }}</p>

    <form action="{{ route('order.reserve', ['orderCode' => $orderCode]) }}" method="POST">
        @csrf

        <label for="reservation_datetime">予約日時:</label>
        <input type="text" id="reservation_datetime" name="reservation_datetime" required>

        <label for="guest_count">人数:</label>
        <input type="number" id="guest_count" name="guest_count" min="1" required>

        <button type="submit">予約を確定</button>
    </form>

    <a href="{{ route('order.view') }}" class="btn btn-secondary">戻る</a>
</div>
@endsection

@section('scripts')
<script>
    flatpickr("#reservation_datetime", {
        locale: "ja", // ← 日本語に設定
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        inline: true,
        showMonths: 3
    });
</script>
@endsection
