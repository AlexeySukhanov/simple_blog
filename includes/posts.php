<?php
/**
 * Created by PhpStorm.
 * User: Выпучень
 * Date: 23.08.2018
 * Time: 4:35
 */

require('database.php');

class Blog
{
    public $simple_blog_db = ''; // ksdb
    public $base           = '';

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

    }

    public function getPosts()
    {

    }

    public function viewPost( $postId )
    {

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



































