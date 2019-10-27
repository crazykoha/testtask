<form method="post" action="/task/create" class="task_form">
    <input class="form-control" type="text" name="user_name" placeholder="Имя пользователя" required>
    <input class="form-control" type="text" name="email" placeholder="Email" required>
    <textarea class="form-control" name="text" placeholder="Текст задачи" required></textarea>
    <?=$params['error']?>
    <br>
    <input class="btn btn-info" type="submit" value="Создать">
</form>