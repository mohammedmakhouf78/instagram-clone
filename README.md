# Instagram Clone Using Laravel and Inertia with Vue js
* register
* login
* make a post
* comment - like
* follow - unfollow
* profile page
* on scroll loading

## Screenshots
(readme/img1.png)

## Run Locally

Clone the project

```bash
  git clone https://github.com/mohammedmakhouf78/instagram-clone.git
```

Go to the project directory

```bash
  cd my-project
```

Install dependencies

```bash
  npm install
```

```bash
  composer install
```

```bash
  cp .env.example .env
```

generate the key for the laravel project

```bash
  php artisan key:generate
```
use your database config in .env
then run the migrations

```bash
  php artisan migrate
```

generate the keys of passport

```bash
  php artisan passport:install
```

build the front end code

```bash
  npm run dev
```
run the project

```bash
 php artisan serve
```
