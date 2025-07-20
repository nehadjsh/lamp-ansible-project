# 🚀 LAMP Ansible Project

## What This Project Does

This Ansible project provisions a basic but working LAMP stack split across two host groups:

- Web layer (webservers) – Installs and configures Apache + PHP, deploys a phpinfo.php test page, and an optional test_db.php script to check database connectivity.

- Database layer (dbservers) – Installs and configures MySQL Server, sets or ensures the root password, applies a minimal config (mysqld.cnf), and ensures the service is enabled.

- You declare which hosts belong to which tier in inventory/hosts, then run one playbook: playbook.yml. Ansible will take care of the rest.

## Project Goals

- Practice Ansible roles structure.

- Show multi-host / multi-group orchestration (Web + DB).

- Demonstrate idempotent server provisioning on Ubuntu.

- Provide simple validation scripts to quickly confirm success.

- Use in DevOps interview discussions as a hands-on demo project.

## Repo Structure
```
A simplified tree (some files omitted for brevity):
lamp-ansible-project/
├── ansible.cfg
├── inventory/
│   └── hosts
├── playbook.yml
└── roles/
    ├── apache/
    ├── php/
    └── mysql/
```
- Each role follows the standard Ansible role layout: tasks/, handlers/, templates/, vars/, defaults/, files/, etc. This keeps things clean and interview-friendly.



## Security Notes

This is a learning project. Before production use:

- Provide strong MySQL root & app passwords (don’t commit secrets).

- Restrict MySQL bind address or use firewall/security groups.

- Replace test scripts (phpinfo.php, test_db.php) – never leave them in production.

- Re-enable SSH host key checking for security (currently disabled in ansible.cfg).

- Consider TLS/HTTPS for Apache.

## Before You Run

Make sure these are in place:
- Ansible installed:
  - Needed to run playbooks
```
pip install ansible or use OS packages.
```

- community.mysql collection:

  - Required for community.mysql.mysql_user module
```
ansible-galaxy collection install community.mysql
```

- Python & pip on control node:
  
  - To install Ansible/collections
    - Usually pre-installed on most DevOps workstations.

- SSH key-based access:

  - Non-interactive automation
    - Confirm ssh web@<ip> & ssh db@<ip> work without password.

- Privilege escalation:

  - Many tasks require root
      - Ensure sudo allowed for web & db users (passwordless recommended or use -K).

- Update variables:

  - Correct docroot, MySQL password, allowed IPs
    -  Edit under each role or override in inventory/group_vars/host_vars.

💡 Tip: For production-style usage, override variables in group_vars/ or host_vars/ instead of editing files inside roles.

## Run the playbook:
- Navigate to the project file:
```
cd ~/lamp-ansible-project
```
- Execute the command

```
ansible-playbook -i inventory/hosts playbook.yml --ask-vault-pass --ask-become-pass
```
![01](https://github.com/user-attachments/assets/eb8a5f2e-f909-464d-b8fa-ff79f6d56080)
![02](https://github.com/user-attachments/assets/c576665e-a7fd-4d7c-b443-f4797ec1eb6f)

## Verifying a Successful Deployment
After running the playbook successfully, you can verify that the services are running and reachable using the following commands:

- Check service status:

These commands display the current status of MySQL and Apache. Look for active (running) to confirm they are running.
```
sudo systemctl status mysql

```
![011](https://github.com/user-attachments/assets/c0c6cc17-aadd-4500-9af8-fa0ab90de8bc)

```
sudo systemctl status apache2
```
![010](https://github.com/user-attachments/assets/cb303306-3039-4b81-b42e-45d64425829f)

- Test server connectivity:

These commands send ICMP requests to the database and web servers. A successful reply means the servers are reachable.


```
ping <dbserver-ip>

```
![06](https://github.com/user-attachments/assets/e837c60c-a037-45f5-a050-78d50b2a77ca)

```
ping <webserver-ip>
```
![05](https://github.com/user-attachments/assets/488f89ee-3af8-4c31-aebb-b044de3be4da)

- Test open ports:

These commands check if the MySQL (port 3306) and Apache (port 80) ports are open and accepting connections.

```
nc -zv <dbserver-ip> 3306

```
![08](https://github.com/user-attachments/assets/fabbf23d-d2ed-42e8-93ad-1bfa12e2a35a)

```
nc -zv <webserver-ip> 80
```
![09](https://github.com/user-attachments/assets/48e82e1e-e2ae-4f05-b001-89100b9b9a09)

- HTTP Response From Web Server:
```
 http://<webserver_ip>/
```
![07](https://github.com/user-attachments/assets/a86beb4a-ead9-45de-8303-ccf26994b648)

## Good luck!
