#!/bin/bash
#

RUNTIME_DIR="$(dirname $(readlink -f $0))"
SOURCE_DIR="$(dirname $(readlink -f $RUNTIME_DIR/../..))"
PROJECT_DIR="$(dirname $(readlink -f $SOURCE_DIR))"

# Configuration
PROJECT_ENVIRONMENT="$(cat ${PROJECT_DIR}/config/project_environment)"
HOSTNAME="$(cat ${PROJECT_DIR}/config/hostname)"



exit 0