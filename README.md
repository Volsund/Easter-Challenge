# Easter-Challenge

-Players can be added to database.
-Players can battle between each other until there is only one active player left.
-Possibilty to see player statistics and info from last 50 games played.


1#   $ composer require catfan/medoo

2#   $database = new Medoo($databaseConfig); 

   can/should be replaced with:
   
    $database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'name',
    'server' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password'
    ]);
