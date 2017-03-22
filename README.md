## 项目说明

[格吾社区](https://growu.me)网站项目，基于[Laravel 5.4](https://www.laravel.com)创建。

## 安装使用

### 1、clone代码到本地

`git clone https://github.com/growu/growu-website.git`

### 1、安装composer组件

`composer install`

### 2、安装npm包

`npm install`

### 3、修改env配置

`cp .env.example .env`

### 4、生成key

`php artisan generage:key`

### 4、修改文件夹权限

`chmod -R 777 storage`
`chmod -R 777 boosboostraptrap/cache`

### 5、执行数据库操作

`php artisan migrate`


