Console utility for loading CSV files into database
===================================================

  * Symfony 5.0
  
  * PHP 7.3.12

  * League/CSV 9.5


Steps
-----

Install symfony 5

Create database and migrate migrations

`bin/console doctrine:database:create`

`bin/console doctrine:migrations:migrate`

Run the parser

`bin/console app:parse --filePath ./src/Data/dataset.csv --no-debug`
