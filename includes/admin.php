<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 23.08.2018
 * Time: 4:33
 */

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

class Posts extends AdminPanel
{
    public function __construct()
    {
        parent::__construct();
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
    public function editPosts()
    {

    }

    public function editPost()
    {

    }
    public function savePost()
    {

    }

    public function deletePost()
    {

    }
}

class Comments extends AdminPanel
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