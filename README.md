## GETTING STARTED
### Installing composer dependencies
composer install
### Installing npm dependencies
npm install

### Create env file and generate encryption key
cp .env.example .env

php artisan key:generate

### See changes made in SASS and JS
npm run dev
#### or for automatic refreshing
npm run watch
