FROM php:8.1-fpm

# Cài đặt các extension PHP cần thiết
RUN RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Sao chép các tệp tin và thư mục từ thư mục dự án vào thư mục làm việc
COPY . /var/www/html

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt các gói PHP dependencies
RUN composer install

# Thiết lập quyền truy cập cho thư mục storage và bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap
