# Backend - The API for Tire Control Software

### Install dependencies

```
composer install
```

### Copy params dist file to params file and change database configs if necessary

```
cp config/parameters.yml.dist config/parameters.yml 
```

### Start local server

```
php -S localhost:8080 -t public/
```

### Test application

Check syntax errors with PHP Scan:
```
vendor/bin/phpstan analyse -v src/ --level 5
```

Check code style with PHP Code Sniffer:
```
./vendor/bin/phpcs -sw --standard=PSR2 --colors src/ tests/
```

Fix specific errors with PHP Code Sniffer:
```
./vendor/bin/phpcbf -w --standard=PSR2 file.php
```

Run unit tests and generate code coverage:
```
phpunit -c build/
```

Update documentation:
```
phpdox -f build/phpdox.xml
```

### Create a new user

```
php bin/console tire-control:create-user  
```
