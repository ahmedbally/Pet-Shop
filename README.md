<p align="center">
  <img src="https://www.buckhill.co.uk/assets/images/xlogo-blue.png.pagespeed.ic.PYdYfUPDLG.webp" width="250">
</p>

<h2 align="center">Buckhill | PetShop</h2>
<p align="center">https://buckhill.co.uk</p>

## Requirements

The app requires the following extensions in order to work properly:

-   `PHP >= 8.0`
-   `BCMath`
-   `Ctype`
-   `Fileinfo`
-   `JSON`
-   `Mbstring`
-   `OpenSSL`
-   `PDO`
-   `Tokenizer`
-   `XML`


## Installation

Follow the steps below to install the app quickly on your local machine.

Download Composer [here](https://getcomposer.org/download).

Credentials for authentication after migration

```
email : test@test.com
password : password
```

Install dependencies:

```bash
composer install
```

Generate app key:

```bash
php artisan key:generate
```

Run database migrations and seeds:

```bash
php artisan migrate --seed
```

Generate secret asymmetric keys for JWT:

```bash
ssh-keygen -t rsa -P "" -b 4096 -m PEM -f jwtRS256.key
ssh-keygen -e -m PEM -f jwtRS256.key > jwtRS256.key.pub
```

Run unit and feature tests:

```bash
composer test
```

LaraStan level 8

```bash
composer analyse
```
Start all Docker containers:

```bash
composer sail
```
