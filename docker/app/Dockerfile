# Sử dụng image PHP FPM với version 8.2
FROM php:8.2-fpm

# Set thư mục làm việc là /var/www
WORKDIR /var/www/html

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libxml2-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql exif bcmath opcache


# Copy toàn bộ mã nguồn vào container
COPY . .

# Tạo các thư mục storage và cache nếu chưa tồn tại
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Thiết lập quyền cho thư mục storage và cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose cổng 9000 cho PHP FPM
EXPOSE 9000

# Chạy PHP-FPM
CMD ["php-fpm"]
