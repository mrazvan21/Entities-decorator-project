only for "my project" ...

chmod -R 777 decorator/

1. php app/console doctrine:mapping:convert yml ./src/Dcl/DclBundle/Resources/config/doctrine/metadata/orm --from-database --force
2. copy /doctrine/metadata/orm/ -> entities/
3. update entities/ -> /doctrine/metadata/orm/
4. php app/console doctrine:mapping:import DclBundle yml
5. php app/console doctrine:generate:entities DclBundle 