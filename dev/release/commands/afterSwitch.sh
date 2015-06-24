#!/bin/bash
# This script running after switch `current` folder to new build

RUNTIME_DIR="$(dirname $(readlink -f $0))"
PROJECT_DIR="$(dirname $(readlink -f ${RUNTIME_DIR}/../../..))"

# Configuration
PROJECT_ENVIRONMENT="$(cat ${PROJECT_DIR}/config/project_environment)"
HOSTNAME="$(cat ${PROJECT_DIR}/config/hostname)"



exit 0