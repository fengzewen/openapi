# 开源API封装

## 安装vendor publish

```php
 composer require laravelista/lumen-vendor-publish:7.x
 app\Console\Kernel.php 中加入 VendorPublishCommand::class
```

## 安装hgs/openapi

```php
 composer require hgs/openapi dev-master
 bootstrap/app.php中注册提供者$app->register(Hgs\Openapi\OpenapiServiceProvider::class);
 php artisan vendor:publish
 php artisan migrate

```

## 使用

```php
    $orderApiGateway = BusinessApiGatewayFactory::getTiktokBusinessApiGateway(Order::class, env("TIKTOK_STORE_APP_KEY"), env("TIKTOK_STORE_APP_SECRET"), 1);
    $data = $orderApiGateway->orderList();
```
