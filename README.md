## Установка

#### 1. Composer
`Клонувати проект за допомогою git clone https://github.com/VoloshynVolodymyr/dZEN.git`
`Створити порожню папку cache/ в папці bootstrap і порожню папку storage/images/ в папці public`
`Створити файл .env на основі .env.example. Зробити підключення до бази даних. Я використовував sqlite. Для цього в папці database створити файл .database.sqlite і підключити базу даних у вкладці Database`

`composer install`

#### 2. Npm

`npm install`

`npm run dev`

#### 3. Laravel

`php artisan migrate`

`php artisan db:seed`

`php artisan serve`
