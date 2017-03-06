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
php -S localhost:8090 -t public/
```