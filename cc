#!/bin/bash

PWD=$(pwd)

find $PWD/tmp/cache/ -type f -name \*cake_\*  -exec rm -rf {} \;
