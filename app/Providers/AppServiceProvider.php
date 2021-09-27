<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //记录sql到日志
        \DB::listen(function($query){
            $sql=$this->getQuerySql($query);
            \Log::channel('sqllog')->info($sql.'---'.$query->time);
        });

        Validator::extend('greater_than_field',function($attribute,$value,$parameters,$validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
        });

        Validator::replacer('greater_than_field',function($message,$attribute,$rule,$parameters) {
            return str_replace(':field',$parameters[0],$message);
        });
    }

    /**
     * 获取执行sql
     * @param $query
     * @return mixed|string
     * @author Zhujiaqi&huanWang
     * @time 2020-10-30 18:02:14
     */
    public function getQuerySql($query)
    {
        if (empty($query->bindings)) {
            $sql = str_replace("?", "'%s'", $query->sql);
            return $sql;
        }

        array_walk($query->bindings, function (&$value) {
            if (is_string($value)) {
                $value = "'" . $value . "'";
            }
        });

        $sql = str_replace("?", "%s", $query->sql);
        return vsprintf($sql, $query->bindings);
    }
}
