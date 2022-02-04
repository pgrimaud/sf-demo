<?php

$email = 'hell\'o@pierre.com';

$query = 'SELECT * FROM users WHERE email = ' . addslashes("'$email'");
$query2 = 'SELECT * FROM users WHERE email = "' . addslashes($email) . '"';

print_r($query);

echo PHP_EOL;

print_r($query2);