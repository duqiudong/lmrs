FROM nginx

MAINTAINER duqiudong

# 设置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y vim wget curl procps telnet inetutils-ping net-tools