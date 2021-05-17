## lmrs课程
### 访问说明
    前端地址：http://localhost:9090/shop/
    后端地址：http://localhost:9090/admin/
    
### 镜像说明
    php version： 8.0  
    mysql version: 8.0

### 文件讲解
#### conf 
    说明：docker内部配置文件集合

     - local-nginx 配置文件
        - nginx -> conf.d / nginx.conf
        
     - local-php 配置文件
        - php
        - supervisor
        
     - openresty 
        - nginx -> openresty-conf
    
#### log
    说明：日志, 容器内部记录在/var/log

#### test
    说明：项目代码
     - blog 
       - 自己的项目， 第一二节课会员注册登陆
     - lmrs-2008 
       - 老师的api
     - webserver 
       - 老师的前端代码
     - lua 
       - lua配置文件

#### docker-compose.yml
    说明：容器启动文件，
    命令：docker-compose up -d

#### php.Dockerfile
    说明：php镜像脚本文件
    命令：docker build -f php.Dockerfile -t 新的镜像名称 .



