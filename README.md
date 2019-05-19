Once you clone the repo, Please do `composer install`
Following that please do `npm install`

Run `npm run dev` to generate front end files

Run `php artisan migrate`

Run `php artisan db:seed --class=TeamSeeder`
Run `php artisan db:seed --class=PlayerSeeder`

Please do add `OVERS` in your `.env` file. Recommended value is 20.

Your app is good to go
