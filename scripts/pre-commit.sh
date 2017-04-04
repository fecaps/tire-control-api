#!/bin/sh
echo "Check syntax errors with PHP Scan:"
vendor/bin/phpstan analyse -v src/ --level 5
echo "\nCheck code style with PHP Code Sniffer:"
./vendor/bin/phpcs -sw --standard=PSR2 --colors src/ tests/
echo "\nRun unit tests and generate code coverage:"
vendor/bin/phpunit -c build/
echo "\nCheck raw metrics stream using PHP Mess Detector:"
vendor/bin/phpmd src/ text codesize




