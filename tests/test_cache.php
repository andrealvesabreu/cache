<?php
use Inspire\Cache\Cache;

define('APP_NAME', 'test');
include dirname(__DIR__) . '/vendor/autoload.php';
// Load a single file
echo Inspire\Config\Config::loadFromFile('config/cache.php') . PHP_EOL;

Cache::on('cache4')->set('deco', 'asfsadgasdfdsgsags', 60);
echo Cache::on('cache4')->get('deco') . PHP_EOL;
Cache::on('cache6')->set('deco', '123456', 60);
echo Cache::on('cache6')->get('deco') . PHP_EOL;
Cache::on('array')->set('deco', 'array test', 60);
echo Cache::on('array')->get('deco') . PHP_EOL;

