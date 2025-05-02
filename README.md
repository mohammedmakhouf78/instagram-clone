# Instagram Clone Using Laravel and Inertia with Vue js
* register
* login
* make a post
* comment - like
* follow - unfollow
* profile page
* on scroll loading

## Screenshots

![App Screenshot](https://drive.google.com/file/d/1885XF8jTOZp6NYbl-D8zUpc2fHOfGEur/view?usp=sharing)
![App Screenshot](https://drive.google.com/file/d/14mwjCIadWsnq8uKMMy4ivF2wQfM5zxKq/view?usp=drive_link)
![App Screenshot](https://drive.google.com/file/d/1Ix_kGzHZ-Li_gAceOLBeOCETNysULY0Y/view?usp=drive_link)
![App Screenshot](https://drive.google.com/file/d/16QP_3Rq3YV9CU6-nh4uHJgmXANSWTmhM/view?usp=drive_link)
![App Screenshot](https://drive.google.com/file/d/1TXFZMDWgNAdGGwhaXtnGkgA_st6GwabV/view?usp=drive_link)
![App Screenshot](https://drive.google.com/file/d/1wEOSTOFCG-1CZFIRbpcOUcPQoAUsHoin/view?usp=drive_link)
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
