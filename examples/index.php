<?php

use Yigit\Linguist;

require __DIR__ . '/vendor/autoload.php';

$linguist = new Linguist('/Users/yigit/Documents/JotForm/sheets');
$linguist->excludeContains([
    'node_modules',
    'git/objects',
    'git/logs',
    'git/hooks',
    'git/refs',
    'git/ORIG_HEAD',
    'git/config',
    'git/HEAD',
    'git/info/exclude',
    'git/info/refs',
    'git/fork-settings',
    'git/description',
    'git/index',
    'git/packed-refs',
    'git/COMMIT_EDITMSG',
    'git/FETCH_HEAD',
]);

$languages = $linguist->find();
