import re
from hcloud import Client
from hcloud.images import Image
from hcloud.server_types import ServerType


class HcloudIp:

    _token: str = ""
    _client: any = None

    def set_token(self, token: str):
        if len(token) == 0:
            raise ValueError("Token must not be empty.")

        self._token = token

    def get_token(self) -> str:
        return self._token

    def set_client(self, client: object):
        self._client = client

    def get_client(self) -> any:
        return self._client

    def list_floating_ips(self):
        print("Server - ID - Name - IP - Type - Home Location - Created")
        for ip in self.get_client().floating_ips.get_all():
            server_name = ip.server.name if ip.server is not None else "None"
            print(f"{server_name} - {ip.id} - {ip.name} - {ip.ip} - {ip.type} - {ip.home_location.name} - {ip.created}")
        print("End of list.")

    def list_servers(self):
        print("ID - Name - Status - Public Net - Private Net - Datacenter - Created")
        for server in self.get_client().servers.get_all():
            print(f"{server.id} - {server.name} - {server.status} - {server.public_net.ipv4.ip} - {server.private_net[0].ip} - {server.datacenter.name} - {server.created}")
        print("End of list.")

    def assign_ip(self, ip_regex: str, server_regex: str):
        server: any = None
        ip: any = None

        # Search for server
        for server in self.get_client().servers.get_all():
            if re.search(server_regex, server.name) or server_regex == server.id:
                server = server
                break

        if server is None:
            print(f"Server {server_regex} not found.")
            return False

        print(f"Server {server.name}, {server.id} found.")

        # Search for IP
        for ip in self.get_client().floating_ips.get_all():
            if re.search(ip_regex, ip.ip) or ip_regex == ip.id or re.search(ip_regex, ip.name):
                ip = ip
                break
        print(f"Floating IP {ip.ip}, {ip.name}, {ip.id} found.")

        # Check if IP is already assigned to server
        if ip.server.name == server.name:
            print(f"IP {ip.ip} is already assigned to {server.name}.")
            return False

        # Assign IP to server
        ip.assign(server)
        print(f"IP {ip.ip} assigned to {server.name}.")
        return True

    def unassign_ip(self, ip: str):
        ip = self.get_client().floating_ips.get_by_id(ip)
        ip.unassign()

    def __init__(self, token):
        self.set_token(token)
        self.set_client(Client(token=self.get_token()))
