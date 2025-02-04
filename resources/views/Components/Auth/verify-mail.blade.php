@extends('welcome')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <!-- Email verification card -->
        <div class="w-full max-w-md bg-white rounded-lg shadow-sm p-8 text-center">
            <!-- Icon -->
            <div class="mb-6 text-[#9b87f5]">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-auto">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
            </div>
            <!-- Content -->
            <h1 class="text-2xl font-bold text-[#403E43] mb-4">Check Your Email</h1>
            <p class="text-[#666666] mb-6">
                We've sent a verification link to your email address. Please check your inbox and click the link to
                verify your account.
            </p>
            <!-- Timer -->
            <div x-data="{ seconds: 60 }" x-init="setInterval(() => { if (seconds > 0) seconds-- }, 1000)" class="mb-6">
                <p class="text-sm text-[#666666]">
                    Didn't receive the email? You can request a new one in
                    <span x-text="seconds" class="font-semibold text-[#9b87f5]"></span> seconds
                </p>
            </div>
            <!-- Buttons -->
            <div class="space-y-4">
                <button
                    class="w-full bg-[#9b87f5] hover:bg-[#8370f3] text-white px-4 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    x-data="{ seconds: 60 }" x-init="setInterval(() => { if (seconds > 0) seconds-- }, 1000)" :disabled="seconds > 0">
                    Resend Verification Email
                </button>
                <a href="{{ route('index') }}" class="block text-[#666666] hover:text-[#9b87f5] transition-colors text-sm">
                    Back to Home
                </a>
            </div>
            <!-- Help text -->
            <p class="mt-8 text-sm text-[#666666]">
                Having trouble?
                <a href="#" class="text-[#9b87f5] hover:text-[#8370f3] transition-colors">Contact Support</a>
            </p>
        </div>
        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-[#666666]">
                © {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.
            </p>
        </div>
    </div>
@endsection
