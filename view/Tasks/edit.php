<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <!-- Название -->
    <div class="col-lg-2 col-md-2 col-sm form-group text-center">
        <input type="text" name="title" placeholder="Название..." value="<?php echo $task['title']; ?>" required>
    </div>
    <!-- Статус -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="status" id="Select1" required>
            <option <?php if($task['status']['title'] == 'Не выполнено'){ echo 'selected'; } ?>>Не выполнено</option>
            <option <?php if($task['status']['title'] == 'Выполняется'){ echo 'selected'; } ?>>Выполняется</option>
            <option <?php if($task['status']['title'] == 'Выполнено'){ echo 'selected'; } ?>>Выполнено</option>
        </select>
    </div>
    <!-- Сотрудник -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="worker" id="Select1" required>
        <?php foreach($employeesList as $employees => $employee):?>
            <option <?php if($employee['id'] == $task['worker']['id']){ echo 'selected'; } ?>><?php echo $employee['surname'] . " " . $employee['name'] . " " . $employee['lastname']; ?></option>
        <?php endforeach;?>
        </select>
    </div>
    <!-- Описание -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="description" placeholder="Описание..." value="<?php echo $task['description']; ?>" required>
    </div>
    <!-- Даты -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="date" placeholder="Дата начала..." value="<?php echo $task['date']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="deadline" placeholder="Дата сдачи..." value="<?php echo $task['deadline']; ?>" required>
    </div>

    <button class="btn btn-primary" type="submit" name="submit">Обновить</button>
</form>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>