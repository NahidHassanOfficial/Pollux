@extends('components.client.feature.layout')

@section('page')
    <script src="{{ asset('js/auth.js') }}"></script>

    <script>
        function profileComponent() {
            return {
                authToken: null,
                user: {
                    username: '',
                    total_poll: 0,
                    created_at: new Date(),
                },
                activePoll: 0,
                polls: [],
                isOwner: false,

                nextPage: 1,
                lastPage: 1,
                isLoading: false,

                url: window.location.href,
                userHandler: '',

                async getUser() {
                    const infoResponse = await axios.get(`{{ route('userInfo') }}/${this.userHandler}`, {
                        headers: {
                            'Authorization': `Bearer ${this.authToken}`
                        }
                    });
                    this.user = infoResponse.data.data.user;
                    this.activePoll = infoResponse.data.data.activePoll;

                },

                async getPolls() {
                    if (this.isLoading) return;
                    this.isLoading = true;

                    try {
                        const response = await axios.get(
                            `{{ route('userPolls') }}/${this.userHandler}?page=${this.nextPage}`, {
                                headers: {
                                    'Authorization': `Bearer ${this.authToken}`
                                }
                            });
                        this.polls.push(...response.data.data.polls.data);
                        this.isOwner = response.data.data.isOwner;

                        this.lastPage = response.data.data.polls.last_page;
                        if (this.lastPage >= this.nextPage) {
                            this.nextPage++;
                        }
                    } catch (error) {
                        console.error('Error loading more polls');
                    } finally {
                        this.isLoading = false;
                        this.$nextTick(() => {
                            this.setupInfiniteScroll();
                        });
                    }
                },

                async deletePoll(poll_uid) {
                    try {
                        const response = axios.post('{{ route('poll.delete') }}', {
                            'poll_uid': poll_uid,
                        }, {
                            headers: {
                                'Authorization': `Bearer ${this.authToken}`
                            }
                        });

                        toast('Poll deleted successfully');
                        this.polls = this.polls.filter(poll => poll.poll_uid !== poll_uid);
                    } catch (error) {
                        toast('Something wrong!', 'error');
                    }
                },

                setupInfiniteScroll() {
                    this.$nextTick(() => {
                        const loadMoreButton = document.querySelector('.load-more-button');
                        const observer = new IntersectionObserver(
                            (entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        this.getPolls();
                                    }
                                });
                            }, {
                                rootMargin: '0px',
                                threshold: 0.1,
                            }
                        );
                        observer.observe(loadMoreButton);
                    });
                },

                init() {
                    this.userHandler = this.url.includes('@') ? this.url.split('@').pop() : '';
                    this.authToken = getAuthToken();

                    //if auth_token and userhandler exist on url
                    if (this.userHandler !== this.authToken) {
                        this.getUser();
                        this.getPolls();

                        this.$nextTick(() => {
                            this.setupInfiniteScroll();
                        });
                    }
                },

                timeAgo(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffInSeconds = Math.floor((now - date) / 1000);
                    const units = [{
                            name: "year",
                            seconds: 31536000
                        },
                        {
                            name: "month",
                            seconds: 2592000
                        },
                        {
                            name: "week",
                            seconds: 604800
                        },
                        {
                            name: "day",
                            seconds: 86400
                        },
                        {
                            name: "hour",
                            seconds: 3600
                        },
                        {
                            name: "minute",
                            seconds: 60
                        },
                        {
                            name: "second",
                            seconds: 1
                        }
                    ];
                    for (const unit of units) {
                        const interval = Math.floor(diffInSeconds / unit.seconds);
                        if (interval >= 1) {
                            return new Intl.RelativeTimeFormat('en', {
                                    numeric: "auto"
                                })
                                .format(-interval, unit.name);
                        }
                    }
                    return "Just now";
                },
            };
        }
    </script>

    <div x-data="profileComponent()">
        <div class="pt-24 px-4 md:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto mb-12">
                <!-- Profile Header -->
                <div class="bg-white rounded-lg shadow-lg p-6 md:p-8 mb-8">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <img :src="user.profile_img ?? '{{ asset('user.jpg') }}'"
                            class="w-32 h-32 rounded-full object-cover border-4 border-[#9b87f5]">
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-2xl font-bold text-[#403E43] mb-2" x-text="'@' + user.username"></h1>
                            <p class="text-gray-600 mb-4" x-text="'Member since ' + timeAgo(user.created_at)"></p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-[#9b87f5]" x-text="user.total_poll"></div>
                                    <div class="text-sm text-gray-600">Total Polls</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-[#9b87f5]" x-text="activePoll"></div>
                                    <div class="text-sm text-gray-600">Active Polls</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Polls Timeline -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-[#403E43] mb-4">Polls Timeline</h2>

                    <template x-for="poll in polls" :key="poll.poll_uid">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-[#403E43]" x-text="poll.title"></h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span x-text="poll.total_vote + ' votes'"></span>
                                        <span class="mx-2">•</span>
                                        <span x-text="'Ends ' + new Date(poll.expire_at).toLocaleDateString()"></span>
                                    </p>
                                </div>
                                <div class="flex justify-center space-x-3">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="{
                                            'bg-green-100 text-green-800': poll.status === 'active',
                                            'bg-red-100 text-red-800': poll.status === 'restricted',
                                            'bg-gray-100 text-gray-800': !['active', 'restricted'].includes(poll.status)
                                        }"
                                        x-text="poll.status">
                                    </span>

                                    <!-- Icon Delete Button -->
                                    <template x-if="poll.status=='active' && isOwner">
                                        <button @click="deletePoll(poll.poll_uid)"
                                            class="text-gray-400 hover:text-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </template>
                                </div>

                            </div>
                            <a :href="'{{ route('pollPage', '') }}/' + poll.poll_uid"
                                class="inline-flex items-center gap-2 text-[#9b87f5] hover:text-[#8370f3] transition-colors">
                                View Poll
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Load More Button -->
                <div x-show="nextPage<=lastPage" class="load-more-button flex justify-center my-8">
                    <x-utils.loadingBtn :name="'Load More Polls'" :style="'max-w-fit px-6 py-3'" />
                </div>
            </div>
        </div>
    </div>
@endsection
