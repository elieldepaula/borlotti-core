#!/usr/bin/env php
<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

define('BASE_PATH', __DIR__ . '/../../../../../');

require_once BASE_PATH . 'vendor/autoload.php';

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
