<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 23.08.2018
 * Time: 4:35
 */

require 'database.php';

class Blog
{
    public $simple_blog_db; // ksdb
    public $base;

    public function __construct()
    {
        $this->simple_blog_db = new Database();
        $this->base           = new stdClass();
        $this->base->url      = "http://" . $_SERVER['SERVER_NAME'];
    }
}

class Posts extends Blog
{
    public function __construct()
    {
        parent::__construct();
        $this->comments = new Comments();
        if( !empty($_GET['id']) ){
            $this->viewPost($_GET['id']);
        } else {
            $this->getPosts();
        }
    }

    public function getPosts()
    {
        $id = 0;
        $posts = $return = array();
        $template = '';
        $query = $this->simple_blog_db->pdo->prepare("SELECT * FROM posts");

        try {
            $query->execute();
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $rowitem){
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }

        $posts = $return;
        $template = 'list-posts.php';
        include_once 'frontend/tmpl/' . $template;
    }

    public function viewPost( $postId )
    {
        $id = $postId;
        $posts = $return = array();
        $template = '';
        $query = $this->simple_blog_db->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        try{
            $query->execute(array($id));
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $rowitem){
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch(PDOException $e){
            echo $e->getMessage();
        }

        $posts = $return;
        $posts[0]['content'] = $posts[0]['content']; // вероятно ошибка
        $template = 'view-post.php';
        include_once 'frontend/tmpl/' . $template;
    }
}

class Comments extends Blog
{
    public function __construct()
    {
        parent::__construct();
    }

    public function commentNumber( $postId )
    {

    }

    public function getComments( $postId )
    {

    }

    public function addComment()
    {

    }


}



































