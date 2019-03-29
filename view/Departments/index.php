<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Сотрудников</th>
            <th scope="col">Максимальная зарплата</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($departmentsList as $department): ?>
            <tr>
                <td><a href="/departments/view/<?php echo $department['id']; ?>"><?php echo $department['title']; ?></a></td>
                <td><?php echo $department['countEmployees']; ?></td>
                <td><?php echo $department['maxSalary']; ?> руб</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/departments/add" class="btn btn-primary"><i class="fa fa-plus"></i> Новый отдел</a>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>