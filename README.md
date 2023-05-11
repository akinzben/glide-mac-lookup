# glide-mac-lookup
This project takes  mac-addresses or OUI from users and report the vendor(s) back,

# Usage
Change the .env.example to .env and add your database info

### For mySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306

## PHP artisan command to update OUI data
php artisan oui:update

## OUI data update Command Schedule
A scheduler has been created in the Kernel.php file to run every Minute. 
A cron task will be used to automate this.

## API GET SINGLE MAC ADDRESS
Using POSTMAN - http://127.0.0.1:8000/api/v1/oui-check?Assignment[eq]=20:15:82:1A:0E:60

## API POST MULTIPLE MAC ADDRESSES
Using POSTMAN - http://127.0.0.1:8000/api/v1/oui-check

