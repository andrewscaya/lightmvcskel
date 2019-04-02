<?php

$baseConfig['session'] = [
    'psr6_cache' => \Ascmvc\Cache\DoctrineCacheItemPool::class,
    'doctrine_cache_driver' => \Doctrine\Common\Cache\FilesystemCache::class,
    'doctrine_cache_params' => BASEDIR . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR,
    'session_name' => 'PHPSESSION',
    'session_path' => '/',
    'session_id_length' => 32,
    'session_id_type' => 1,
    'session_storage_prefix' => 'ascmvc',
    'session_expire' => 60 * 30, // 30 minutes
];