<?php
require_once('../private/classes/Db.php');
require_once('../private/classes/Hash.php');
require_once('../private/classes/Encoding.php');
require_once('../private/classes/Sanitize.php');

// SELECT QUERY
// $getUsers = Db::getInstance()->selectData('*', 'users');
// if($getUsers['result'] == 0) {
//     echo $getUsers['message'];
// } else if($getUsers['result'] == 1) {
//     $usersData = $getUsers['message'];
//     print_r($usersData);
//     foreach($usersData as $row) {
//         echo $row['USERNAME'];
//         echo $row['PASSWORD'];
//     }
// }

// INSERT QUERY
// $addData = Db::getInstance()->insertData('users', array(
//     'FIRSTNAME' => 'trytrytrytrytrytrytrytrytrytry',
//     'LASTNAME' => 'try',
//     'USERNAME' => 'try',
//     'EMAIL' => 'try',
//     'SALT' => 'try',
//     'PASSWORD' => 'try',
//     'CREATED_BY' => 1,
//     'CREATED_DT' => date('Y-m-d')
// ));
// if($addData['result'] == 0) {
//     echo $addData['message'];
// } else if($addData['result'] == 1) {
//     echo $addData['message'];
// }


// UPDATE QUERY
// $updateData = Db::getInstance()->updateData('users', 'ID = 17', array(
//     'FIRSTNAME' => 'qweasdzxc',
// ));
// if($updateData['result'] == 0) {
//     echo $updateData['message'];
// } else if($updateData['result'] == 1) {
//     echo $updateData['message'];
// }


// HASH CLASS
// echo Hash::make('try');


// ENCODING CLASS
// $try = 'Pepssson';
// echo Encoding::encode($try).'<br>';
// echo Encoding::decode(Encoding::encode($try)).'<br><br>';
// $try = 'Pepssson3453621532';
// echo Encoding::encode(Encoding::encode($try)).'<br>';
// echo Encoding::decode(Encoding::decode(Encoding::encode(Encoding::encode($try))));


// SANITIZE CLASS
// $string = "'asd a!<?)(**%@#%.,";
// var_dump(Sanitize::clean($string)).'<br>';
// var_dump(Sanitize::escapeOutput(Sanitize::clean($string)));

// Example usage:
// $inputString = "'asd a!<?)(**%@#%.,";
// $cleanedString = Sanitize::clean($inputString);
// $escapedString = Sanitize::escapeOutput($cleanedString);

// // Output the sanitized and escaped string
// echo $cleanedString.'<br>';
// echo "Sanitized and escaped string: " . $escapedString;







?>
