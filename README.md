# Easter-Challenge

1# $ composer require catfan/medoo

2# 
   $database = new Medoo($databaseConfig); 

   can be replaced with:
   
    $database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'name',
    'server' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password'
    ]);
