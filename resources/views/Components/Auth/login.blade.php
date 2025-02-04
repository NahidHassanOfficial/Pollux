@extends('welcome')
@section('content')
    <div x-data="loginForm">
        <div class="min-h-screen pt-16 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-3xl font-bold text-[#403E43]">Welcome back</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('registerPage') }}" class="font-medium text-[#9b87f5] hover:text-[#8370f3]">Sign up</a>
                </p>
            </div>
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                    <form class="mt-6 space-y-6" @submit.prevent="login">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input id="email" type="email" required x-model="email"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative">
                                <input id="password" :type="showPassword ? 'text' : 'password'" required x-model="password"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <span class=" text-red-400" x-text="error"></span>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" type="checkbox" x-model="remember"
                                    class="h-4 w-4 text-[#9b87f5] focus:ring-[#9b87f5] border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>
                            <a href="{{ route('forgotPwdPage') }}"
                                class="text-sm font-medium text-[#9b87f5] hover:text-[#8370f3]">
                                Forgot your password?
                            </a>
                        </div>
                        <div>
                            {{-- <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#9b87f5] hover:bg-[#8370f3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9b87f5]"
                                :class="{ 'opacity-75 cursor-not-allowed': isLoading }" :disabled="isLoading">
                                <template x-if="isLoading">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </template>
                                Sign in
                            </button> --}}

                            <x-utils.loadingBtn :name="'Sign in'" />
                        </div>
                    </form>
                    <div class="my-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>
                    </div>
                    <x-Auth.social-auth></x-Auth.social-auth>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('loginForm', () => ({
                email: '',
                password: '',
                remember: false,
                showPassword: false,
                error: null,
                isLoading: false,

                async login() {
                    this.isLoading = true;
                    this.error = null;

                    try {
                        const response = await axios.post('{{ route('login.post') }}', {
                            email: this.email,
                            password: this.password,
                            remember: this.remember
                        });
                        if (response.data.status == 'success') {
                            document.cookie = "auth_token=" + response.data.auth_token +
                                "; path=/; max-age=2592000; SameSite=Lax;";

                            toast('Login Successful');
                            setTimeout(() => {
                                window.location.href = '{{ route('profilePage') }}';
                            }, 1500);
                        }
                    } catch (error) {
                        if (error.response.data.status == 'failed') {
                            this.error = error.response.data.message;
                        } else {
                            this.error = 'Something went wrong!';
                        }
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>
@endsection
