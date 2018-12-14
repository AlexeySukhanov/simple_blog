<?php require_once 'header.php'; ?>

    <div class="grid-x">
        <div class="cell">
            <div class="h3">Панель администрирования :: Управление комментариями</div>

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
                    <th>Имя автора</th>
                    <th>Email автора</th>
                    <th>Комментарий</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($comments as $comment): ?>
                    <tr>
                        <td>№<?php echo htmlspecialchars($comment['id']); ?></td>
                        <td>
                            <p><?php echo htmlspecialchars($comment['name']); ?></>
                        </td>
                        <td>
                            <p><?php echo htmlspecialchars($comment['email']); ?></>
                        </td>
                        <td>
                            <p><?php echo htmlspecialchars($comment['comment']); ?></>
                        </td>
                        <td class="button-group stacked-for-small">
                            <a href="<?php echo '/admin/comments.php?action=delete&id=' . $comment['id']; ?>" class="button  hollow alert">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

<?php require_once 'footer.php' ?>