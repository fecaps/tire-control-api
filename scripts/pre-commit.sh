#!/bin/sh
printf "Check syntax errors with PHP Scan:\n"
vendor/bin/phpstan analyse -v src/ --level 5
printf "\nCheck code style with PHP Code Sniffer:\n"
./vendor/bin/phpcs -sw --standard=PSR2 --colors src/ tests/
printf "\nRun unit tests and generate code coverage:\n"
vendor/bin/phpunit -c build/
printf "\nCheck raw metrics stream using PHP Mess Detector:\n"
vendor/bin/phpmd src/ text codesize




