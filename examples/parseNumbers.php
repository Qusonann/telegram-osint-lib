<?php

use Client\InfoObtainingClient\Models\UserInfoModel;
use Logger\Logger;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/MyTgClientDebug.php';

// here we get contact list and get contact online status
// avatars are saved to current directory

if (!isset($argv[1])) {
    echo "please specify numbers (comma-separated): 79061231231,79061231232\n";
    exit(1);
}

$numbers = explode(',', $argv[1]);

$client = new MyTgClientDebug();
/** @noinspection PhpUnhandledExceptionInspection */
$client->infoLogin();
/** @noinspection PhpUnhandledExceptionInspection */
$client->parseNumbers($numbers, false, false, function(array $models) {
    foreach ($models as $model) {
        /** @var UserInfoModel $model */
        Logger::log('ParseNumbers', print_r($model, true));
    }
});
/** @noinspection PhpUnhandledExceptionInspection */
$client->pollAndTerminate();
