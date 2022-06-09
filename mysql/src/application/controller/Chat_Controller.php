<?php
namespace Dasha\application\controller;

use Twig\Environment;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use DateTimeImmutable;
use PDO;

class Chat_Controller
{
    private $twig;
    private $log;
    private $messageHandler; //Handler

    public function __construct(Environment $twig, Logger $log, StreamHandler $messageHandler)
    {
        $this->twig = $twig;
        $this->log = $log;
        $this->messageHandler = $messageHandler;
    }

    public function __invoke()
    {
        echo $this->twig->render('auth.html.twig');
    }

    public function __invokeClear()
    {
        echo $this->twig->render('clear.html.twig');
    }

    public function __invokeMesseng($login)
    {
        echo $this->twig->render('messengs.html.twig',['login' => $login]);
    }

    // Запись сообщений в файл
    function add_message($connection, $login, $message)
    {
        $data = (new DateTimeImmutable())->format('Y-m-d h:i');
        $sql = 'insert into message_archive values (:data , :login, :message)';
        $stmt = $connection->prepare($sql);

        $stmt->bindParam('data', $data, PDO::PARAM_STR);
        $stmt->bindParam('login', $login, PDO::PARAM_STR);
        $stmt->bindParam('message', $message, PDO::PARAM_STR);
        $stmt->execute();

        echo "Загрузка...";

        $this->log->info('New message', ['login' => $login, 'message' => $message]);
    }

    function delete($connection) {
        $sql = 'DELETE FROM message_archive';
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        echo "<script> alert('Все данные удалены!') </script>";

        $this->log->info('Chat was cleared');
    }

    function print_message($connection)
    {
        $sql = 'SELECT * from message_archive ORDER BY data_mes ASC';
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $result = $connection->query($sql);

        if ($result->rowCount() !== 0) {
            foreach ($result as $row) {
                $data = $row["data_mes"];
                $login = $row["username"];
                $message = $row["messages"];

                echo "<p>$data $login: $message</p>";

            }} else echo "История сообщений пуста :(</p>";
        }
}
