<?php require_once 'header.php' ; ?>

<div class="grid-x align-center">
    <div class="cell small-11 medium-8 large-6">
        <?php if(!empty($this->error)): ?>
            <div class="callout warning" data-closable >
                <i class="fas fa-exclamation-triangle" style="color:tomato"></i>
                <?php echo $this->error; ?>
                <button class="close-button" data-close>&times;</button>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="grid-x align-center">
    <div class="cell small-11 medium-8 large-6">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <fieldset class="fieldset">
                <legend>Вход в панель администрирования</legend>
                <label>Имя пользователя:<input name="username" type="text" placeholder="Имя" value="<?php echo $_POST['username'] ?>"></label>
                <label>Пароль:<input name="password" type="password" placeholder="Пароль" value="<?php echo $_POST['password'] ?>"></label>
                <button type="submit" class="button hollow expanded">Войти</button>
            </fieldset>
        </form>
    </div>
</div>



<?php require_once 'footer.php' ?>

