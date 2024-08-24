#!/usr/bin/env python3
######################################
#           _             _ _        #
#          | |           (_) |       #
#          | | __ ___   ___| | __    #
#      _   | |/ _` \ \ / / | |/ /    #
#     | |__| | (_| |\ V /| |   <     #
#      \____/ \__,_| \_/ |_|_|\_\    #
#                                    #
######################################

# Filename: hcloud-ip.py
# Description:
# Version: 1.0.0
# Author: Benjamin Schneider <ich@benjamin-schneider.com>
# Date: 2024-07-26
# Last Modified: 2024-07-26
# Changelog:
# 1.0.0 (2024-07-26): Initial version

import argparse
import os
import sys
import argparse
from src import HcloudIp

VERSION_MAJOR: int = 1
VERSION_MINOR: int = 0
VERSION_PATCH: int = 0

AUTHOR_NAME: str = "Benjamin Schneider"
AUTHOR_EMAIL: str = "ich@benjamin-schneider.com"

try:
    import tomllib
except ImportError:
    print("[ERROR] hcloud-ip: Please migrate to Python 3.11 or higher.")
    # Output python version
    print("You are using Python " + sys.version)
    print("hcloud-ip v" + str(VERSION_MAJOR) + "." +
          str(VERSION_MINOR) + "." + str(VERSION_PATCH))
    print("Written by " + AUTHOR_NAME + " <" + AUTHOR_EMAIL + ">")
    sys.exit(1)


def output_version():
    print("hcloud-ip v" + str(VERSION_MAJOR) + "." +
          str(VERSION_MINOR) + "." + str(VERSION_PATCH))
    print("Written by " + AUTHOR_NAME + " <" + AUTHOR_EMAIL + ">")


# Press the green button in the gutter to run the script.
if __name__ == '__main__':
    config_files: list = [
        "/etc/hcloud-ip.toml",
        "~/.config/hcloud-ip.toml",
        "~/.hcloud-ip.toml",
        "./hcloud-ip.toml"
    ]
    config = None

    arg_parser = argparse.ArgumentParser(prog="hcloud-ip", usage="%(prog)s [options]", description="hcloud-ip: A simple tool to manage Hetzner Cloud IPs.", epilog="hcloud-ip v" + str(
        VERSION_MAJOR) + "." + str(VERSION_MINOR) + "." + str(VERSION_PATCH) + " - Written by " + AUTHOR_NAME + " <" + AUTHOR_EMAIL + ">")
    arg_parser.add_argument(
        "-v", "--version", action="store_true", help="Show version information.")
    arg_parser.add_argument("-t", "--token", action="store",
                            type=str, help="Specify the Hetzner Cloud API token.")
    arg_parser.add_argument("-c", "--config", action="store",
                            type=str, help="Specify a custom config file.")
    arg_parser.add_argument("--list-floating-ips",
                            action="store_true", help="List all available IPs.")
    arg_parser.add_argument("--list-servers", action="store_true", help="List all available servers.")
    arg_parser.add_argument("-a", "--assign", action="store",
                            type=str,  help="Assign a new IP to a server.")
    arg_parser.add_argument("-r", "--unassign", action="store",
                            type=str,  help="Unassign an IP from a server.")
    arg_parser.add_argument("-s", "--server", action="store", type=str,
                            help="Specify the server to assign or remove the IP from.")
    args = arg_parser.parse_args()

    if args.version:
        output_version()
        sys.exit(0)

    if len(sys.argv) <= 1:
        arg_parser.print_help()
        sys.exit(0)

    # Stop at first existing config file
    for file in config_files:
        try:
            with open(file, 'rb') as cfile:
                print("[INFO] hcloud-ip: Found config file: " + file)
                config = tomllib.load(cfile)
                break
        except FileNotFoundError:
            continue

    if config is None:
        print("[ERROR] hcloud-ip: No config file found.")
        exit(1)

    hcloud_ip = HcloudIp.HcloudIp(
        args.token if args.token else config["app"]["token"]
    )

    if args.assign:
        hcloud_ip.assign_ip(args.assign, args.server)
        sys.exit(0)

    if args.unassign:
        hcloud_ip.unassign_ip(args.unassign)
        sys.exit(0)

    if args.list_floating_ips:
        print(hcloud_ip.list_floating_ips())
        sys.exit(0)

    if args.list_servers:
        print(hcloud_ip.list_servers())
        sys.exit(0)
