#!/usr/bin/env bash

make cs-check || exit
make psalm || exit
