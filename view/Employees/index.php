<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<table class="table">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Отчество</th>
            <th scope="col">Пол</th>
            <th scope="col">Должность</th>
            <th scope="col">Зарплата</th>
            <th scope="col">Отделы</th>
            <th scope="col"></th>
            <th scope="col"></th>            
        </tr>
    </thead>
    <tbody>
        <?php foreach($employeesList as $employees => $employee): ?>
        <tr>
            <td><a href="/employees/view/<?php echo $employee['id']; ?>"><i class="fa fa-share"></i></a></td>
            <td><?php echo $employee['name']; ?></td>
            <td><?php echo $employee['surname']; ?></td>
            <td><?php echo $employee['lastname']; ?></td>
            <td><?php echo $employee['gender']; ?></td>
            <td><?php echo $employee['position']; ?></td>
            <td><?php echo $employee['salary']; ?> руб</td>
            <td>
                <?php foreach($employee['departments'] as $departments => $department): ?>
                <a href="">
                     <?php echo $department; ?>
                </a>
                <?php endforeach; ?>
            </td>
            <td><a href="/employees/edit/<?php echo $employee['id']; ?>"><i class="fa fa-edit"></i></a></td>
            <td><a href="#"><i class="fa fa-minus-circle"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/employees/add" class="btn btn-primary"><i class="fa fa-plus"></i> Новый сотрудник</a>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>