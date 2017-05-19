# The Web API for Tire Control Software

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ca0ce2fb86ba423bae951e183e321b25)](https://www.codacy.com/app/fecaps/tire-control-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=fecaps/tire-control-api&amp;utm_campaign=Badge_Grade)

### Install dependencies

```
$ composer install
```

### Test application

Script to check for syntax errors, code style, raw metrics stream and perform unit tests:
```
$ chmod +x scripts/pre-commit.sh
$ ./scripts/pre-commit.sh
```

### Usage

Copy params dist file to params file and change database configs if necessary:
```
$ cp config/parameters.yml.dist config/parameters.yml 
```

Access **PostgreSQL** (default) and create tire_control:
```
CREATE DATABASE tire_control; 
```

Create database schema using Doctrine ORM:
```
$ vendor/bin/doctrine orm:schema-tool:create 
```

Start local server:
```
$ php -S localhost:8080 -t public/
```

### Endpoints

Generating local HTML file to check out the available endpoints:
```
$ aglio -i apiary.apib -o apiary.html
```

Check out the API [documentation online](http://docs.tirecontrol.apiary.io/ "Tire Control API Doc").