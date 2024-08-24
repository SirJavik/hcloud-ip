# hcloud-ip
A simple tool to manage Hetzner Cloud IPs.

## Installation
```bash
git clone https://gitlab.com/Javik/hcloud-ip.git
cd hcloud-ip
make
```

## Usage
```bash
usage: hcloud-ip [options]

hcloud-ip: A simple tool to manage Hetzner Cloud IPs.

options:
  -h, --help            show this help message and exit
  -v, --version         Show version information.
  -t TOKEN, --token TOKEN
                        Specify the Hetzner Cloud API token.
  -c CONFIG, --config CONFIG
                        Specify a custom config file.
  --list-floating-ips   List all available IPs.
  --list-servers        List all available servers.
  -a ASSIGN, --assign ASSIGN
                        Assign a new IP to a server.
  -r UNASSIGN, --unassign UNASSIGN
                        Unassign an IP from a server.
  -s SERVER, --server SERVER
                        Specify the server to assign or remove the IP from.

hcloud-ip v1.0.0 - Written by Benjamin Schneider <ich@benjamin-schneider.com>
```

## Configuration
The configuration file is located at `/etc/hcloud-ip.toml` or `~/.config/hcloud-ip.toml` or `~/.hcloud-ip.toml` or `./hcloud-ip.toml` and looks like this:
``` 
######################################
#           _             _ _        #
#          | |           (_) |       #
#          | | __ ___   ___| | __    #
#      _   | |/ _` \ \ / / | |/ /    #
#     | |__| | (_| |\ V /| |   <     #
#      \____/ \__,_| \_/ |_|_|\_\    #
#                                    #
######################################

[app]
token="YOUR_TOKEN"
```

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

