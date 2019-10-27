<form method="post" action="/task/update" class="task_form">
    <input type="hidden" value="<?=$params['task']->attributes['id']?>" name="id">
    <input class="form-control" type="text" name="user_name" value="<?=$params['task']->attributes['user_name']?>" placeholder="Имя пользователя" required>
    <input class="form-control" type="text" name="email" value="<?=$params['task']->attributes['email']?>" placeholder="Email" required>
    <textarea class="form-control" name="text" placeholder="Текст задачи" required><?=$params['task']->attributes['text']?></textarea>
    <input class="form-check-input" type="checkbox" name="status" <?=$params['task']->attributes['status']?'checked':''?>><span>Выполнено</span>
    <br>
    <input class="btn btn-info" type="submit" value="Сохранить">
</form>