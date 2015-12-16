#!/bin/bash

RUNTIME_DIR="$(dirname $(readlink -f $0))"
SOURCE_DIR="$(dirname $(readlink -f $RUNTIME_DIR/../..))"

php $SOURCE_DIR/yii migrate --interactive=0

exit 0