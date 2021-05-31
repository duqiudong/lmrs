<h1>数据库</h1>

```
cp env.example .env
```
.env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=33060
DB_DATABASE=lmrs_2008_shops
DB_USERNAME=root
DB_PASSWORD=123456
DB_PREFIX=lmrs_
```

手动新建数据库： lmrs_2008_shops

表结构迁移
```
php artisan migrate
```

初始化数据
```
php artisan db:seed --class=UserSeeder //user账户密码：test  123456
php artisan db:seed --class=ProductCategorySeeder
```

