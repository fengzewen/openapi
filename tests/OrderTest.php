<?php

namespace tiktok;

use App\OpenApi\Factory\BusinessApiGatewayFactory;
use App\OpenApi\Tiktok\Store\Order;

class OrderTest extends \TestCase
{
    public function testOrderList()
    {
        $orderApiGateway = BusinessApiGatewayFactory::getTiktokBusinessApiGateway(Order::class, env("TIKTOK_STORE_APP_KEY"), env("TIKTOK_STORE_APP_SECRET"), 1);
        $data = $orderApiGateway->orderList();
        var_dump($data);
    }

    public function testOrderDetail()
    {
        $orderApiGateway = BusinessApiGatewayFactory::getTiktokBusinessApiGateway(Order::class, env("TIKTOK_STORE_APP_KEY"), env("TIKTOK_STORE_APP_SECRET"), 1);
        $data = $orderApiGateway->detail('4804807930112619658A');
        var_dump($data);
    }
}
