<?php

namespace Javik\hcloudip;

use GetOpt\Operand;
use Javik\hcloudip\Validator\isStringOrID;

class IPCommand extends HcloudCommand
{
    public function __construct(string $name, mixed $handler, mixed $options = null)
    {
        parent::__construct($name, $handler, $options);

        $this->addOperands([
            Operand::create('ip_nameOrId', Operand::REQUIRED)
                ->setDescription("Name of IP-Address to work with")
                ->setValidation(function ($value) {
                    return new isStringOrID($value);
                }, 'ip_nameOrId needs to be string or int'),
        ]);

    }
}