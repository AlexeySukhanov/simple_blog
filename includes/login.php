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
    public $simple_blog_db;
    public $base;
    public function __construct()
    {
        $this->simple_blog_db = new Database();
        $this->base = new stdClass(); //(object)'';
        $this->base->url = 'http://' . $_SERVER['SERVER_NAME'];
        $this->index();
    }

    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->validateDetails();
        } elseif(!empty($_GET['status']) && $_GET['status'] = 'inactive'){
            $error = 'Сеанс завершен в связи с отсутствием активности. Пожалуйста, авторизируйтесь снова';
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
        return 'Неверное имя пользователя / пароль';
    }

    private function validateDetails()
    {

    }
}