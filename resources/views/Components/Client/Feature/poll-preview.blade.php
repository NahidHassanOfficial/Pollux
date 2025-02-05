<!-- Preview -->
<div class="w-full bg-white rounded-lg shadow-lg p-6 md:p-8">
    <h2 class="text-xl font-semibold text-[#403E43] mb-4">Preview</h2>
    <div class="border-t pt-4">
        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        @auth
                            <a href="#" class="flex items-center gap-2 group">
                                <img src="{{ auth()->user()->profile_img ?? asset('user.jpg') }}"
                                    class="w-8 h-8 rounded-full object-cover border-2 border-transparent group-hover:border-[#9b87f5]">
                                <span class="text-sm font-medium text-gray-900 group-hover:text-[#9b87f5]">
                                    &#64;{{ auth()->user()->username }}
                                </span>
                            </a>
                        @endauth
                    </div>
                    <h1 class="text-2xl font-bold text-[#403E43] mb-2" x-text="title"></h1>
                    <p class="text-gray-600" x-text="description"></p>
                </div>
            </div>

            <!-- Poll Options -->
            <div class="space-y-4 mb-6">
                <template x-for="(option, index) in options" :key="index">
                    <div>
                        <label class="block p-4 border-2 rounded-lg cursor-pointer transition-colors"
                            :class="{
                                'border-[#9b87f5] bg-[#9b87f5]/5': selectedOptions.includes(option),
                                'border-gray-200 hover:border-[#9b87f5]/50': !selectedOptions.includes(
                                    option)
                            }">
                            <div class="flex items-center">
                                <input :type="allow_multiple ? 'checkbox' : 'radio'" name="option"
                                    class="text-[#9b87f5] focus:ring-[#9b87f5]">
                                <span class="ml-3" x-text="option"></span>
                            </div>
                        </label>
                    </div>
                </template>
            </div>
            <!-- Vote Button -->
            <button
                class="w-full bg-[#9b87f5] text-white py-3 rounded-lg font-semibold disabled:opacity-50 disabled:cursor-not-allowed hover:bg-[#8370f3] transition-colors">
                Submit Vote
            </button>

            <!-- Poll Info -->
            <div
                class="mt-6 flex flex-col md:flex-row justify-between items-start md:items-center text-sm text-gray-500">
                <div class="flex items-center gap-4 mb-2 md:mb-0">
                    <span>911 votes</span>
                    <span>•</span>
                    <span x-text="'Ends ' + new Date(expire_at).toLocaleDateString()"></span>
                </div>
                <div class="flex items-center gap-4">
                    <span x-show="allow_multiple">Multiple choice allowed</span>
                    <span x-show="isPrivate">Private poll</span>
                </div>
            </div>
        </div>
    </div>
</div>
