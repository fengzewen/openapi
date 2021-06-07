<?php


namespace Hgs\Openapi\Transformer;


interface Transformer
{
    public function transform($responseBody);
}
