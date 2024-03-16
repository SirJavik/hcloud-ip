<?php

namespace Javik\hcloudip;

use GetOpt\Operand;

class ServerCommand extends HcloudCommand
{
    public function __construct(string $name, mixed $handler, mixed $options = null)
    {
        parent::__construct($name, $handler, $options);

        $this->addOperands([
            Operand::create('ip', Operand::REQUIRED)->setDescription("Name of IP-Address to work with"),
            Operand::create('server', Operand::REQUIRED)->setDescription("Name of server to work with")
        ]);

    }
}