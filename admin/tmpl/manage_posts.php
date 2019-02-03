<?php require_once 'header.php'; ?>

<div class="grid-x">
    <div class="cell">
        <div class="h3">Панель администрирования :: Управление записями </div>

        <?php if(!empty($_GET['status'])): ?>
            <div class="callout success" data-closable >
                <i class="fas fa-exclamation-triangle" style="color:green"></i>
                <?php echo $_GET['status']; ?>
                <button class="close-button" data-close>&times;</button>
            </div>
        <?php endif; ?>

        <a href="<?php echo '/admin/posts.php?action=create'; ?>" class="button hollow">Создать запись</a>
        <a href="<?php echo '/admin/comments.php'; ?>" class="button hollow">Комментарии</a>
        <table class="hover">
            <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Заголовок</th>
                    <th>Содержимое</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach(array_reverse($posts) as $post): ?>
                <tr>
                    <td>№<?php echo htmlspecialchars($post['id']); ?></td>
                    <td>
                        <p><?php echo htmlspecialchars($post['title']); ?></>
                    </td>
                    <td>
                        <p><?php echo implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)); ?></>
                    </td>
                    <td class="button-group stacked-for-small">
                        <a href="<?php echo '/admin/posts.php?action=edit&id=' . $post['id']; ?>" class="button hollow">Редактировать</a>
                        <a href="<?php echo '/admin/posts.php?action=delete&id=' . $post['id']; ?>" class="button hollow alert">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once 'footer.php' ?>