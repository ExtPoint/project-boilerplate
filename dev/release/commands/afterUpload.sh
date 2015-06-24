#!/bin/bash
#

RUNTIME_DIR="$(dirname $(readlink -f $0))"
SOURCE_DIR="$(dirname $(readlink -f $RUNTIME_DIR/../..))"
PROJECT_DIR="$(dirname $(readlink -f $SOURCE_DIR))"

# Configuration
PROJECT_ENVIRONMENT="$(cat ${PROJECT_DIR}/config/project_environment)"
HOSTNAME="$(cat ${PROJECT_DIR}/config/hostname)"

# Append links, if no exists
[ ! -h $SOURCE_DIR/config.php ] && ln -sf $PROJECT_DIR/config/config.php $SOURCE_DIR/config.php



exit 0