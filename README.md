# Extended PHP

This respository provide PHP images with pre-build extensions.  
You can build you own one base on these images for time-saving.  

## Features

- Based on [official PHP image](https://hub.docker.com/_/php/), include [security support versions](https://www.php.net/supported-versions.php) and extra PHP 7.4
- Supported architectures: amd64, arm64v8, arm32v7
- Supported extensions: apcu, bcmath, bz2, event, exif, gd, gnupg, imagick, memcached, mongodb, mysqli, opcache, pcntl, pdo_mysql, pdo_pgsql, pgsql, protobuf, redis, sockets, ssh2, swoole, xdebug, zip, zstd
- Extensions are installed by [mlocati/docker-php-extension-installer](https://github.com/mlocati/docker-php-extension-installer)
- All installed extensions are diabled by default, feel free to enable them in needed  

## Why not install all available extensions?

In modern development, you don't need to use those outdated extensions in most cases.  
Some extensions are no longer maintained, and some don't even support PHP 8.  
There are alternative libraries written in pure PHP you can choose. For example, use the [php-amqplib](https://github.com/php-amqplib/php-amqplib) library instead of [php-amqp](https://github.com/php-amqp/php-amqp).  
If you really want a specific extension which is not installed in the image, you can just install it using mlocati/docker-php-extension-installer by your self.  

## License

The MIT License
