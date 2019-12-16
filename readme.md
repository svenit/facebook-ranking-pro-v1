# Facebook Group Ranking

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Hệ thống bảng xếp hạng tương tác thành viên trong nhóm ( Facebook Group Ranking System )

### Công Nghệ


* HTML
* CSS
* JavaScript
* Laravel
* VueJS
* Facebook API


### Cài Đặt

Yêu cầu : PHP >= 7.x & Composer

```sh
$ git clone https://github.com/Juniorsz/facebook-ranking-pro-v1.git
$ cd facebook-ranking-pro-v1
$ cp .env.example .env
```

Vào .env và cấu hình lại url, tên miền, database, pusher : 

[Pusher](https://pusher.com/)

```sh
$ composer update
$ composer dump-autoload
$ php artisan key:generate
$ php artisan optimize:clear
$ php artisan migrate
$ php artisan db:seed
```

### Nhà Phát Triển

- **Lê Quang Vỹ**

### Gặp Vấn Đề ?
 
 Vui lòng liên hệ Facebook [Lê Quang Vỹ](https://facebook.com/sven307) để được hỗ trợ

BẢN QUYỀN
----

MIT


**Facebook Group Ranking System v1.0.0**

