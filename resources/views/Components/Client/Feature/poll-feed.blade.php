@extends('components.client.feature.layout')

@section('page')
    <script>
        function pollsComponent() {
            return {
                polls: [],
                page: 1,
                lastPage: 1,
                hasMore: true,
                searchQuery: '',
                selectedFilter: '',
                apiUrl: '{{ route('getPolls') }}',
                isLoading: false,

                async searchPolls() {
                    this.hasMore = true;
                    this.isLoading = true;

                    response = await axios.get(`{{ route('searchPoll') }}?query=${this.searchQuery}`);
                    if (response.data.data.length > 0) {
                        this.polls = response.data.data;
                    } else {
                        this.polls = [];
                    }

                    this.isLoading = false;
                    this.hasMore = false;
                },

                async fetchPolls(reset = true) {
                    this.hasMore = true;
                    this.isLoading = true;
                    try {
                        if (reset) {
                            this.page = 1;
                            this.polls = [];
                        }

                        const response = await axios.get(this.apiUrl + '/' + this.selectedFilter + '?page=' + this
                            .page);
                        if (response.data.data.data.length > 0) {
                            this.polls.push(...response.data.data.data);
                            this.page = response.data.data.from;
                            this.lastPage = response.data.data.last_page;
                        }

                        if (this.page < this.lastPage) this.page++;
                        else this.hasMore = false;

                    } catch (error) {
                        console.error('Error fetching polls:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                async loadMorePolls() {
                    this.fetchPolls(false);
                },

                optionTotalVotes(pollOptions) {
                    return pollOptions.reduce((total, option) => total + option.votes, 0);
                },
            };
        }
    </script>

    <div x-data="pollsComponent()" x-init="fetchPolls()">
        <div class="pt-24 px-4 md:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">

                <!-- Search and Filter Section -->
                <div class="mb-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="relative flex-1 max-w-lg">
                        <input type="text" placeholder="Search polls..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent"
                            x-model="searchQuery" @input.debounce.500ms="searchPolls" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div class="flex gap-4">
                        <select x-model="selectedFilter" @change="fetchPolls"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#9b87f5] focus:border-transparent">
                            <option value="recent">Most Recent</option>
                            <option value="mostVoted">Most Voted</option>
                            <option value="endingSoon">Ending Soon</option>
                        </select>
                        <a href="{{ route('createPage') }}"
                            class="bg-[#9b87f5] hover:bg-[#8370f3] text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Create Poll
                        </a>
                    </div>
                </div>

                <!-- Polls Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-6 mb-8">
                    <template x-for="poll in polls" :key="poll.id">
                        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-[#403E43]" x-text="poll.title"></h3>
                                <button id="reportBtn" class="text-gray-400 hover:text-red-500">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.45 2.15C14.992 4.05652 17.5866 5 20.25 5C20.6642 5 21 5.33579 21 5.75V11C21 16.0012 18.0424 19.6757 12.2749 21.9478C12.0982 22.0174 11.9018 22.0174 11.7251 21.9478C5.95756 19.6757 3 16.0012 3 11V5.75C3 5.33579 3.33579 5 3.75 5C6.41341 5 9.00797 4.05652 11.55 2.15C11.8167 1.95 12.1833 1.95 12.45 2.15ZM12 3.67782C9.58084 5.38829 7.07735 6.32585 4.5 6.47793V11C4.5 15.2556 6.95337 18.3789 12 20.4419C17.0466 18.3789 19.5 15.2556 19.5 11V6.47793C16.9227 6.32585 14.4192 5.38829 12 3.67782ZM12 16C12.4142 16 12.75 16.3358 12.75 16.75C12.75 17.1642 12.4142 17.5 12 17.5C11.5858 17.5 11.25 17.1642 11.25 16.75C11.25 16.3358 11.5858 16 12 16ZM12 7.00356C12.3797 7.00356 12.6935 7.28572 12.7432 7.65179L12.75 7.75356V14.2523C12.75 14.6665 12.4142 15.0023 12 15.0023C11.6203 15.0023 11.3065 14.7201 11.2568 14.3541L11.25 14.2523V7.75356C11.25 7.33935 11.5858 7.00356 12 7.00356Z"
                                            fill="#212121" />
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3 mb-4">
                                <template x-for="object in poll.poll_options">
                                    <div class="relative">
                                        <div class="bg-gray-100 rounded-lg h-10 overflow-hidden">
                                            <div class="bg-[#9b87f5] h-full transition-all duration-500"
                                                :style="'width: ' + (optionTotalVotes(poll.poll_options) > 0 ? (object.votes /
                                                    optionTotalVotes(poll.poll_options) * 100) : 0) + '%'">
                                            </div>
                                        </div>

                                        <div class="absolute inset-0 flex items-center justify-between px-4">
                                            <span class="text-gray-700" x-text="object.option"></span>
                                            <span class="text-gray-700"
                                                x-text="(optionTotalVotes(poll.poll_options) > 0 ? Math.round(object.votes /
                                                    optionTotalVotes(poll.poll_options) * 100) : 0) + '%'">
                                            </span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span x-text="poll.total_vote + ' votes'"></span>
                                <span x-text="'Ends ' + new Date(poll.expire_at).toLocaleDateString()"></span>
                            </div>
                            <a :href="'{{ route('pollPage', '') }}/' + poll.poll_uid"
                                class="mt-4 block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                                Vote Now
                            </a>
                        </div>
                    </template>

                </div>

                <!-- Load More Button -->
                <div @click="loadMorePolls" class="text-center flex justify-center mb-12" x-cloak x-show="hasMore">
                    <x-utils.loadingBtn :name="'Load More Polls'" :style="'max-w-fit px-6 py-3'" />
                </div>
            </div>
        </div>
    </div>
@endsection
