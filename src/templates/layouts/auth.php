<div class="auth-form">
    <div>
        <h1>Авторизация</h1>
        <form action="/auth" method="post">
            <input type="email" name="mail" placeholder="Введите E-mail" value="<?=$mail ?? ''?>">
            <input type="password" name="pass" placeholder="Введите пароль" value="<?=$pass ?? ''?>">
            <button type="submit">Войти</button>
        </form>
    </div>
</div>
<script>
    if (<?=$error ?? 'false'?>) {
        DialogWindow.Toast.show('Неверный E-mail или пароль.');
    }
</script>