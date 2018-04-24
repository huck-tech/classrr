<?php

namespace App;

use Carbon\Carbon;

trait PrettyDateTrait
{
    protected static $pretty_date_format_php;

    public static function bootPrettyDateTrait()
    {
        self::$pretty_date_format_php = config('app.dateformat_php') ?: 'M j, Y';

        static::saving(function($item) {
            $attributes = $item->getAttributes();
            $pretty_dates = $item->getPrettyDates();
            if ($pretty_dates) {
                foreach($pretty_dates as $pretty_date_field) {
                    if (isset($attributes[$pretty_date_field])) {
                        if (empty($attributes[$pretty_date_field])) {
                            $item[$pretty_date_field] = null;
                        } else {
                            try {
                                $item[$pretty_date_field] = Carbon::createFromFormat(
                                    self::$pretty_date_format_php,
                                    $attributes[$pretty_date_field])->toDateString();
                            } catch (\Exception $e) {
                                // If date wasn't transformed leave it as is.
                            }
                        }
                    }
                }
            }
            //var_dump($item); die();

        });
    }

    public function getPrettyDates()
    {
        if (isset($this->pretty_dates) && is_array($this->pretty_dates)) {
            return $this->pretty_dates;
        } else {
            return null;
        }
    }

    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }
        if (isset($this->pretty_dates) &&
            in_array($key, $this->pretty_dates) &&
            isset($this->attributes[$key]) &&
            !empty($this->attributes[$key])) {

            return Carbon::createFromFormat('Y-m-d', $this->attributes[$key])->format(self::$pretty_date_format_php );
        }
        return parent::getAttribute($key);
    }
}