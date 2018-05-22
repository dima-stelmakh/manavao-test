
composer install

php bin/console doctrine:schema:update --force

php bin/console doctrine:fix:load --append