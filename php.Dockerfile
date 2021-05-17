FROM php:8.0-fpm

MAINTAINER duqiudong

# 设置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 更新安装依赖包和PHP核心拓展
RUN apt-get update && apt-get install -y \
        --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev curl openssh-server supervisor\
        && rm -r /var/lib/apt/lists/* \
        && docker-php-ext-configure gd \
        && docker-php-ext-install -j$(nproc) gd opcache pdo_mysql gettext sockets
    
# 安装 PECL 拓展，安装Redis，swoole
RUN pecl install redis \
    && pecl install swoole \
    && pecl install inotify \
    && docker-php-ext-enable redis swoole inotify


RUN mkdir -p /var/run/sshd
RUN mkdir -p /var/log/supervisor

RUN echo user=root >>  /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord","-n"]
