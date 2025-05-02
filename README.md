# Instagram Clone Using Laravel and Inertia with Vue js
* register
* login
* make a post
* comment - like
* follow - unfollow
* profile page
* on scroll loading

## Screenshots

![Screenshot from 2025-05-02 13-07-19](https://github.com/user-attachments/assets/03df8272-1c81-48af-a476-5df8689973ec)
![screencapture-127-0-0-1-8000-profile-2025-05-02-13_16_52](https://github.com/user-attachments/assets/f6d74b6d-73c0-4d3f-b504-d360f255eaf9)
![screencapture-127-0-0-1-8000-2025-05-02-13_16_23](https://github.com/user-attachments/assets/7ec02b00-06f2-4f92-ad3c-8c34536efe92)
![screencapture-127-0-0-1-8000-2025-05-02-13_15_12](https://github.com/user-attachments/assets/e5ffa782-4ce1-4edc-92b0-7f1f34e954d5)
![screencapture-127-0-0-1-8000-2025-05-02-13_14_52](https://github.com/user-attachments/assets/65da0ba5-2195-4618-bb53-723c2e35efbe)
![screencapture-127-0-0-1-8000-2025-05-02-13_13_27](https://github.com/user-attachments/assets/de09aa62-935e-4c54-941d-86a365c6db56)

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
