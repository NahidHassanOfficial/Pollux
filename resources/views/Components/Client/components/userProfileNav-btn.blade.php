 <div class="relative">
     <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-3 focus:outline-none">
         <img :src="user.profile_img ?? '{{ asset('user.jpg') }}'"
             class="h-8 w-8 rounded-full object-cover border-2 border-transparent hover:border-[#9b87f5]">
         <span class="text-gray-700" x-text="user.username"></span>
         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
             <path fill-rule="evenodd"
                 d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                 clip-rule="evenodd" />
         </svg>
     </button>

     <!-- Dropdown Menu -->
     <div x-show="showUserMenu" @click.away="showUserMenu = false" x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
         style="display: none;">
         <a href="{{ route('profilePage') }}"
             class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
         <button @click="showSettingsModal = true; showUserMenu = false"
             class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
             Settings
         </button>
         <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click.prevent="logout">
             Sign out
         </a>
     </div>
 </div>
