# Portal

Aplikasi web portal berbasis PHP untuk manajemen anggota, berita, dan lowongan pekerjaan 👌

## Development

1. Download [docker CE](https://store.docker.com/search?offering=community&type=edition) sesuai dengan sistem operasi kamu.
2. Clone repositori ini: `git clone https://github.com/maman/Portal`.
3. Masuk ke direktori aplikasi: `cd Portal`.
4. Install dependensi dengan composer: `docker run --rm -v (pwd):/app composer/composer:latest install`.
5. Jalankan aplikasi: `docker-compose up`.
6. Buka browser, dan buka [http://localhost:9091](http://localhost:9091).

## Deployment

TODO - buat manual untuk deployment

## Tech Stack

* PHP-FPM 7.x
* nginx
* MariaDB
* redis

## Lisensi
[MIT](LICENSE)
