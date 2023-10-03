#!/bin/bash

# Restart OpenVPN
systemctl restart openvpn
if [[ $? -ne 0 ]]; then
    echo "Failed to restart OpenVPN"
    exit 1
fi

# Restart FreeRADIUS
systemctl restart freeradius
if [[ $? -ne 0 ]]; then
    echo "Failed to restart FreeRADIUS"
    exit 1
fi

# Restart Supervisor Services
supervisorctl stop all
if [[ $? -ne 0 ]]; then
    echo "Failed to stop all Supervisor services"
    exit 1
fi

supervisorctl reread
if [[ $? -ne 0 ]]; then
    echo "Failed to reread Supervisor configuration"
    exit 1
fi

supervisorctl update
if [[ $? -ne 0 ]]; then
    echo "Failed to update Supervisor services"
    exit 1
fi

supervisorctl start all
if [[ $? -ne 0 ]]; then
    echo "Failed to start all Supervisor services"
    exit 1
fi

echo "Services restarted successfully"
