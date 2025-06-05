📦 Laravel Invoice System Setup Guide
This guide will help you install, configure, and run the Laravel Invoice System on your local development machine.

Step 1 : ENV SETUP 
step 2 : Migrate Database with Seeder 
        
        Php artisan migrate --seed

step 3: Install Frontend Assets (For Laravel Breeze Views)
npm install
npm run dev

Step 4 :Serve the Project
php artisan serve

Step 5: Start the Queue Worker (Required for Excel Import)
php artisan queue:work


php artisan queue:table
php artisan migrate


env .
QUEUE_CONNECTION=database


📌 Notes
Laravel Breeze is used for authentication and layout scaffolding.

Excel product import is processed via queued jobs to handle large files without timeout.

You can monitor queued jobs in your jobs table (requires QUEUE_CONNECTION=database).
