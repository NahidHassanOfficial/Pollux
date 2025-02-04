 <!-- Navigation -->
 <script src="{{ asset('js/auth.js') }}"></script>
 <script>
     function navComponent() {
         return {
             isOpen: false,
             showUserMenu: false,
             showSettingsModal: false,
             user: {},
             authToken: null,

             settingsForm: {
                 username: '',
                 email: '',
                 currentPassword: '',
                 newPassword: '',
                 confirmPassword: '',
                 showCurrentPassword: false,
                 showNewPassword: false,
                 showConfirmPassword: false,
                 avatar: null
             },

             async getUser() {
                 try {
                     const response = await axios.get('{{ route('auth.user') }}', {
                         headers: {
                             'Authorization': 'Bearer ' + this.authToken
                         }
                     });
                     this.user = response.data.data;
                 } catch (error) {
                     //  console.error('Authentication failed');
                 }
             },

             async logout() {
                 try {
                     await axios.post("{{ route('logout.post') }}", {}, {
                         headers: {
                             'Authorization': `Bearer ${this.authToken}`
                         }
                     });
                     document.cookie = 'auth_token' + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                     window.location.href = "{{ route('index') }}";
                 } catch (error) {
                     console.error('Error during logout:', error.message);
                 }
             },

             async init() {
                 this.authToken = getAuthToken();
                 await this.getUser();

                 this.settingsForm.username = this.user.username;
                 this.settingsForm.email = this.user.email;
             }
         }
     }
 </script>
 <div x-data="navComponent">
     <nav class="bg-white shadow-sm fixed w-full z-50">
         <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="flex justify-between h-16">

                 <x-logo></x-logo>

                 <!-- Desktop Navigation -->
                 <div class="hidden md:flex md:items-center md:space-x-8">
                     <a href="{{ route('pollFeed') }}"
                         class="text-[#666666] hover:text-[#9b87f5] transition-colors">Public
                         Polls</a>
                     <a href="{{ route('createPage') }}"
                         class="text-[#666666] hover:text-[#9b87f5] transition-colors">Create
                         Poll</a>
                     <a href="#" class="text-[#666666] hover:text-[#9b87f5] transition-colors">About</a>
                     <a href="#" class="text-[#666666] hover:text-[#9b87f5] transition-colors">Contact</a>
                 </div>

                 <!-- Desktop User Menu -->
                 <div class="hidden md:flex md:items-center md:space-x-4">
                     <!-- Show this when user is not logged in -->
                     @guest
                         <div class="flex items-center space-x-4">
                             <a href="{{ route('loginPage') }}"
                                 class="text-[#666666] hover:text-[#9b87f5] transition-colors">Sign
                                 in</a>
                             <a href="{{ route('registerPage') }}"
                                 class="bg-[#9b87f5] hover:bg-[#8370f3] text-white px-4 py-2 rounded-lg transition-colors">
                                 Get Started
                             </a>
                         </div>
                     @endguest

                     <!-- Show this when user is logged in -->
                     @auth
                         <x-client.components.userProfileNav-btn />
                     @endauth
                 </div>

                 <!-- Mobile menu button -->
                 <div class="flex items-center md:hidden">
                     <button @click="isOpen = !isOpen" class="text-[#666666] hover:text-[#9b87f5] transition-colors">
                         <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M4 6h16M4 12h16M4 18h16" />
                         </svg>
                         <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Mobile menu -->
         <div x-show="isOpen" class="md:hidden bg-white border-t" style="display: none;" @click.away="isOpen = false">
             <div class="px-2 pt-2 pb-3 space-y-1">
                 <a href="{{ route('pollFeed') }}"
                     class="block px-3 py-2 text-[#666666] hover:text-[#9b87f5] transition-colors">Public
                     Polls</a>
                 <a href="{{ route('createPage') }}"
                     class="block px-3 py-2 text-[#666666] hover:text-[#9b87f5] transition-colors">Create
                     Poll</a>
                 <a href="#"
                     class="block px-3 py-2 text-[#666666] hover:text-[#9b87f5] transition-colors">About</a>
                 <a href="#"
                     class="block px-3 py-2 text-[#666666] hover:text-[#9b87f5] transition-colors">Contact</a>
                 @guest
                     <a href="{{ route('loginPage') }}"
                         class="block px-3 py-2 text-[#666666] hover:text-[#9b87f5] transition-colors">Sign
                         in</a>
                     <a href="{{ route('registerPage') }}"
                         class="block px-3 py-2 bg-[#9b87f5] text-white rounded-lg hover:bg-[#8370f3] transition-colors">Get
                         Started</a>
                 @endguest

                 @auth
                     <x-client.components.userProfileNav-btn />
                 @endauth
             </div>
         </div>
     </nav>


     <x-client.components.profileSetting-modal />
 </div>
