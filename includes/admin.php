<?php

session_start();
require_once 'database.php';

class AdminPanel
{
    public $db_object;
    public $base;

    public function __construct()
    {
        // Проверка на просроченность сессии
        $inactive = 600;
        if(isset($_SESSION['isLogin'])){
            $sessionDuration = time() - $_SESSION['startTime'];
            if($sessionDuration > $inactive){
                session_unset();
                session_destroy();
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php?status=inactive');
            }
        }

        # Обновление времени начала сессии
        $_SESSION['startTime'] = time();

        if(empty($_SESSION['isLogin'])){ // Если была попытка зайти в админ-панель напрямую
            session_unset();
            session_destroy();
            header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php?status=loggedout');
        } else{
            $this->db_object = new Database();
            $this->base = new stdClass();
            $this->base->url = "http://" . $_SERVER['SERVER_NAME'];
        }
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

    public function savePost()
    {
        $array = array();
        $pseudoVarArr = array();

        # Проверка подучения данных POST
        if(!empty($_POST['post'])){ // Если значения из формы были передано
            $array = $_POST['post'];

            # Проверка того, что все поля заполнены и создание псевдопеременных для хранения их значений
            if(!empty($array['title']) && !empty($array['content']) ){
                $pseudoVarArr[] = ':title';
                $pseudoVarArr[] = ':content';

                # Создание списка колонок и списка псевдопременных
                $colNameList   = ''; // Список названий колонок
                $pseudoVarList = ''; // Список названий псевдопеременных
                $i = 0;
                foreach($array as $colName => $data){
                    if($i == 0){
                        $colNameList .= $colName;
                        $pseudoVarList .= $pseudoVarArr[$i];
                    } else{
                        $colNameList .= ',' . $colName;
                        $pseudoVarList .= ',' . $pseudoVarArr[$i];
                    }
                    $i++;
                }

                # Запрос к бд
                try{
                    $query = $this->db_object->pdo->prepare("INSERT INTO posts (".$colNameList.") VALUES (".$pseudoVarList.")");
                    for($c = 0; $c < $i; $c++){
                        $query->bindParam($pseudoVarArr[$c],${'pseudoVar' . $c});
                    }
                    $z = 0;
                    foreach($array as $colName => $data){
                        ${'pseudoVar' . $z} = $data;
                        $z++;
                    }
                    $result = $query->execute();
                    $add = $query->rowCount();
                    $query->closeCursor();
                    $this->db_object = null;

                } catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
         }
        if(!empty($add) && $add > 0){
            $status = 'Ваше сообщение успешно сохранено.';
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php" . "?status=" . $status);
        } else{
            $status = 'В процессе сохранения записи возникла ошибка.';
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php?action=create&status=" . $status);
        }

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
        if(!empty($_GET['id']) && is_numeric($_GET['id'])){
            $query = $this->db_object->pdo->prepare('DELETE FROM posts WHERE id = ?');
            $query->execute(array($_GET['id']));
            $delete = $query->rowCount();
            $query->closeCursor();
            $this->db_object = null;

            if(!empty($delete) && $delete > 0){
                $status = 'Запись была успешно удалена.';
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php?status=' . $status ); //  TODO: Здесь и аналогичних редиректах предусмотреть возможность входа через https
            } else{
                $status = 'В процессе удаления записи возникла ошибка. Пожалуйста, повторите попытку позднее.';
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/posts.php?status=' . $status ); //  TODO: Здесь и аналогичних редиректах предусмотреть возможность входа через https
            }
        }

    }
}
class AdminComments extends AdminPanel
{
    public function __construct()
    {
        parent::__construct();
        if(!empty($_GET['action'] && $_GET['action'] == 'delete')){
            $this->deleteComment();
        } else {
            $this->listComments();
        }
    }

    public function listComments()
    {
        $comments = array();
        $return = array();
        $query = $this->db_object->pdo->prepare("SELECT * FROM comments");
        try{
            $query->execute();
            for($i = 0; $row = $query->fetch(); $i++ ){
                $return[$i] = array();
                foreach($row as $key => $rowitem){
                    $return[$i][$key] = $rowitem;
                }
            }
        } catch (PDOException $e){
            echo $e->getMessage();
        }
        print_r($row);
        $comments = $return;
        require_once 'tmpl/manage_comments.php';
    }

        public function deleteComment()
    {
        if(!empty($_GET['id']) && is_numeric($_GET['id'])){
            $query = $this->db_object->pdo->prepare('DELETE FROM comments WHERE id = ?');
            $query->execute(array($_GET['id']));
            $deleted = $query->rowCount();
            $this->db_object = null;

            if(!empty($delete) && $delete > 0){
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/comments.php?delete=success'); //  TODO: Здесь и аналогичних редиректах предусмотреть возможность входа через https
            } else {
                header('Location: http://' . $_SERVER['SERVER_NAME'] . '/admin/comments.php?delete=error'); //  TODO: Здесь и аналогичних редиректах предусмотреть возможность входа через https
            }
        }
    }
}

$admin = new AdminPanel();