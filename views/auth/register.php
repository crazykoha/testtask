<div class="wrap">
    <form method="post" action="/auth/register">
        <input class="form-control" type="text" name="name" placeholder="Логин" required>
        <input class="form-control" type="password" name="password" placeholder="Пароль" required>
        <input class="btn btn-info" type="submit" value="Зарегистрироваться">
        <p class="text-danger"><?=$params['error']?></p>
    </form>
</div>