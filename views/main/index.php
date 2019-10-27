<?php
/** @var array $params */
?>
<?php if($_GET['text']):?>
    <div class="message"><?=$_GET['text']?></div>
<?php endif ?>
<a class="btn btn-success task_create_button" href="/task/create">Создать задачу</a>
<form method="get" action="/main/index">
    <select name="sort" class="custom-select">
        <option <?=$_GET['sort']==='user_name'?'selected':''?> value="user_name">Имя</option>
        <option <?=$_GET['sort']==='email'?'selected':''?> value="email">Email</option>
        <option <?=$_GET['sort']==='status'?'selected':''?> value="status">Статус</option>
    </select>
    <select name="order" class="custom-select">
        <option <?=$_GET['order']==='desc'?'selected':''?> value="desc">По убыванию</option>
        <option <?=$_GET['order']==='asc'?'selected':''?> value="asc">По возрастанию</option>
    </select>
    <input type="submit" value="Сортировать" class="btn btn-info">
</form>
<br>
<?php foreach ($params['tasks'] as $task): ?>
<div class="p-2 bg-primary text-white task_block">
    <?php $user=\models\User::getCurrentUser();
    if($user->attributes['is_admin']==1):?>
    <span>
        <a class="btn-danger" href="/task/update?id=<?=$task->attributes['id']?>">Изменить</a>
    </span>
    <?php endif ?>
    <p>Статус: <?=$task->attributes['status']?"Выполнено":"Выполняется"?></p>
    <p><?=htmlspecialchars($task->attributes['user_name'], ENT_QUOTES, 'UTF-8');?></p>
    <p><?=htmlspecialchars($task->attributes['email'], ENT_QUOTES, 'UTF-8');?></p>
    <p><?=htmlspecialchars($task->attributes['text'], ENT_QUOTES, 'UTF-8');?></p>
    <?php if($task->attributes['updated_by_admin']):?>
        <p>Отредактировано администратором</p>
    <?php endif ?>
</div>
<?php endforeach;?>
<div class="pager">
    <?php for($i = 0; $i<$params['pages_count']; $i++):?>
        <a class="bnt btn-info" href="?page=<?=$i+1?>&sort=<?=$_GET['sort']?>&order=<?=$_GET['order']?>"><?=$i+1?></a>
    <?php endfor; ?>
</div>