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

    public function savePost()
    {
        $array = array();
        $pseudoVarArr = array();
        // $return = array();

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
                $i      = 0;
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

                } catch(PDOException $e){
                    echo $e->getMessage();
                }

                $query->closeCursor();
                $this->db_object = null;
            }

         }


        if(!empty($add)){
            $status = 'Ваше сообщение успешно сохранено.';
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php" . "?status=" . $status);
        } else{
            $status = 'В процессе сохранения вашей записи возникла ошибка. Пожалуйста, повторите попытку позднее.';
            header("Location:" . $_SERVER['PHP_SELF'] . "/?action=create&status=" . $status);
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