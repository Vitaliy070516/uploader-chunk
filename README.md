## START

- git clone https://github.com/Vitaliy070516/uploader-chunk.git
- cd uploader-chunk
- git checkout uploader-chunk-1 (there is also another branch "uploader-base" with uploader without chunks)
- docker-compose up -d (for run composer inside container)
- docker exec -it uploader-chunk-laravel.test-1 sh
- composer install
- exit
- ./vendor/bin/sail up -d
- ./vendor/bin/sail npm install
- ./vendor/bin/sail artisan migrate
- ./vendor/bin/sail npm run build
- http://localhost/

#mysql
- host - localhost
- port - 3333
- user - sail
- password - password
- db - larexp
