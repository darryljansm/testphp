<?php
require_once('../private/classes/Db.php');


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


$updateData = Db::getInstance()->updateData('users', 'ID = 17', array(
    'FIRSTNAME' => 'qweasdzxc',
));
if($updateData['result'] == 0) {
    echo $updateData['message'];
} else if($updateData['result'] == 1) {
    echo $updateData['message'];
}
?>
