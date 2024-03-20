<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;
use LKDev\HetznerCloud\APIException;

class DeleteCommand extends IPCommand
{
    public function __construct()
    {
        parent::__construct(
            strtolower(
                basename(__FILE__, "Command.php")
            ),
            [$this, 'handle']
        );
        $this->setDescription("Remove a registered IP-Address from the Hetzner Cloud");
    }

    public function handle(GetOpt $getOpt): void
    {
        parent::handle($getOpt);

        try {
            $this->getHetznerAPIClient()->floatingIps()->get($getOpt->getOperand(0))->delete();
        } catch (\Exception $e) {
            print $e->getMessage() . PHP_EOL;
            die(2);
        }
    }
}