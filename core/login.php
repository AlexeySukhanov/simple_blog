<?php

session_start();
require_once('database.php');

class Login
{
    public $db_object;
    public $base;
    public $error;
    public function __construct()
    {
        $this->db_object = new Database();
        $this->base = new stdClass();
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
        $this->index();
    }

    public function index()
    {
        if (!empty($_GET['status']) && $_GET['status'] === 'logout'){ // Если был произведен логаут сессия уничтожается
            session_unset();
            session_destroy();
            $this->error = 'Ваш сеанс завершен, пожалуйста авторизируйтесь cнова';
            require_once 'admin/tmpl/login_form.php';
        } elseif (!empty($_SESSION['isLogin']) && $_SESSION['isLogin'] ) { // Если сессия авторизации активна
            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php' );
            exit();
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Если была произведена попытка авторизации
                $this->validateDetails();
            } elseif (!empty($_GET['status'])){
                if ($_GET['status'] === 'inactive'){
                    session_unset();
                    session_destroy();
                    $this->error = 'Сеанс завершен в связи с отсутствием активности. Пожалуйста, авторизируйтесь снова.';
                }
            }
            require_once 'admin/tmpl/login_form.php';
        }
    }

    private function validateDetails()
    {
        if (!empty($_POST['username']) && !empty($_POST['password'])){
            // TODO: Усложнить функцию генерации пароля добавив в него соль
            //$salt = 'vuv;-oND?EfK`EXAsm+{s.RjR.!xVTiyla8K4%-%[+n&.rF0{}(.y%ArenW`ZL#b';
            // TODO: Реализовать возможность изменения личного пароля авторизованным пользователем
            $password = md5($_POST['password']);
            $return = array();
            $query = $this->db_object->pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            try {
                $query->execute( array($_POST['username'], $password) );
                for($i = 0; $row = $query->fetch(); $i++){
                    $return[$i] = array();
                    foreach( $row as $key => $rowitem ){
                        $return[$i][$key] = $rowitem;
                    }
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                echo 'База закосячилась';

            }
            if (!empty($return) && !empty($return[0])) {
                $this->loginSuccess();
            } else {
                $this->error = $this->loginFail();
            }
        } else{
            $this->error = 'Ошибка! Необходимо заполнить все поля.';
        }
    }


    public function loginSuccess()
    {
        $_SESSION['isLogin'] = true;
        $_SESSION['startTime'] = time();
        header('location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php');
        return;
    }

    public function loginFail()
    {
        return 'Ошибка! Неверное имя пользователя / пароль';
    }
}






































