<div x-show="showReportModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div @click.away="showReportModal = false" class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-semibold mb-4">Report Poll</h3>
        <p class="text-gray-600 mb-4">Why are you reporting this poll?</p>
        <div class="space-y-2 mb-4">
            <label class="flex items-center space-x-2">
                <input type="radio" name="reason" value="Inappropriate content" x-model="reason"
                    class="text-[#9b87f5]">
                <span>Inappropriate content</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" name="reason" value="Misleading information" x-model="reason"
                    class="text-[#9b87f5]">
                <span>Misleading information</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" name="reason" value="Spam" x-model="reason" class="text-[#9b87f5]">
                <span>Spam</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" name="reason" value="Other" x-model="reason" class="text-[#9b87f5]">
                <span>Other</span>
            </label>
        </div>
        <textarea placeholder="Additional details (optional)"
            class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent"
            rows="3" x-model="description"></textarea>
        <div class="flex justify-end space-x-4">
            <button @click="showReportModal = false" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                Cancel
            </button>
            <button @click="submitReport()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Submit Report
            </button>
        </div>
    </div>
</div>
