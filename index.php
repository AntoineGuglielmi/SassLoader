<?php

use SL\SassLoader;

require_once 'vendor/autoload.php';

$sassLoader = new SassLoader('public/sass');
$sassLoader->set_drop_point('main.sass')->load();

echo '<link rel="stylesheet" href="/public/css/main.css">';
echo '<p>Hello</p>';