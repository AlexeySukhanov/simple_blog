<?php

session_start();
require_once 'database.php';

class AdminPanel
{
    public $db_object;
    public $base;

    public function __construct()
    {
        $this->db_object = new Database();
        $this->base = new stdClass();
        $this->base->url = "http://" . $_SERVER['SERVER_NAME'];
    }
}

class AdminPosts extends AdminPanel
{
    public function __construct()
    {
        parent::__construct();
        if(!empty($_GET['action'])){
            switch($_GET['action']){
                case 'create':
                    $this->addPost();
                    break;
                case 'edit':
                    $this->editPost();
                    break;
                case 'save':
                    $this->savePost();
                    break;
                case 'delete':
                    $this->deletePost();
                    break;
                default:
                    $this->listPosts();
                    break;
            }
        } else{
            //$this->addPost();
            $this->listPosts();
        }
    }

    public function listPosts()
    {
        $posts = $return = array();
        $query = $this->db_object->pdo->prepare("SELECT * FROM posts");
        try{
            $query->execute();
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach( $row as $key => $row_item ){
                    $return[$i][$key] = $row_item;
                }
            }
        } catch(PDOException $e){
            $e->getMessage();
        }
        $posts = $return;
        require_once 'tmpl/manage_posts.php';
    }
    public function addPost()
    {
        require_once 'tmpl/new_post.php';
    }

    public function savePost() // TODO: Проследить как это работает
    {
        $array = $format = $return = array();
        if(!empty($_POST['post'])){
            $post = $_POST['post'];
        }
        if(!empty($post['content'])){
            $array['content'] = $post['content'];
            $format[] = ':content';
        }
        $cols = $values = '';
        $i = 0;
        foreach($array as $col => $data){
            if($i == 0){
                $cols .= $col;
                $values .= $format[$i];
            } else{
                $cols .= ',' . $col;
                $values .= ',' . $format[$i];
            }
            $i++;
        }
        try{
            $query = $this->db_object->pdo->prepare("INSERT INTO posts (".$cols.") VALUES (".$values.")");
            for($c = 0; $c < $i; $c++){
                $query->bindParam($format[$c],${'var' . $c});
            }
            $z = 0;
            foreach($array as $col => $data){
                ${'var' . $z} = $data;
                $z++;
            }
            $result = $query->execute();
            $add = $query->rowCount();
        } catch(PDOException $e){
            echo $e->getMessage();
        }
        $query->closeCursor();
        $this->db_object = null;
        if(!empty($add)){
            $status = 'Ваше сообщение успешно сохранено.';
        } else{
            $status = 'В процессе сохранения вашего сообщения возникла ошибка. Пожалуйста, повторите попытку позднее.';
        }
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php"); // Возможна ошибка, проверить.
    }

    public function editPosts()
    {

    }
    public function editPost()
    {
        echo 'editPost() ' . $_GET['id'];
    }

    public function deletePost()
    {
        echo 'deletePost() ' . $_GET['id'];
    }
}
class AdminComments extends AdminPanel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listComments()
    {

    }

    public function deletePost()
    {

    }
}

$admin = new AdminPanel();