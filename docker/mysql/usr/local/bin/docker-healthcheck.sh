#!/bin/bash
set -e

if [ -z "$MYSQL_ROOT_PASSWORD" ]; then
    mysql_root_password="$(cat $MYSQL_ROOT_PASSWORD_FILE)"
else
    mysql_root_password="$MYSQL_ROOT_PASSWORD"
fi

mysqladmin ping -h localhost -u root --password=$mysql_root_password
