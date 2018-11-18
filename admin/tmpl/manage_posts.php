<?php require_once 'header.php'; ?>

<div class="grid-x">
    <div class="cell">
        <div class="h3">Панель администрирования</div>
        <a href="<?php echo '/admin/posts.php?action=create'; ?>" class="button hollow">Создать запись</a>
        <table class="hover">
            <thead>
                <tr>
                    <th>Номер записи</th>
                    <th>Заголовок</th>
                    <th>Содержимое</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($posts as $post): ?>
                <tr>
                    <td>№<?php echo htmlspecialchars($post['id']) ?></td>
                    <td>
                        <p><?php echo htmlspecialchars($post['title']) ?></>
                    </td>
                    <td>
                        <p><?php echo implode(' ', array_slice(explode(' ', strip_tags($post['content'])), 0, 10)); ?></>
                    </td>
                    <td class="button-group stacked-for-small">
                        <a href="<?php echo '/admin/posts.php?id=' . $post['id'] . '&action=edit'; ?>" class="button  hollow">Править</a>
                        <a href="<?php echo '/admin/posts.php?id=' . $post['id'] . '&action=delete';  ?>" class="button  hollow alert">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once 'footer.php' ?>