 @extends('errors.layout')
 @section('content')
     <!-- Coming Soon -->
     <div class="min-h-screen flex items-center justify-center px-4">
         <div class="max-w-md w-full text-center" x-data="{
             email: '',
             submitted: false,
             isValid: false,
             message: '',
             submit() {
                 if (!this.email) {
                     this.message = 'Please enter your email';
                     return;
                 }
                 if (!this.isValid) {
                     this.message = 'Please enter a valid email';
                     return;
                 }
                 this.submitted = true;
                 this.message = 'Thank you for subscribing!';
                 this.email = '';
             },
             validateEmail() {
                 const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                 this.isValid = re.test(this.email);
             }
         }">
             <div class="space-y-6">
                 <!-- Logo -->
                 <div class="flex items-center justify-center gap-2 text-2xl font-bold text-[#403E43]">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="text-[#9b87f5]">
                         <path d="M3 3v18h18"></path>
                         <path d="M18 17V9"></path>
                         <path d="M13 17V5"></path>
                         <path d="M8 17v-3"></path>
                     </svg>
                     Pollux
                 </div>
                 <!-- Content -->
                 <div class="space-y-4">
                     <h1 class="text-4xl font-bold text-[#403E43]">
                         We are launching soon 🚀
                     </h1>
                 </div>
                 <!-- Form -->
                 <form @submit.prevent="submit()" class="space-y-4">
                     <div class="flex flex-col sm:flex-row gap-3">
                         <div class="flex-1">
                             <input type="email" x-model="email" @input="validateEmail()" placeholder="Enter your email"
                                 class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#9b87f5] focus:ring-2 focus:ring-[#9b87f5] focus:ring-opacity-20 outline-none transition-all"
                                 :class="{ 'border-red-500': message && !isValid && email }" />
                         </div>
                         <button type="submit"
                             class="px-6 py-3 bg-[#9b87f5] hover:bg-[#8370f3] text-white rounded-lg transition-colors duration-200 whitespace-nowrap">
                             Notify Me
                         </button>
                     </div>
                     <!-- Message -->
                     <p x-show="message" x-text="message"
                         :class="{ 'text-green-600': submitted, 'text-red-500': !submitted }" class="text-sm"></p>
                 </form>
                 <!-- Additional Info -->
                 <div class="pt-8 text-[#666666]">
                     <p class="text-sm">
                         Don't worry, we won't spam you. You can unsubscribe at any time.
                     </p>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Coming Soon -->
 @endsection
