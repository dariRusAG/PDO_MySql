<?php

use Dasha\application\controller\Chat_Controller;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once dirname(__DIR__) . '/vendor/autoload.php';
$connection = new PDO('mysql:dbname=MyBase;host=127.0.0.1','dasha','param12345');
$File_Logs = "/var/www/html/mysql/logs/logs_archive.log";

$loader = new FilesystemLoader(dirname(__DIR__) . '/templates/');
$messageHandler = new StreamHandler($File_Logs, Logger::INFO);

$twig = new Environment($loader);
$log = new Logger('action');
$chat = new Chat_Controller($twig, $log, $messageHandler);

$log->pushHandler($messageHandler);

$chat->__invoke();
$chat->__invokeClear();

echo "История сообщений:</p>";
$chat->print_message($connection);

$login = $_GET['login'];
$password = $_GET['password'];

if ((!empty($login)) || (!empty($password))) {
    $sql = 'SELECT * from user where username = :login';
    $stmt = $connection->prepare($sql);
    $stmt->bindParam('login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $table = $stmt->fetchAll();

    if ($table[0]['password'] == $password) {
        setcookie('global_login', $login, time() + 180);
        $chat->__invokeMesseng($login);
    } else if (empty($table)) {
        $log->error('This user is not registered');
        echo "<script> alert('Такого пользователь незарегестрирован.') </script>";
    } else {
        $log->error('Non-existent user or incorrect password entered');
        echo "<script> alert('Введен неверный пароль.') </script>";
    }
}

$message = $_GET['message'];
if (isset($message) && $message !== '') {
    $chat->add_message($connection, $_COOKIE['global_login'], $message);
    header('Refresh: 0; url=index.php');
}

//Удаление всех сообщений
if (isset($_GET['delete'])) {
    $chat->delete($connection);
    header('Refresh: 0; url=index.php');
}
?>