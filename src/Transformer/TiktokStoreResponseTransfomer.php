<?php


namespace Hgs\Openapi\Transformer;


class TiktokStoreResponseTransfomer implements Transformer
{

    public function transform($responseBody)
    {
        $data = json_decode($responseBody, true);
        if ($data['err_no']) {
            throw new \Exception($data['message']);
        }
        return $data['data'];
    }
}
