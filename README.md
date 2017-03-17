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
vendor/bin/phpstan analyse -v src/ tests/
```

Check code style with PHP Code Sniffer:
```
./vendor/bin/phpcs --colors src/ tests/unit/
```

Fix specific errors with PHP Code Sniffer:
```
./vendor/bin/phpcbf -n file.php
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
