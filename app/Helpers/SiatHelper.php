<?php

if (!function_exists('siat_config')) {
    function siat_config($key = null)
    {
        $config = \App\Models\ConfiguracionSiat::getConfig();

        if ($key) {
            return data_get($config, $key);
        }

        return $config;
    }
}