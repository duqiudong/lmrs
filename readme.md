## lmrs课程
### 访问说明
    前端地址：http://localhost:9090/shop/
    后端地址：http://localhost:9090/admin/
    
### 镜像版本说明
    php version： 8.0  
    mysql version: 8.0

### mysql
    mysql : 
        127.0.0.1:33060
        root
        123456
### redis
    redis : 
        127.0.0.1:63790

### 文件讲解
#### conf 
    说明：docker内部配置文件集合

     - local-nginx 配置文件
        - nginx -> conf.d / nginx.conf
        
     - local-php 配置文件
        - php
        - supervisor
        
     - openresty 
        - openresty-conf
    
#### log
    说明：日志, 容器内部记录在/var/log

#### test
    说明：项目代码
     - blog 
       - 自己的项目， 第一二节课会员注册登陆
       - vendor: compose install
       - 数据库结构： 
            命令：php artisan migrate
            注意，这个命令如果在宿主机执行的话，需要将.env文件的DB_HOST临时改成127.0.0.1
       - 数据库数据： 
            php artisan db:seed --class UserSeeder
            注意，这个命令如果在宿主机执行的话，需要将.env文件的DB_HOST临时改成127.0.0.1

     - webserver 
       - 前端代码
            初始化账户名：test
            初始化密码：123456

     - lua 
       - lua配置文件

#### docker-compose.yml
    说明：容器启动文件，
    命令：docker-compose up -d
    修改端口， 是ports参数， 例如80:80， 前面的80是宿主机端口， 后面的端口是容器内部的

#### php.Dockerfile
    说明：php镜像脚本文件
    命令：docker build -f php.Dockerfile -t 新的镜像名称 .



