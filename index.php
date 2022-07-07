<?php
// load F3
require 'vendor/autoload.php';

// instantiate f3
$f3 = Base::instance();

// set config / routes
$f3->config('config/config.ini');
$f3->config('config/routes.ini');


// run F3
$f3->run();





$db = new DB\SQL(
    $f3->get('db_dns'),
    $f3->get('db_user'),
    $f3->get('db_password'),
    array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
);

$sprites = ['male', 'female', 'human', 'identicon', 'initials', 'bottts', 'avataaars', 'jdenticon', 'gridy', 'micah'];
$url = "https://avatars.dicebear.com/api/";
$bg = "?background=%23";

// https://avatars.dicebear.com/api/ male /john.svg ?background=%23a72a31
// $values = $db->exec('select * from user');
// foreach ($values as $value) {
//     $random = '/' . dechex(rand(0, 99999)) . '.svg';
//     $bgr = dechex(rand(0,16777215));
//     while (strlen($bgr) < 6) {
//         $bgr = $bgr . dechex(rand(0,15));
//     }
//     $iurl = $url . $sprites[array_rand($sprites, 1)] . $random . $bg . $bgr;
//     $data = array(":url"=>$iurl, ":id"=>$value['user_id']);
//     $db->exec('UPDATE user SET image_URL=:url WHERE user_id = :id', $data);
// }