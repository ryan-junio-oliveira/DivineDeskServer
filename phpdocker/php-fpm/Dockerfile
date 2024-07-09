FROM phpdockerio/php:8.3-fpm

# Instale dependências adicionais
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip

WORKDIR /app

CMD ["php-fpm"]