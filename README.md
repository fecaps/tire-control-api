# The Web API for Tire Control Software

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ca0ce2fb86ba423bae951e183e321b25)](https://www.codacy.com/app/fecaps/tire_control_api?utm_source=github.com&utm_medium=referral&utm_content=fecaps/tire_control_api&utm_campaign=badger)

### Install dependencies

```
composer install
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

Run unit tests and generate code coverage:
```
phpunit -c build/
```

Update documentation:
```
phpdox -f build/phpdox.xml
```

### Usage

Copy params dist file to params file and change database configs if necessary:
```
cp config/parameters.yml.dist config/parameters.yml 
```

Start local server:

```
php -S localhost:8080 -t public/
```

Create a new user:

```
php bin/console tire-control:create-user  
```
