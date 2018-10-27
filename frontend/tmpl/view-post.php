<?php require_once 'header.php'; ?>

<div class="grid-y grid-margin-y">
    <h1>View Post</h1>
    <?php foreach( $posts as $post ): ?>
        <div class="cell">
            <h2>Сообщение №<?= $post['id']; ?>: <?= htmlspecialchars($post['title'], ENT_QUOTES); ?></h2>
            <p><?= htmlspecialchars($post['content'], ENT_QUOTES ); ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
    <div class="cell">
        <a href="<?= $this->base->url; ?>" class="button hollow">Вернуться к списку сообщений</a>
    </div>

</div>

<?php require_once 'footer.php'; ?>

