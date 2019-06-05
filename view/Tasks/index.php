<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<a href="/tasks/add" class="btn btn-primary"><i class="fa fa-plus"></i> Новая задача</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Номер</th>
            <th scope="col">Сотрудник</th>
            <th scope="col">Название</th>
            <th scope="col">Статус</th>
            <th scope="col">Дата</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($taskList as $tasks => $task): ?>
        <tr>
            <td><a href="/tasks/view/<?php echo $task['id']; ?>"><i class="fa fa-share"></i></a></td>
            <td><?php echo $task['id']; ?></td>
            <td><a href="/employees/view/<?php echo $task['worker']['id']; ?>"><?php echo $task['worker']['shortName']; ?></a></td>
            <td><?php echo $task['title']; ?></td>
            <td><?php echo $task['status']['title']; ?></td>
            <td><?php echo $task['date']; ?></td>
            <td><a href="/tasks/edit/<?php echo $task['id']; ?>"><i class="fa fa-edit"></i></a></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>