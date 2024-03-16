<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;

final class UnassignCommand extends ServerCommand
{
    public function __construct()
    {
        parent::__construct(
            strtolower(
                basename(__FILE__, "Command.php")
            ),
            [$this, 'handle']);
        $this->setDescription("Unassign IP-Address from server");
    }

    public function handle(GetOpt $getOpt): void
    {
        parent::handle($getOpt);
    }
}