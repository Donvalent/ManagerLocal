<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Body -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Сотрудники</th>
            <?php foreach($departmentsList as $departments => $department): ?>
                <th scope="col"><a href="/departments/view/<?php echo $department['id']; ?>"><?php echo $department['title']; ?></a></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employeesList as $employees => $employee): ?>
            <tr>
                <!-- Аббревиатура -->
                <td><a href="/employees/view/<?php echo $employee['id']; ?>"><?php echo $employee['surname'] . '.' . substr($employee['name'],0,2) . '.' . substr($employee['lastname'],0,2) . '.';?></a></td>
                <!-- Заполнение таблицы -->
                <?php foreach($departmentsList as $departments => $department): ?>
                    <?php
                        if(in_array($department['title'], $employee['departments']))
                            echo '<td>+</td>';
                        else
                            echo '<td> </td>';
                    ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>