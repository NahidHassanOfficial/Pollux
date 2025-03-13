@extends('welcome')

@section('content')
    <script>
        function emailVerification() {
            return {
                status: 'loading',
                message: '',

                init() {
                    setTimeout(() => {
                        this.status = @json($status);
                        console.log(this.status);

                        if (this.status == 'success') {
                            this.message = 'Your email has been successfully verified!';
                            setTimeout(() => {
                                window.location.href = '{{ route('profilePage') }}';
                            }, 1500);

                        } else {
                            this.message = 'Email verification failed. The link may have expired or is invalid.';
                            setTimeout(() => {
                                window.location.href = '{{ route('loginPage') }}';
                            }, 1500);
                        }
                    }, 1500);
                }
            };
        }
    </script>
    <div class="bg-gray-50 flex items-center justify-center min-h-screen">
        <div x-data="emailVerification" class="w-full max-w-md p-6">

            <!-- Card Container -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <!-- Loading State -->
                <div x-show="status === 'loading'" class="space-y-4">
                    <div class="mx-auto w-16 h-16 border-4 border-primary border-t-transparent rounded-full animate-spin">
                    </div>
                    <h1 class="text-xl font-semibold text-gray-800">Verifying your email...</h1>
                    <p class="text-gray-600">Please wait while we confirm your email address</p>
                </div>

                <!-- Success State -->
                <div x-show="status === 'success'" x-transition class="space-y-6">
                    <div
                        class="mx-auto w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Email Verified!</h1>
                    <p class="text-gray-600" x-text="message"></p>
                    <div class="relative pt-4">
                        <div class="h-2 bg-gray-200 rounded-full">
                            <div class="bg-primary h-2 rounded-full animate-[grow_3s_linear]"></div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">
                        Redirecting you automatically... or
                        <a href="{{ route('profilePage') }}" class="text-primary hover:underline">click here</a>
                    </p>
                </div>

                <!-- Error State -->
                <div x-show="status === 'error'" x-transition class="space-y-6">
                    <div class="mx-auto w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Verification Failed</h1>
                    <p class="text-gray-600" x-text="message"></p>
                    <div class="pt-4">
                        <a href="{{ route('loginPage') }}"
                            class="inline-block bg-[#9b87f5] hover:bg-[#8370f3] text-white px-6 py-3 rounded-lg transition-colors">
                            Return to Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Brand Footer -->
            <div class="mt-8 text-center">
                <p class="text-gray-500 text-sm">
                    © {{ now()->year }} Pollux - Simple Polling System
                </p>
            </div>
        </div>

        <style>
            @keyframes grow {
                0% {
                    width: 0%;
                }

                100% {
                    width: 100%;
                }
            }
        </style>
    </div>
@endsection
