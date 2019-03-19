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
        <?php foreach($departmentsList as $departments => $department): ?>
            <tr>
                <td><?php echo $department['title']; ?></td>
                <td><?php echo $department['countEmployees']; ?></td>
                <td><?php echo $department['maxSalary']; ?> руб</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>