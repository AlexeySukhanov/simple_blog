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
    <?php foreach ($post_comments as $comment): ?>
        <div class="cell">
            <div class="h4"><?= $comment['name']; ?> (<a href="mailto:<?= $comment['email']; ?>"><?= $comment['email']; ?></a>)</div>
            <p><?= $comment['comment']; ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>

