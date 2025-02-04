@extends('errors.layout')
@section('title', '401 Unauthorized - ' . env('APP_NAME'))
@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-[120px] font-bold text-[#403E43] mb-4">401</h1>
            <p class="text-2xl text-[#403E43] mb-2">You are not authorized! 🔒</p>
            <p class="text-[#666666] mb-8">You don't have permission to access this page. Go Home!</p>
            <a href="/"
                class="inline-block px-6 py-3 bg-[#9b87f5] text-white rounded-lg hover:bg-[#8370f3] transition-colors">
                Back to home
            </a>
        </div>
    </div>
@endsection
