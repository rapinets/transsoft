<?php

namespace Traits;

trait Filter
{

    public function productFilter()
    {
        $this->productValidate = [
            'sku' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,

            ],
            'name' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,

            ],
            'price' => [

                'filter' => FILTER_SANITIZE_NUMBER_FLOAT
            ],
            'qty' => [

                'filter' => FILTER_SANITIZE_NUMBER_FLOAT
            ],
            'description' => [
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,

            ]
        ];

        return $this;
    }


}