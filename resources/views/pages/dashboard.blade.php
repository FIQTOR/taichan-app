@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto flex flex-col gap-4 min-h-screen py-20 px-4">
        <a href="{{ route('invoice.cash.search') }}" class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Cash
            Confirmation</a>
        <a href="{{ route('table.data') }}" class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Data
            Meja</a>
        <a href="{{ route('menu-data') }}" class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Data Menu</a>
        <a href="{{ route('feedback-data') }}" class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Data
            Masukan</a>
        <a href="{{ route('invoice.customer.order') }}"
            class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Pesanan Customer</a>
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('user.data') }}" class="w-full h-fit py-2 text-center bg-yellow-300 rounded-md px-7">Data
                User</a>
        @endif
    </main>
@endsection
