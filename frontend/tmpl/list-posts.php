<?php require_once 'header.php'; ?>

<div class="grid-y grid-margin-y">
    <h1>List Posts</h1>
    <?php foreach(array_reverse($posts) as $post):
        <div class="cell">
            <h2>Сообщение №<?= $post['id']; ?>: <?= htmlspecialchars($post['title']); ?>.</h2>
            <p><?= implode(' ',  array_slice(explode(' ', strip_tags(($post['content']))), 0, 40)); ?>[...]</p>
            <a href="<?= $this->base->url . '/?id=' . $post['id']; ?>" class="button hollow">Подробнее</a>
            <hr>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'footer.php'; ?>



