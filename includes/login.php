<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 23.08.2018
 * Time: 4:34
 */

require_once('database.php');

class Login
{
    public $db_object;
    public $base;
    public function __construct()
    {
        $this->db_object = new Database();
        $this->base = new stdClass(); //(object)'';
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
        $this->index();
    }
    public $error;

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateDetails();
        } elseif(!empty($_GET['status']) && $_GET['status'] = 'inactive'){
            $this->error = 'Сеанс завершен в связи с отсутствием активности. Пожалуйста, авторизируйтесь снова';
        }
        require_once 'admin/tmpl/loginform.php';
    }

    public function loginSuccess()
    {
        header('location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php');
        return;
    }

    public function loginFail()
    {
        return 'Ошибка! Неверное имя пользователя / пароль';
    }

    private function validateDetails()
    {
        if (!empty($_POST['username']) && !empty($_POST['password'])){
            $salt = 'vuv;-oND?EfK`EXAsm+{s.RjR.!xVTiyla8K4%-%[+n&.rF0{}(.y%ArenW`ZL#b';
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
}





































