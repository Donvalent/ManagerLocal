<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Отчество</th>
            <th scope="col">Пол</th>
            <th scope="col">Должность</th>
            <th scope="col">Зарплата</th>
            <th scope="col">Отделы</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($EmployeesList as $Employees => $Employee): ?>
        <tr onclick="window.location.href='employees/<?php echo $Employee['id']; ?>'; return false">
            <td><?php echo $Employee['name']; ?></td>
            <td><?php echo $Employee['surname']; ?></td>
            <td><?php echo $Employee['lastname']; ?></td>
            <td><?php echo $Employee['gender']; ?></td>
            <td><?php echo $Employee['position']; ?></td>
            <td><?php echo $Employee['salary']; ?> руб</td>
            <td>
                <?php foreach($Employee['departments'] as $departments => $department): ?>
                <a href="">
                     <?php echo $department; ?>
                </a>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>