<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;

class CreateCommand extends IPCommand
{
    public function __construct()
    {
        parent::__construct(
            strtolower(
                basename(__FILE__, "Command.php")
            ),
            [$this, 'handle']);
        $this->setDescription("Register a new IP-Address in the Hetzner Cloud");
    }

    public function handle(GetOpt $getOpt): void
    {
        parent::handle($getOpt);
    }
}