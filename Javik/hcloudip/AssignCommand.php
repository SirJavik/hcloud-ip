<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;
use GetOpt\Operand;

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
        var_dump($getOpt->getOperands());
    }
}