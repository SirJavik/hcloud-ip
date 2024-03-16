<?php

namespace Javik\hcloudip;

use GetOpt\Operand;

class IPCommand extends HcloudCommand
{
    public function __construct(string $name, mixed $handler, mixed $options = null)
    {
        parent::__construct($name, $handler, $options);

        $this->addOperands([
            Operand::create('ip', Operand::REQUIRED)->setDescription("Name of IP-Address to work with")
        ]);

    }
}