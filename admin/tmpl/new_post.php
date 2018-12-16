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

        <form action="/admin/posts.php?action=save" method="post" id="createEnty">
            <fieldset class="fieldset">
                <legend>Новая запись</legend>
                <label>
                    Заголовок записи
                    <input name="post[title]" type="text" placeholder="Введите заголовок">
                </label>
                <label>
                    Содержимое записи
<!--                    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>-->
<!--                    <input type="hidden" id="hcontent" name="post[content]" value="empty">-->
<!---->
<!---->
<!--                    <div class="wmd-panel controls">-->
<!--                        <div id="wmd-button-bar"></div>-->
<!--                        <textarea  id="wmd-input" class="wmd-input" cols="30" rows="8" placeholder="Введите содержимое"></textarea>-->
<!--                    </div>-->

                    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>


                    <div class="wmd-panel controls">
                        <div id="wmd-button-bar"></div>
                        <textarea name="post[content]" id="wmd-input" class="wmd-input" cols="30" rows="8" placeholder="Введите содержимое"></textarea>
                    </div>



                </label>
                <button type="submit" class="button float-right">Сохранить сообщение</button>
            </fieldset>
        </form>
    </div>
</div>

<?php require_once 'footer.php' ?>