@extends('welcome')

@section('content')
    <div x-data="registerForm">
        <div class="min-h-screen pt-16 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="text-center text-3xl font-bold text-[#403E43]">Create your account</h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('loginPage') }}" class="font-medium text-[#9b87f5] hover:text-[#8370f3]">Sign in</a>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                    <form class="mt-6 space-y-6" @submit.prevent="register">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1">
                                <input x-model="username" @input.debounce.500ms="checkUserAvailibility" id="name"
                                    type="text" required
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                            </div>
                            <span x-show="username.length>3" :class="isAvailable ? 'text-green-500' : 'text-red-500'"
                                x-text="isAvailable ? 'username is available' : 'username already exist'"></span>

                            <template x-if="error">
                                <template x-if="error.username">
                                    <template x-for="(msg, index) in error.username" :key="index">
                                        <div x-text="msg" class="text-red-500"></div>
                                    </template>
                                </template>
                            </template>

                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input id="email" type="email" required x-model="email"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                            </div>

                            <template x-if="error?.email">
                                <template x-for="(msg, index) in error.email" :key="index">
                                    <div x-text="msg" class="text-red-500"></div>
                                </template>
                            </template>

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
                            <template x-if="error?.password">
                                <template x-for="(msg, index) in error.password" :key="index">
                                    <div x-text="msg" class="text-red-500"></div>
                                </template>
                            </template>
                        </div>

                        <div>
                            <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm
                                password</label>
                            <div class="mt-1 relative">
                                <input id="confirm-password" :type="showConfirmPassword ? 'text' : 'password'" required
                                    x-model="password_confirmation"
                                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#9b87f5] focus:border-[#9b87f5]">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- <button type="submit" :disabled="password !== password_confirmation || !isAvailable"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#9b87f5] hover:bg-[#8370f3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9b87f5]"
                            :class="{ 'opacity-75 cursor-not-allowed': isLoading }" :disabled="isLoading">
                            <template x-if="isLoading">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </template>
                            Sign Up
                        </button> --}}

                        <x-utils.loadingBtn :name="'Sign Up'" />

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('registerForm', () => ({
                username: '',
                email: '',
                password: '',
                password_confirmation: '',
                isAvailable: true,
                showPassword: false,
                showConfirmPassword: false,
                isLoading: false,
                error: null,

                async checkUserAvailibility() {

                    if (this.username.length < 4) {
                        return true;
                    }
                    const response = await axios.get(`/api/user/${this.username}`);;
                    this.isAvailable = response.data == 1 ? false : true;
                },
                async register() {
                    this.isLoading = true;
                    this.error = null;

                    try {
                        const response = await axios.post('{{ route('register.post') }}', {
                            username: this.username,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        });
                        if (response.data.status == 'success') {
                            toast('Registration Successful');
                            setTimeout(() => {
                                window.location.href = '{{ route('verifyProcess') }}';
                            }, 1000);
                        }
                    } catch (err) {
                        this.error = err.response.data;
                    } finally {
                        this.isLoading = false;
                    }
                }

            }));
        });
    </script>
@endsection
