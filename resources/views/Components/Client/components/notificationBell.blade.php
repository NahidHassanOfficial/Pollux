 <!-- Notification Bell -->
 <div class="relative">
     <button @click="notificationOpen = !notificationOpen" @click.away="notificationOpen = false"
         class="p-2 hover:bg-gray-100 rounded-full transition-colors relative">
         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
             <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
             <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
         </svg>
         <!-- Notification Badge -->
         <span x-show="notifications.filter(n => !n.read).length > 0"
             class="absolute top-1 right-1 bg-[#9b87f5] text-white text-xs w-4 h-4 flex items-center justify-center rounded-full"
             x-text="notifications.filter(n => !n.read).length"></span>
     </button>

     <!-- Notification Dropdown -->
     <div x-show="notificationOpen" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50"
         style="display: none;">
         <div class="px-4 py-2 border-b border-gray-100">
             <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
         </div>
         <div class="max-h-[300px] overflow-y-auto">
             <template x-for="(notification, index) in notifications" :key="index">
                 <a href="#" class="px-4 py-3 hover:bg-gray-50 transition-colors cursor-pointer"
                     :class="{ 'bg-blue-50/50': !notification.read }">
                     <h4 class="text-sm font-medium text-gray-900" x-text="notification.title"></h4>
                     <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                     <span class="text-xs text-gray-500 mt-1 block" x-text="notification.time"></span>
                 </a>
             </template>
         </div>
         <div class="px-4 py-2 border-t border-gray-100">
             <button class="text-sm text-[#9b87f5] hover:text-[#8370f3] transition-colors w-full text-center"
                 @click="notifications.forEach(n => n.read = true)">
                 Mark all as read
             </button>
         </div>
     </div>
 </div>
