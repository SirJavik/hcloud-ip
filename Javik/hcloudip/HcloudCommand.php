<?php

namespace Javik\hcloudip;

use GetOpt\Command;
use GetOpt\GetOpt;
use LKDev\HetznerCloud\HetznerAPIClient;

class HcloudCommand extends Command
{
    private HetznerAPIClient $hetznerAPIClient;
    private string $apiKey;

    public function getHetznerAPIClient(): HetznerAPIClient
    {
        return $this->hetznerAPIClient;
    }

    public function setHetznerAPIClient(HetznerAPIClient $hetznerAPIClient): void
    {
        $this->hetznerAPIClient = $hetznerAPIClient;
    }

    public function handle(GetOpt $getOpt): void
    {
        var_dump($this->getOptions());

        $this->setApiKey(
            $getOpt->getOption('api-token')
        );

        $this->setHetznerAPIClient(
            new HetznerAPIClient(
                $this->getApiKey()
            )
        );
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}