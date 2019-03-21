<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Body -->
<table class="table">
    <thead>
        <tr>
            <th scope="col">Сотрудники</th>
            <?php foreach($departmentsList as $departments => $department): ?>
                <th scope="col"><?php echo $department['title']; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($employeesList as $employees => $employee): ?>
            <tr>
                <td><?php echo $employee['surname'];?></td>
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