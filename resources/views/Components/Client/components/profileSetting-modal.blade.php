         <!-- Settings Modal -->
         <div x-cloak x-show="showSettingsModal" class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="showSettingsModal = false">
             <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                 <div x-show="showSettingsModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                     @click="showSettingsModal = false">
                     <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                 </div>

                 <div x-show="showSettingsModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                     <div class="absolute top-0 right-0 pt-4 pr-4">
                         <button @click="showSettingsModal = false"
                             class="text-gray-400 hover:text-gray-500 focus:outline-none">
                             <span class="sr-only">Close</span>
                             <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M6 18L18 6M6 6l12 12" />
                             </svg>
                         </button>
                     </div>

                     <div class="sm:flex sm:items-start">
                         <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                             <h3 class="text-lg leading-6 font-medium text-gray-900">Account Settings</h3>

                             <form class="mt-6 space-y-6">
                                 <!-- Profile Picture -->
                                 <div class="flex items-center space-x-6">
                                     <div class="shrink-0">
                                         <img :src="user.profile_img ?? '{{ asset('user.jpg') }}'"
                                             class="h-16 w-16 object-cover rounded-full">
                                     </div>
                                     <label class="block">
                                         <span class="sr-only">Choose profile photo</span>
                                         <input type="file" accept="image/*"
                                             class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#9b87f5] file:text-white hover:file:bg-[#8370f3]">
                                     </label>
                                 </div>

                                 <!-- Name -->
                                 <div>
                                     <label for="settings-name"
                                         class="block text-sm font-medium text-gray-700">Name</label>
                                     <input disabled type="text" id="settings-name" x-model="settingsForm.username"
                                         class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#9b87f5] focus:ring-[#9b87f5]">
                                 </div>

                                 <!-- Email -->
                                 <div>
                                     <label for="settings-email"
                                         class="block text-sm font-medium text-gray-700">Email</label>
                                     <input disabled type="email" id="settings-email" x-model="settingsForm.email"
                                         class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#9b87f5] focus:ring-[#9b87f5]">
                                 </div>

                                 <!-- Change Password Section -->
                                 <div class="space-y-4">
                                     <div class="relative">
                                         <label for="current-password"
                                             class="block text-sm font-medium text-gray-700">Current Password</label>
                                         <input :type="settingsForm.showCurrentPassword ? 'text' : 'password'"
                                             id="current-password" x-model="settingsForm.currentPassword"
                                             class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#9b87f5] focus:ring-[#9b87f5]">
                                         <button type="button"
                                             @click="settingsForm.showCurrentPassword = !settingsForm.showCurrentPassword"
                                             class="absolute inset-y-0 right-0 pr-3 flex items-center top-6">
                                             <svg x-show="!settingsForm.showCurrentPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                             </svg>
                                             <svg x-show="settingsForm.showCurrentPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                             </svg>
                                         </button>
                                     </div>

                                     <div class="relative">
                                         <label for="new-password" class="block text-sm font-medium text-gray-700">New
                                             Password</label>
                                         <input :type="settingsForm.showNewPassword ? 'text' : 'password'"
                                             id="new-password" x-model="settingsForm.newPassword"
                                             class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#9b87f5] focus:ring-[#9b87f5]">
                                         <button type="button"
                                             @click="settingsForm.showNewPassword = !settingsForm.showNewPassword"
                                             class="absolute inset-y-0 right-0 pr-3 flex items-center top-6">
                                             <svg x-show="!settingsForm.showNewPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2"
                                                     d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                             </svg>
                                             <svg x-show="settingsForm.showNewPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2"
                                                     d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                             </svg>
                                         </button>
                                     </div>

                                     <div class="relative">
                                         <label for="confirm-new-password"
                                             class="block text-sm font-medium text-gray-700">Confirm New
                                             Password</label>
                                         <input :type="settingsForm.showConfirmPassword ? 'text' : 'password'"
                                             id="confirm-new-password" x-model="settingsForm.confirmPassword"
                                             class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#9b87f5] focus:ring-[#9b87f5]">
                                         <button type="button"
                                             @click="settingsForm.showConfirmPassword = !settingsForm.showConfirmPassword"
                                             class="absolute inset-y-0 right-0 pr-3 flex items-center top-6">
                                             <svg x-show="!settingsForm.showConfirmPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2"
                                                     d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                             </svg>
                                             <svg x-show="settingsForm.showConfirmPassword"
                                                 xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round"
                                                     stroke-width="2"
                                                     d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                             </svg>
                                         </button>
                                     </div>
                                 </div>

                                 <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                     <button type="submit"
                                         class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#9b87f5] text-base font-medium text-white hover:bg-[#8370f3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9b87f5] sm:ml-3 sm:w-auto sm:text-sm">
                                         Save Changes
                                     </button>
                                     <button type="button" @click="showSettingsModal = false"
                                         class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#9b87f5] sm:mt-0 sm:w-auto sm:text-sm">
                                         Cancel
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
