<?php

namespace Javik\hcloudip;

use GetOpt\GetOpt;
use GetOpt\Option;
use Javik\hcloudip\Validator\isStringOrID;
use LKDev\HetznerCloud\Models\Locations\Location;
use LKDev\HetznerCloud\Models\Servers\Server;

class CreateCommand extends IPCommand
{
    private string $ipName;
    private string $type;
    private string $ipDescription;
    private Location $location;
    private Server $server;
    private array $labels;

    public function getIpName(): string
    {
        return $this->ipName;
    }

    public function setIpName(string $ipName): void
    {
        $this->ipName = $ipName;
    }

    public function getIpDescription(): string|null
    {
        return $this->ipDescription;
    }

    public function setIpDescription(string|null $ipDescription): void
    {
        $this->ipDescription = $ipDescription;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function setServer(Server $server): void
    {
        $this->server = $server;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }

    public function __construct()
    {
        parent::__construct(
            strtolower(
                basename(__FILE__, "Command.php")
            ),
            [$this, 'handle']);
        $this->setDescription("Register a new IP-Address in the Hetzner Cloud");

        $this->addOptions([
            Option::create('d', 'description', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Show this help and quit'),

            Option::create('t', 'type', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Floating IP type')
                ->setValidation(function ($value) {
                    return strtolower($value) == 'ipv4' or strtolower($value) == 'ipv6';
                }, 'Type has to be ipv4 or ipv6'),

            Option::create('l', 'location', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Hetzner location')
                ->setValidation(function ($value) {
                    //return !is_null($this->getHetznerAPIClient()->locations()->get($value));
                    return true;
                }, 'Location has to be fsn1, nbg1, hel1, ash or hil'),

            Option::create('s', 'server', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Hetzner server')
                ->setValidation(function ($value) {
                    return new isStringOrID($value);
                }, 'Server has to be a name or a id'),

            Option::create('L', 'labels', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Labels for floating ip')
                ->setValidation(function ($value) {
                    return is_string($value);
                }, 'Labels have to be strings'),
        ]);
    }

    public function handle(GetOpt $getOpt): void
    {
        parent::handle($getOpt);

        $this->setType(
            $getOpt->getOption('type')
        );

        $this->setIpDescription(
            $this->getOption('description') ?? null
        );

        $this->setLocation(
            $this->getHetznerAPIClient()->locations()->get(
                $getOpt->getOption('location')
            )
        );

        $this->setServer(
            $this->getHetznerAPIClient()->servers()->get(
                $getOpt->getOption('server')
            )
        );

        $this->setIpName(
            $getOpt->getOperand(0)
        );

        $this->getHetznerAPIClient()->floatingIps()->create($this->getType(), $this->getIpDescription(), $this->getLocation(), $this->getServer(), $this->getIpName());
    }
}