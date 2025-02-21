@extends('components.client.feature.layout')

@section('page')
    <script>
        function profileComponent() {
            return {

                isOpen: false,
                language: 'en',
                notificationOpen: false,
                notifications: [],

                authToken: null,
                user: {
                    id: '',
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

                async getNotifications() {
                    try {
                        const response = await axios.get('{{ route('get.notifications') }}', {
                            headers: {
                                'Authorization': `Bearer ${this.authToken}`
                            }
                        });

                        this.notifications = response.data;
                    } catch (error) {}
                },

                async markAsRead() {
                    try {
                        const response = await axios.post('{{ route('markRead.post') }}', {}, {
                            headers: {
                                'Authorization': `Bearer ${this.authToken}`
                            }
                        });

                        this.notifications = [];
                    } catch (error) {}
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

                    this.$watch('isOwner', value => {
                        if (value) {
                            this.getNotifications();
                            Echo.private('pollEnd-Notification.' + this.user.id)
                                .listen('.pollEndEvent', (event) => {
                                    this.notifications.push({
                                        data: event
                                    });
                                });
                        }
                    });
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
                            <div class="flex justify-between">
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
                                <div>
                                    <x-client.components.notificationBell />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Polls Timeline -->
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-[#403E43] mb-4">Polls Timeline</h2>

                    <template x-for="poll in polls" :key="poll.poll_uid">
                        <x-client.components.profilePollResult />
                    </template>
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
