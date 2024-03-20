[[_TOC_]]
## Requirements

* PHP >= 8.0
* composer
* php-mbstring

## How to build

```bash
composer update
./vendor/bin/phing -f build.xml
sudo ./vendor/bin/phing -f build.xml install # Optional
```

## HCLOUD TOKEN
Can be set either via --api-token or environment variable HCLOUD_TOKEN

## Commandline Options

```text
Usage: /usr/local/bin/hcloud-ip <command> [options] [operands]

Options:
  -v, --version      Show version information and quit
  -h, --help         Show this help and quit
  --api-token <arg>  Hetzner API token

Commands:
  assign    Assign IP-Address to server
  unassign  Unassign IP-Address from server
  create    Register a new IP-Address in the Hetzner Cloud
  delete    Remove a registered IP-Address from the Hetzner Cloud
```

## Examples
### Assign IP-Address

```bash
hcloud-ip assign myip myserver
```

### Create IP-Address
```bash
hcloud-ip create --type ipv4 \
  --location fsn1 \
  --description "My IP" \
  --labels "mylabel=iscool" \
  myip
```

```text
Usage: /usr/local/bin/hcloud-ip create [options] <ip_nameOrId> [operands]

Register a new IP-Address in the Hetzner Cloud

Operands:
  <ip_nameOrId>  Name of IP-Address to work with

Options:
  -v, --version            Show version information and quit
  -h, --help               Show this help and quit
  --api-token <arg>        Hetzner API token
  -d, --description <arg>  Show this help and quit
  -t, --type <arg>         Floating IP type
  -l, --location <arg>     Hetzner location
  -s, --server <arg>       Hetzner server
  -L, --labels <arg>       Labels for floating ip
```
