<?php

$targetFolder = $_SERVER['APPROOT'] . '/storage';
$linkFolder = $_SERVER['APPROOT'] . '/public/storage';

symlink($targetFolder, $linkFolder);
