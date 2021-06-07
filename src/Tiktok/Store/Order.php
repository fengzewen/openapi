<?php


namespace Hgs\Openapi\Tiktok\Store;


class Order extends TiktokStoreApiGateway
{
    //只能获取2021-04开始的数据
    public function orderList()
    {
        $params = [
            'create_time_start' => 1617264922,
            'size' => 1,
            'page' => 0
        ];

        return $this->requestBusinessApi('order/searchList', $params);
    }

    public function detail($orderId)
    {
        $params = [
            'order_id' => $orderId
        ];
        return $this->requestBusinessApi('order/detail', $params);
    }
}
