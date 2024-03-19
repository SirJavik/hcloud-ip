<?php

namespace Javik\hcloudip;

use GetOpt\Operand;
use Javik\hcloudip\Validator\isStringOrID;

class ServerCommand extends IPCommand
{
    public function __construct(string $name, mixed $handler, mixed $options = null)
    {
        parent::__construct($name, $handler, $options);

        $this->addOperands([
            Operand::create('server_nameOrId', Operand::REQUIRED)
                ->setDescription("Name of server to work with")
                ->setValidation(function ($value) {
                    return new isStringOrID($value);
                }, 'server_nameOrId needs to be string or int'),
        ]);

    }
}