<?php

namespace App;

trait NullableTrait
{
    public static function bootNullableTrait()
    {
        static::saving(function($item) {
            $attributes = $item->getAttributes();
            $nullable = $item->getNullable();
            if ($nullable) {
                foreach($nullable as $nullable_field) {
                    if (isset($attributes[$nullable_field])) {
                        if ($attributes[$nullable_field] === '') {
                            $item[$nullable_field] = null;
                        }
                    }
                }
            }
        });
    }

    public function getNullable()
    {
        if (isset($this->nullable) && is_array($this->nullable)) {
            return $this->nullable;
        } else {
            return null;
        }
    }
    

}