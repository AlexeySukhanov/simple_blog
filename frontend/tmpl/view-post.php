<?php require_once 'header.php'; ?>

<div class="grid-y grid-margin-y">

    <h1>View Post</h1>
    <div class="cell">
        <a href="<?= $this->base->url; ?>" class="button hollow">Вернуться к списку сообщений</a>
    </div>
    <?php foreach($posts as $post): ?>
        <div class="cell">
            <h2>Сообщение №<?= $post['id']; ?>: <?= htmlspecialchars($post['title'], ENT_QUOTES); ?></h2>
            <p><?= $post['content']; ?></p>
            <hr>
        </div>
    <?php endforeach; ?>

    <?php if(!empty($post_comments)): ?>
        <div class="h3">Комментарии:</div>
    <?php endif; ?>

    <table>
        <?php foreach ($post_comments as $comment): ?>
            <tr>
                <td width="100">
                    <figure>
                        <figcaption><b><?= $comment['name']; ?></b></figcaption>
                        <img src="http://www.gravatar.com/avatar/<?= md5($comment['email']); ?>" alt="<?= $comment['name']; ?>">
                    </figure>
                </td>
                <td>
                    <p><?= $comment['text']; ?></p>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if(!empty($status)): ?>
        <div class="cell">
            <div class="callout warning" data-closable >
                <i class="fas fa-exclamation-triangle" style="color:tomato"></i>
                <?php echo $status; ?>
                <button class="close-button" data-close>&times;</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="cell">
        <form id="comments_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $_GET['id'] . '#comments_form'; ?>" method="post">
            <fieldset class="fieldset">
                <legend>Оставить комментарий</legend>
                <input type="hidden" name="token" value="<?= rand(); ?>">
                <input type="hidden" name="comment[postid]" value="<?= $_GET['id']; ?>">
                <label>
                    Имя
                    <input type="text" name="comment[name]" placeholder="Ведите ваше имя">
                </label>
                <label>
                    Email
                    <input type="email" name="comment[email]" placeholder="Введите email">
                </label>
                <label>
                    Комментарий
                    <textarea name="comment[text]" placeholder="Введите текст комментария" rows="4"></textarea>
                </label>
                <button type="submit" class="button float-right">Отправить комментарий</button>
            </fieldset>
        </form>
    </div>


</div>

<?php require_once 'footer.php'; ?>

