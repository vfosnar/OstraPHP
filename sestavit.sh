#!/bin/bash
set -e

php/ophp -s -zostrava -vphp
mv php/ophp.php php/ophp
chmod +x php/ophp
