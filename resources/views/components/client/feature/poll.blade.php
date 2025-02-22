@extends('components.client.feature.layout')

@section('page')
    <script>
        function pollComponent() {
            return {
                poll: [],
                hasVoted: {{ $hasVoted ?? 'false' }},
                selectedOptions: [],
                showShareModal: false,

                fingerprint: '',

                async fetchPollData() {

                    const poll_uid = window.location.pathname.split('/').pop();
                    const queryParams = window.location.search || null;
                    const fullSignedPath = `${poll_uid}${queryParams}`;

                    if (queryParams === null) {
                        const response = await axios.get('{{ route('pollView', '') }}/' + poll_uid);
                        this.poll = response.data.data;

                    } else {
                        const response = await axios.get('{{ route('privatePollPage', '') }}/' + fullSignedPath, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });
                        this.poll = response.data.data;
                    }

                    this.fingerprint = await fp.get();
                    try {
                        const response = await axios.post('/api/store-fingerprint', {
                            fingerprint: this.fingerprint.visitorId,
                            poll_uid: poll_uid
                        });
                    } catch (error) {}
                },

                toggleSelection(optionId) {
                    if (this.poll.allow_multiple) {
                        if (this.selectedOptions.includes(optionId)) {
                            this.selectedOptions = this.selectedOptions.filter(id => id !== optionId);
                        } else {
                            this.selectedOptions.push(optionId);
                        }
                    } else {
                        this.selectedOptions = [optionId];
                    }
                },


                async submitVote() {
                    try {
                        const response = await axios.post(`/api/poll/${this.poll.poll_uid}/vote`, {
                            'poll_uid': this.poll.poll_uid,
                            'options': this.selectedOptions,
                            'fingerprint': this.fingerprint.visitorId
                        });
                        this.fetchPollData();
                        this.isVoted = response.data.status == 'success' ? true : false;

                    } catch (error) {
                        console.error('Error voting poll:', error);
                    }

                },

            }
        }
    </script>

    <div x-data="pollComponent()" x-init="fetchPollData()">
        <div class="pt-24 px-4 md:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <!-- Poll Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <template x-if="poll.user">
                                <div class="flex items-center gap-3 mb-4">
                                    <a :href="'/profile/@' + poll.user.username" class="flex items-center gap-2 group">
                                        <img :src="poll.user.profile_img ?? '{{ asset('user.jpg') }}'"
                                            class="w-8 h-8 rounded-full object-cover border-2 border-transparent group-hover:border-[#9b87f5]">
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-[#9b87f5]"
                                            x-text="'@' + poll.user.username"></span>
                                    </a>
                                </div>
                            </template>
                            <h1 class="text-2xl font-bold text-[#403E43] mb-2" x-text="poll.title"></h1>
                            <p class="text-gray-600" x-text="poll.description"></p>
                        </div>
                        <button @click="showShareModal = true" class="text-[#9b87f5] hover:text-[#8370f3]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                                <polyline points="16 6 12 2 8 6" />
                                <line x1="12" y1="2" x2="12" y2="15" />
                            </svg>
                        </button>
                    </div>

                    <!-- Poll Options -->
                    <div class="space-y-4 mb-6">
                        <template x-for="option in poll.poll_options" :key="option.id">
                            <div>
                                <template x-if="!hasVoted && poll.status=='active'">
                                    <label class="block p-4 border-2 rounded-lg cursor-pointer transition-colors"
                                        :class="{
                                            'border-[#9b87f5] bg-[#9b87f5]/5': selectedOptions.includes(option.id),
                                            'border-gray-200 hover:border-[#9b87f5]/50': !selectedOptions.includes(
                                                option.id)
                                        }">
                                        <div class="flex items-center">
                                            <input @change="toggleSelection(option.id)"
                                                :type="poll.allow_multiple ? 'checkbox' : 'radio'" :value="option.id"
                                                name="option" class="text-[#9b87f5] focus:ring-[#9b87f5]">
                                            <span class="ml-3" x-text="option.option"></span>
                                        </div>
                                    </label>
                                </template>
                                <template x-if="hasVoted || poll.status!='active'">
                                    <div class="relative">
                                        <div class="bg-gray-100 rounded-lg h-12 overflow-hidden">
                                            <div class="bg-[#9b87f5] h-full transition-all duration-500"
                                                :style="'width: ' + ((poll.total_vote ? (option.votes / poll.total_vote *
                                                        100) :
                                                    0) + '%')">
                                            </div>
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-between px-4">
                                            <span class="text-gray-700" x-text="option.option"></span>
                                            <span class="text-gray-700"
                                                x-text="(Math.round(option.votes / poll.total_vote * 100) || 0) + '%'">
                                            </span>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Vote Button -->
                    <template x-if="!hasVoted">
                        <button @click="hasVoted = true; submitVote()" :disabled="selectedOptions.length === 0"
                            class="w-full bg-[#9b87f5] text-white py-3 rounded-lg font-semibold disabled:opacity-50 disabled:cursor-not-allowed hover:bg-[#8370f3] transition-colors">
                            Submit Vote
                        </button>
                    </template>

                    <!-- Poll Info -->
                    <div
                        class="mt-6 flex flex-col md:flex-row justify-between items-start md:items-center text-sm text-gray-500">
                        <div class="flex items-center gap-4 mb-2 md:mb-0">
                            <span x-text="poll.total_vote + ' votes'"></span>
                            <span>•</span>
                            <span x-text="'Ends ' + new Date(poll.expire_at+ ' UTC').toLocaleString()"></span>
                        </div>
                        <div class="flex items-center gap-4">
                            <template x-if="poll.allow_multiple">
                                <span>Multiple choice allowed</span>
                            </template>
                            <template x-if="!poll.public_visibility">
                                <span>Private poll</span>
                            </template>
                        </div>
                    </div>
                </div>


                <x-client.feature.utils.share-modal> </x-client.feature.utils.share-modal>

            </div>
        </div>
    </div>
@endsection
