#!/usr/bin/env php
<?php

//TODO: Redefine the base path.
require_once __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Phinx\Console\PhinxApplication;

$conf = [
    '--configuration',
    __DIR__ . '/../Config/Phinx.php'
];

$args = $_SERVER['argv'];
$args = array_merge($args, $conf);

$phinxApp = new PhinxApplication();
$phinxApp->setAutoExit(false);

$exitCode = $phinxApp->run(new ArgvInput($args), new ConsoleOutput());
exit($exitCode);
