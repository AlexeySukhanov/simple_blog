<?php

require_once 'database.php';
include_once './vendors/php-markdown/Michelf/Markdown.inc.php';

class Blog
{
    public $db_object; // ksdb
    public $base;

    public function __construct()
    {
        $this->db_object      = new Database();
        $this->base           = new stdClass();
        $this->base->url      = "http://" . $_SERVER['SERVER_NAME'];
    }
}

class Posts extends Blog
{
    public $comments;
    public function __construct()
    {
        parent::__construct();
        $this->comments = new Comments(); # Возможен дубль
        if( !empty($_GET['id']) ){
            $this->viewPost($_GET['id']);
        } else {
            $this->getPosts();
        }
    }

    public function getPosts()
    {
        $posts = $return = array();
        $template = '';
        $query = $this->db_object->pdo->prepare("SELECT * FROM posts");

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
        $markdown = new Michelf\Markdown();

        # Добавление в массив $posts значения количества комментариев для каждой записи
        foreach($posts as $key => $post ){
            $posts[$key]['content'] = $markdown->defaultTransform($posts[$key]['content']);
            $posts[$key]['comments'] = $this->comments->commentNumber($post['id']);
        }

        $template = 'list-posts.php';
        include_once 'frontend/tmpl/' . $template;
    }

    public function viewPost( $postId )
    {
        $id = $postId;
        $posts = $return = array();
        $template = '';
        $query = $this->db_object->pdo->prepare("SELECT * FROM posts WHERE id = ?");
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
        $markdown = new Michelf\Markdown(); // TODO: Добавить аналогичную обработку для вывода всех записей и вывода всех записей в админке
        $posts[0]['content'] = $markdown->defaultTransform($posts[0]['content']);
        $post_comments = $this->comments->getComments($posts[0]['id']);

        $template = 'view-post.php';
        include_once 'frontend/tmpl/' . $template;
    }
}

class Comments extends Blog
{
    public function __construct()
    {
        parent::__construct();
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment']) ){
            $this->addComment();
        }
    }

    public function commentNumber( $postid )
    {
        $return = array();
        $query = $this->db_object->pdo->prepare('SELECT * FROM comments WHERE postid =' . $postid);
        try {
            $query->execute();
            for( $i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $rowitem){
                    $return[$i] = $rowitem;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        $query = $return;
        $commentCount = count($query);
        if($commentCount <= 0){
            $commentCount = 0;
        }
        return $commentCount;
    }

    public function getComments( $postid )
   {
       $return = array();
       $query = $this->db_object->pdo->prepare('SELECT * FROM comments WHERE postid = ' . $postid);
       try{
            $query->execute();
            for($i = 0; $row = $query->fetch(); $i++){
                $return[$i] = array();
                foreach($row as $key => $rowitem){
                    $return[$i][$key] = $rowitem;
                }
            }
       } catch(PDOException $e) {
            echo $e->getMessage();
       }
       return $query = $return;
    }

    public function addComment()
    {
        $status = '';
        $array  = array();
        $pseudoVarArr = array();

        # Проверка подучения данных POST
        if(!empty($_POST['comment'])){ // Если значения из формы были передано
            $comment = $_POST['comment'];

            # Проверка того, что все поля заполнены и создание псевдопеременных для хранения их значений
            if(!empty($comment['fullname']) && !empty($comment['email']) && !empty($comment['context']) && !empty($comment['postid'])){
                # Создание списка колонок и списка псевдопременных
                $pseudoVarArr[] = ':fullname';
                $pseudoVarArr[] = ':email';
                $pseudoVarArr[] = ':context';
                $pseudoVarArr[] = ':postid';
                $array['name'] = $comment['fullname'];
                $array['email'] = $comment['email'];
                $array['comment'] = $comment['context'];
                $array['postid'] = $comment['postid'];

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

                try{
                    $query = $this->db_object->pdo->prepare("INSERT INTO comments (".$colNameList.") VALUES (".$pseudoVarList.")");
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
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }

        if(!empty($add) && $add > 0){
            $status = array('success' => 'Комментарий сохранен');
            $key = 'success';
        } else {
            $status = array('error' => 'В процессе сохранения комментария возникла ошибка');
            $key = 'error';
        }
        header('http://' . $_SERVER['SERVER_NAME'] . '/?id=' . $comment['postid']) . '&status=' . $key;

//        if(!empty($add && $add > 0)){
//            $status = 'Ваше сообщение успешно сохранено.';
//            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php" . "?status=" . $status);
//        } else{
//            $status = 'В процессе сохранения записи возникла ошибка.';
//            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/admin/posts.php?action=create&status=" . $status);
//        }

    }

}



































