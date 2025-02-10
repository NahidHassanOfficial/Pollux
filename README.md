# Pollux - Online Voting System 🗳️

Pollux is a feature-rich online voting system that allows users to create polls and share them publicly or privately. With real-time notifications, advanced security measures, and a robust admin panel, Pollux ensures a seamless and secure voting experience.

---

## 🚀 Features

- **User Registration & Authentication**: Secure login and registration using Laravel Sanctum.
- **Create & Manage Polls**: Users can create polls and choose between **public** or **private** access.
- **Signed URL for Private Polls**: Share private polls with a unique signed link.
- **Public Poll Feed**: Discover and vote on polls created by other users.
- **User Profiles**: View all polls created by a specific user.
- **Real-time Notifications**: Users receive instant alerts when a poll ends.
- **Email Result Delivery**: Poll results are sent via email once a poll concludes.
- **Fraud Prevention**: Prevents duplicate votes using FingerprintJS, IP tracking, and User-Agent filtering.
- **Admin Panel with Analytics**: Built with Filament, featuring **role-based access control**.
- **Scheduled Tasks & Queue Management**: Automates updates and triggers events when polls end.
- **Localization Support**: Multi-language support for a global audience.

---

## 🛠️ Technologies Used

### **Frontend**
- **Blade & Alpine.js**: Dynamic UI components
- **Tailwind CSS**: Clean and modern styling
- **Axios**: Efficient API requests

### **Backend**
- **Laravel (Sanctum, RESTful API)**: Secure and structured backend
- **Event, Listener, Queue, Jobs**: Optimized event-driven architecture
- **Notifications & Mail**: Real-time user engagement
- **Reverb & Observer Pattern**: Ensuring smooth event handling
- **Database Caching**: Optimized performance
- **Filament Admin Panel**: Role-based access and analytics
- **FingerprintJS & Custom Filtering**: Prevent duplicate voting

### **Additional Features**
- **Social Authentication (Laravel Socialite)**
- **Scheduled Commands for Auto-Updates**

---

## 📦 Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/your-username/pollux.git
   cd pollux
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install && npm run build
   ```
3. Set up the environment:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Configure database and run migrations:
   ```sh
   php artisan migrate --seed
   ```
5. Ensure the following PHP extensions are enabled in your local environment:
   ```ini
   extension=intl
   extension=zip
   ```
6. Update mail credentials in `.env` to enable email notifications.
7. Update Reverb credentials in `.env` before starting.
8. Start the development server:
   ```sh
   php artisan serve
   ```
9. Run the queue worker for real-time notifications and job processing:
   ```sh
   php artisan queue:work
   ```
10. Start Reverb for real-time event broadcasting:
   ```sh
   reverb:start
   ```
11. Start frontend development server:
   ```sh
   npm run dev
   ```
12. Run scheduled tasks for poll updates:
   ```sh
   php artisan schedule:work
   ```
