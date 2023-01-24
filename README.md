# Extended PHP

This respository provide PHP images with pre-build extensions.  
You can build you own one base on these images for time-saving.  

## Features

- Based on [official PHP image](https://hub.docker.com/_/php/), include [security support versions](https://www.php.net/supported-versions.php) and extra PHP 7.4
- Supported architectures: amd64, arm64v8, arm32v7
- Supported extensions: apcu, bcmath, bz2, event, exif, gd, gnupg, imagick, memcached, mongodb, mysqli, opcache, pcntl, pdo_mysql, pdo_pgsql, pgsql, protobuf, redis, sockets, ssh2, swoole, xdebug, zip, zstd
- Extensions are installed by [mlocati/docker-php-extension-installer](https://github.com/mlocati/docker-php-extension-installer)
- All installed extensions are diabled by default, feel free to enable them in needed  

## Build status

| PHP  | Base image | Platform                | Status |
| ---- | ---------- | ----------------------- | ------ |
| 8.2  | fpm        | amd64, arm64v8          | [![8.2-fpm](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-fpm.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-fpm.yml) |
|      | fpm-alpine | amd64, arm64v8, arm32v7 | [![8.2-fpm-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-fpm-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-fpm-alpine.yml) |
|      | cli        | amd64, arm64v8          | [![8.2-cli](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-cli.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-cli.yml) |
|      | cli-alpine | amd64, arm64v8, arm32v7 | [![8.2-cli-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-cli-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-82-cli-alpine.yml) |
| 8.1  | fpm        | amd64, arm64v8          | [![8.1-fpm](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-fpm.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-fpm.yml) |
|      | fpm-alpine | amd64, arm64v8, arm32v7 | [![8.1-fpm-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-fpm-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-fpm-alpine.yml) |
|      | cli        | amd64, arm64v8          | [![8.1-cli](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-cli.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-cli.yml) |
|      | cli-alpine | amd64, arm64v8, arm32v7 | [![8.1-cli-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-cli-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-81-cli-alpine.yml) |
| 8.0  | fpm        | amd64, arm64v8, arm32v7 | [![8.0-fpm](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-fpm.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-fpm.yml) |
|      | fpm-alpine | amd64, arm64v8, arm32v7 | [![8.0-fpm-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-fpm-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-fpm-alpine.yml) |
|      | cli        | amd64, arm64v8, arm32v7 | [![8.0-cli](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-cli.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-cli.yml) |
|      | cli-alpine | amd64, arm64v8, arm32v7 | [![8.0-cli-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-cli-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-80-cli-alpine.yml) |
| 7.4  | fpm        | amd64, arm64v8, arm32v7 | [![7.4-fpm](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-fpm.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-fpm.yml) |
|      | fpm-alpine | amd64, arm64v8, arm32v7 | [![7.4-fpm-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-fpm-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-fpm-alpine.yml) |
|      | cli        | amd64, arm64v8, arm32v7 | [![7.4-cli](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-cli.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-cli.yml) |
|      | cli-alpine | amd64, arm64v8, arm32v7 | [![7.4-cli-alpine](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-cli-alpine.yml/badge.svg?branch=publish)](https://github.com/chrishyze/extended-php-image/actions/workflows/publish-74-cli-alpine.yml) |

## How to enable extension

Just use `/usr/local/etc/php/php.ini` to configure the extension.  

```shell
echo 'zend_extension=xdebug' >> /usr/local/etc/php/php.ini
```

Or add an independent ini file to `/usr/local/etc/php/conf.d/` directory.  

```shell
echo 'zend_extension=xdebug' > /usr/local/etc/php/conf.d/xdebug.ini
```

Don't forget to reload the configuration if you are using php-fpm.  

Since you are using Docker, you can also prepare a directory contains configure files and then mount the directory.  

```shell
docker run -v /path/to/config/directory:/usr/local/etc/php ...
```

## Why not install all available extensions?

In modern development, you don't need to use those outdated extensions in most cases.  
Some extensions are no longer maintained, and some don't even support PHP 8.  
There are alternative libraries written in pure PHP you can choose. For example, use the [php-amqplib](https://github.com/php-amqplib/php-amqplib) library instead of [php-amqp](https://github.com/php-amqp/php-amqp).  
If you really want a specific extension which is not installed in the image, you can just install it using mlocati/docker-php-extension-installer by your self.  

## License

The MIT License
