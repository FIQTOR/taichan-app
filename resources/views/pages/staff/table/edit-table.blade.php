@extends('layouts/base')

@section('content')
    <main class="w-full max-w-md mx-auto min-h-screen flex justify-center items-center py-32 px-4">
        <div class="w-full rounded-xl shadow-2xl border flex flex-col gap-2 p-4 relative text-neutral-600">
            <div class="absolute self-center -translate-y-16 bg-yellow-300 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto text-white" width="75" height="75"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 10h16"></path>
                    <path d="M4 14h16"></path>
                    <path d="M9 18l3 3l3 -3"></path>
                    <path d="M9 6l3 -3l3 3"></path>
                </svg>
            </div>
            <h1 class="font-bold text-4xl mx-auto mt-14 mb-7 text-neutral-500">Edit Meja</h1>
            <form action="{{ route('table.update', $table->id) }}" method="POST" class="flex flex-col gap-2">
                @csrf

                @if (session('error'))
                    <p class="text-red-500">{{ session('error') }}</p>
                @endif
                @if (session('success'))
                    <p class="text-green-500">{{ session('success') }}</p>
                @endif

                <div class="flex flex-col gap-1">
                    <label for="visibility">Visibilitas</label>
                    <select name="visibility" id="visibility"
                        class="px-2 py-1 rounded-md outline outline-1
                    focus:outline-yellow-300 focus:outline-2 outline-neutral-500">
                        <option value="public" @if ($table['visibility'] == 'public') selected @endif>Publik</option>
                        <option value="private" @if ($table['visibility'] == 'private') selected @endif>>Privasi</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="table_number">Nomor Meja</label>
                    <input type="title" name="table_number" id="table_number"
                        class="px-2 py-1 rounded-md outline outline-1
                        focus:outline-yellow-300 focus:outline-2
                        @error('table_number') outline-red-600 @else outline-neutral-500 @enderror"
                        value="{{ $table->table_number }}" min="1">
                    @error('table_number')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button class="bg-yellow-300 py-1 text-neutral-700 rounded-md hover:opacity-70">
                    Perbarui Meja</button>
            </form>
            <a href="{{ route('table.data') }}" class="text-blue-400 hover:opacity-70">Kembali Ke Data Meja</a>
        </div>
    </main>

    <script>
        $('#table_number').on('input', function() {
            if ($(this).val() < 1)
                $(this).val(1)
        });
    </script>
@endsection
