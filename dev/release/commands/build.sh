#!/bin/bash
#

RUNTIME_DIR="$(dirname $(readlink -f $0))"
SOURCE_DIR="$(dirname $(readlink -f $RUNTIME_DIR/../..))"

cd $SOURCE_DIR
composer install
npm install

node webpack production

exit 0