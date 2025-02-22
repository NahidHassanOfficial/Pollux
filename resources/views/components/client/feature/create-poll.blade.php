@extends('components.client.feature.layout')

@section('page')
    <script>
        function createPollComponent() {
            return {
                title: '',
                description: '',
                options: ['', ''],
                selectedOptions: [],
                allow_multiple: false,
                isPrivate: false,
                expire_at: '',
                userTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone,

                isLoading: false,
                authToken: null,


                addOption() {
                    if (this.options.length < 5) {
                        this.options.push('');
                    }
                },

                removeOption(index) {
                    if (this.options.length > 2) {
                        this.options.splice(index, 1);
                    }
                },

                isValid() {
                    return this.title.trim() !== '' &&
                        this.options.every(opt => opt.trim() !== '') &&
                        this.expire_at !== '';
                },

                async createPoll() {
                    this.isLoading = true;
                    try {
                        this.authToken = getAuthToken();

                        const response = await axios.post('{{ route('poll.create') }}', {
                            title: this.title,
                            description: this.description,
                            allow_multiple: this.allow_multiple,
                            public_visibility: this.isPrivate ? false : true,
                            expire_at: this.expire_at,
                            userTimezone: this.userTimezone,
                            options: this.options,
                        }, {
                            headers: {
                                'Authorization': `Bearer ${this.authToken}`
                            }
                        });


                        this.title = '';
                        this.description = '';
                        this.options = ['', ''];
                        this.selectedOptions = [];
                        this.allow_multiple = false;
                        this.isPrivate = false;
                        this.expire_at = '';

                        toast('Poll Created Successfully!');
                    } catch (error) {
                        toast('Poll creation failed', 'error');
                        // console.log(error);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }
    </script>
    <div x-data="createPollComponent()">
        <div class="pt-24 px-4 md:px-6 lg:px-8">
            <div class="grid space-y-5 md:space-y-0 md:grid-cols-2 md:space-x-5">
                <!-- Create Poll Form -->
                <div class="bg-white rounded-lg shadow-lg  p-6 md:p-8">
                    <h1 class="text-2xl font-bold text-[#403E43] mb-6">Create a New Poll</h1>

                    <!-- Title -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Poll Title</label>
                        <input type="text" x-model="title" placeholder="What would you like to ask?"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent">
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                        <textarea x-model="description" placeholder="Add more context to your question" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent"></textarea>
                    </div>

                    <!-- Options -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Poll Options</label>
                        <div class="space-y-3">
                            <template x-for="(option, index) in options" :key="index">
                                <div class="flex gap-2">
                                    <input type="text" x-model="options[index]" :placeholder="'Option ' + (index + 1)"
                                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent">
                                    <button @click="removeOption(index)" class="text-red-500 hover:text-red-600"
                                        x-show="options.length > 2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6L6 18M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <button @click="addOption"
                            class="mt-3 text-[#9b87f5] hover:text-[#8370f3] inline-flex items-center gap-1"
                            x-show="options.length < 5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Add Option
                        </button>
                    </div>

                    <!-- Poll Settings -->
                    <div class="grid space-y-5 md:flex justify-between justify-center items-center mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="datetime-local" x-model="expire_at"
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent">
                        </div>
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="allow_multiple"
                                    class="text-[#9b87f5] focus:ring-[#9b87f5] rounded">
                                <span class="text-gray-700">Allow multiple choice</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" x-model="isPrivate"
                                    class="text-[#9b87f5] focus:ring-[#9b87f5] rounded">
                                <span class="text-gray-700">Make poll private</span>
                            </label>
                        </div>
                    </div>

                    <!-- Create Button -->
                    <button @click="createPoll()" :disabled="!isValid() || isLoading"
                        class="w-full bg-[#9b87f5] text-white py-3 rounded-lg font-semibold disabled:opacity-50 disabled:cursor-not-allowed hover:bg-[#8370f3] transition-colors relative flex items-center justify-center">
                        <span x-show="!isLoading">Create Poll</span>
                        <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>

                </div>

                <x-client.feature.poll-preview />
            </div>
        </div>
    </div>
@endsection
