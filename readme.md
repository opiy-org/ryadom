composer install

php console/yii migrate --migrationPath=@common/migrations

php console/yii rbac-migrate/create init_roles

php console/yii rbac-migrate/up