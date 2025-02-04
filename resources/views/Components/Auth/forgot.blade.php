@extends('welcome')

@section('content')
    <div x-data="{
        email: '',
        isLoading: false,
        success: false,
        error: null,
        resetPassword() {
            this.isLoading = true;
            this.error = null;
            // Simulate password reset request
            setTimeout(() => {
                this.isLoading = false;
                this.success = true;
            }, 1000);
        }
    }">

        <div class="min-h-screen pt-16 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-3xl font-bold text-[#403E43]">Reset your password</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Remember your password?
                    <a href="login.html" class="font-medium text-[#9b87f5] hover:text-[#8370f3]">Sign in</a>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                    <template x-if="!success">
                        <form class="space-y-6" @submit.prevent="resetPassword">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email
                                    address</label>
                                <div class="mt-1">
                                    <input id="email" type="email" required x-model="email"
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                                </div>
                            </div>

                            <div>
                                <x-utils.loadingBtn :name="'Send reset link'" />
                            </div>
                        </form>
                    </template>

                    <template x-if="success">
                        <div class="text-center">
                            <div class="mb-4 text-[#9b87f5]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Check your email</h3>
                            <p class="mt-2 text-sm text-gray-600">
                                We've sent a password reset link to <span class="font-medium" x-text="email"></span>
                            </p>
                            <p class="mt-2 text-sm text-gray-600">
                                Didn't receive the email?
                                <button @click="success = false" class="font-medium text-[#9b87f5] hover:text-[#8370f3]">
                                    Try again
                                </button>
                            </p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
