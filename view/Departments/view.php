<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<h1 class="text-center"><?php echo $department['title']; ?></h1>
<table class="table">
    <thead>
        <tr scope="col">
            <th scope="col">Имя</th>
            <th scope="col">Пол</th>
            <th scope="col">Должность</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employeesList as $employees => $employee): ?>
        <tr>
            <td><a href="/employees/view/<?php echo $employee['id']; ?>"><?php echo $employee['shortName']; ?><a></td>
            <td><?php echo $employee['gender']; ?></td>
            <td><?php echo $employee['position']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>