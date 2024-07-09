# Use a imagem base do PHP com FPM
FROM php:8.3-fpm

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Instale Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do projeto para o contêiner
COPY src/ .

# Instale as dependências do Laravel
RUN composer install --no-scripts --no-autoloader

# Gere o autoload
RUN composer dump-autoload --optimize

# Defina as permissões corretas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponha a porta 9000 e rode o PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
