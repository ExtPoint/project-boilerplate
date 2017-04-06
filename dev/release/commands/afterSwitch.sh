#!/bin/bash
# This script running after switch `current` folder to new build

RUNTIME_DIR="$(dirname $(readlink -f $0))"
PROJECT_DIR="$(dirname $(readlink -f ${RUNTIME_DIR}/../../..))"

# Configuration
PROJECT_ENVIRONMENT="$(cat ${PROJECT_DIR}/config/project_environment)"
HOSTNAME="$(cat ${PROJECT_DIR}/config/hostname)"

echo "Restart php..."
if [[ ${HOSTNAME} =~ preview ]] || [[ ${PROJECT_ENVIRONMENT} =~ preview|stage ]]; then
	service php7.1-fpm restart
fi

exit 0