<!-- Share Modal -->
<div x-show="showShareModal" x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div @click.away="showShareModal = false" class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-semibold mb-4">Share Poll</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Poll Link</label>
                <div class="flex">
                    <input type="text" readonly :value="'{{ env('APP_URL') }}' + '/poll/' + poll.poll_uid"
                        class="flex-1 border border-r-0 border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent">
                    <button class="bg-[#9b87f5] text-white px-4 rounded-r-lg hover:bg-[#8370f3]"
                        @click="navigator.clipboard.writeText('{{ env('APP_URL') }}' + '/poll/' + poll.poll_uid); toast('Link copied to clipboard')">
                        Copy
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Share on Social
                    Media</label>
                <div class="flex gap-4">
                    <button class="flex-1 bg-[#1DA1F2] text-white py-2 rounded-lg hover:bg-opacity-90">Twitter</button>
                    <button class="flex-1 bg-[#4267B2] text-white py-2 rounded-lg hover:bg-opacity-90">Facebook</button>
                    <button class="flex-1 bg-[#0A66C2] text-white py-2 rounded-lg hover:bg-opacity-90">LinkedIn</button>
                </div>
            </div>
        </div>
        <button @click="showShareModal = false"
            class="mt-6 w-full border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">
            Close
        </button>
    </div>
</div>
