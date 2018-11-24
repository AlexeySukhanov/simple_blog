<?php require_once 'header.php'; ?>

<div class="grid-x">
    <div class="cell">
        <div class="h3">Панель администрирования</div>
        <a href="<?php echo $this->base->url; ?>/admin/posts.php" class="button hollow secondary">К списку записей</a>

        <?php if(!empty($_GET['status'])): ?>
            <div class="callout warning" data-closable >
                <i class="fas fa-exclamation-triangle" style="color:tomato"></i>
                <?php echo $_GET['status']; ?>
                <button class="close-button" data-close>&times;</button>
            </div>
        <?php endif; ?>

        <form action="/admin/posts.php?action=save" method="post">
            <fieldset class="fieldset">
                <legend>Новая запись</legend>

                <label>
                    Заголовок записи
                    <input name="post[title]" type="text">
                </label>
                <label>
                    Содержимое записи
                    <textarea name="post[content]" id="content" cols="30" rows="10"></textarea>
                </label>
                <button type="submit" class="button float-right">Сохранить сообщение</button>
            </fieldset>
        </form>
    </div>
</div>

<?php require_once 'footer.php' ?>