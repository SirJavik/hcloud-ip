<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;
use LKDev\HetznerCloud\APIException;

final class AssignCommand extends ServerCommand
{
    public function __construct()
    {
        parent::__construct(
            strtolower(
                basename(__FILE__, "Command.php")
            ),
            [$this, 'handle']);
        $this->setDescription("Assign IP-Address to server");

    }

    public function handle(GetOpt $getOpt): void
    {
        parent::handle($getOpt);

        $floatingIP = $this->getHetznerAPIClient()->floatingIps()->get($getOpt->getOperand(0));
        if (is_null($floatingIP)) {
            print("FloatingIP " . $getOpt->getOperand(0) . " is not valid!" . PHP_EOL);
            die(2);
        }

        $server = $this->getHetznerAPIClient()->servers()->get($getOpt->getOperand(1));
        if (is_null($server)) {
            print("Server " . $getOpt->getOperand(1) . " is not valid!" . PHP_EOL);
            die(2);
        }

        try {
            $apiResponse = $floatingIP->assignTo($server);

            $action = $apiResponse->getResponsePart('action');
            $action->waitUntilCompleted();
        } catch (APIException $e) {
            print $e->getMessage() . PHP_EOL;
        }
    }
}