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
              <span x-show="!poll.public_visibility"
                  class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                  Private
              </span>
              <span class="px-3 py-1 rounded-full text-sm font-medium"
                  :class="{
                      'bg-green-100 text-green-800': poll.status === 'active',
                      'bg-red-100 text-red-800': poll.status === 'restricted',
                      'bg-gray-100 text-gray-800': !['active', 'restricted'].includes(poll
                          .status)
                  }"
                  x-text="poll.status">
              </span>

              <!-- Icon Delete Button -->
              <template x-if="poll.status=='active' && isOwner">
                  <button @click="deletePoll(poll.poll_uid)" class="text-gray-400 hover:text-red-600 transition-colors">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round">
                          <path d="M3 6h18"></path>
                          <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                          <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </svg>
                  </button>
              </template>
          </div>
      </div>
      <template x-if="!poll.public_visibility">
          <a :href="poll.signature"
              class="inline-flex items-center gap-2 text-yellow-500 hover:text-[#8370f3] transition-colors">
              View Private Poll
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
          </a>
      </template>
      <template x-if="poll.public_visibility">
          <a :href="'{{ route('pollPage', '') }}/' + poll.poll_uid"
              class="inline-flex items-center gap-2 text-[#9b87f5] hover:text-[#8370f3] transition-colors">
              View Poll
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14M12 5l7 7-7 7" />
              </svg>
          </a>
      </template>
  </div>
