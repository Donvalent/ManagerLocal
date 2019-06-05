<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <!-- Название -->
    <div class="col-lg-2 col-md-2 col-sm form-group text-center">
        <input type="text" name="title" placeholder="Название..." required>
    </div>
    <!-- Статус -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="status" id="Select1" required>
            <option>Не выполнено</option>
            <option>Выполняется</option>
            <option>Выполнено</option>
        </select>
    </div>
    <!-- Сотрудник -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="worker" id="Select1" required>
        <?php foreach($employeesList as $employees => $employee):?>
            <option><?php echo $employee['surname'] . " " . $employee['name'] . " " . $employee['lastname']; ?></option>
        <?php endforeach;?>
        </select>
    </div>
    <!-- Описание -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="description" placeholder="Описание..." required>
    </div>
    <!-- Даты -->
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="date" placeholder="Дата начала..." required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="deadline" placeholder="Дата сдачи..." required>
    </div>

    <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
</form>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>