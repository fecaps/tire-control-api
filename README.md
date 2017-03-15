# Backend - The API for Tire Control Software

### Install dependencies

```
composer install
```

### Copy params dist file to params file and change database configs if necessary

```
cp config/params.yml.dist config/params.yml  
```

### Start local server

```
php -S localhost:8080 -t public/
```

### Test application

Check syntax errors with Php Scan:
```
vendor/bin/phpstan analyse -v src/ tests/
```

Check code style with Code Sniffer:
```
./vendor/bin/phpcs --colors src/ tests/
```

Fix specific errors with Code Sniffer:
```
./vendor/bin/phpcbf -n file.php


### Create a new user

```
php bin/console tire-control:create-user  
```
