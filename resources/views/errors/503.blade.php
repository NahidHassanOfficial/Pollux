@extends('errors.layout')
@section('title', '503 Under Maintenance - ' . env('APP_NAME'))
@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-[120px] font-bold text-[#403E43] mb-4">503</h1>
            <p class="text-2xl text-[#403E43] mb-2">Under Maintenance! 🚧</p>
            <p class="text-[#666666] mb-8">Sorry for the inconvenience but we're performing some maintenance at the
                moment</p>
            <a href="/"
                class="inline-block px-6 py-3 bg-[#9b87f5] text-white rounded-lg hover:bg-[#8370f3] transition-colors">
                Come Back Later!
            </a>
        </div>
    </div>
@endsection
