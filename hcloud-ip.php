<?php

namespace Javik\hcloudip;

use GetOpt\ArgumentException;
use GetOpt\ArgumentException\Missing;
use GetOpt\GetOpt;
use GetOpt\Option;

require_once __DIR__ . '/vendor/autoload.php';

define('NAME', basename(__FILE__));
define('VERSION', NAME . '1.0-alpha');

$getOpt = new GetOpt();

// define common options
$getOpt->addOptions([

    Option::create('v', 'version', GetOpt::NO_ARGUMENT)
        ->setDescription('Show version information and quit'),

    Option::create('h', 'help', GetOpt::NO_ARGUMENT)
        ->setDescription('Show this help and quit'),

    Option::create(null, 'api-token', GetOpt::REQUIRED_ARGUMENT)
        ->setDescription('Hetzner API token'),

]);

// add commands
$getOpt->addCommand(new AssignCommand());
$getOpt->addCommand(new UnassignCommand());
$getOpt->addCommand(new CreateCommand());
$getOpt->addCommand(new DeleteCommand());

// process arguments and catch user errors
try {
    try {
        $getOpt->process();
    } catch (Missing $exception) {
        // catch missing exceptions if help is requested
        if (!$getOpt->getOption('help')) {
            throw $exception;
        }
    }
} catch (ArgumentException $exception) {
    file_put_contents('php://stderr', $exception->getMessage() . PHP_EOL);
    echo PHP_EOL . $getOpt->getHelpText();
    exit;
}

// show version and quit
if ($getOpt->getOption('version')) {
    echo sprintf('%s: %s' . PHP_EOL, NAME, VERSION);
    exit;
}

// show help and quit
$command = $getOpt->getCommand();
if (!$command || $getOpt->getOption('help')) {
    echo $getOpt->getHelpText();
    exit;
}

// call the requested command
call_user_func($command->getHandler(), $getOpt);
