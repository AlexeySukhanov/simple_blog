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
    public function __construct()
    {

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

    }

    public function editPosts()
    {

    }

    public function editPost()
    {

    }

    public function addPost()
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