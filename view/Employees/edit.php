<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <div class="col-lg-2 col-md-2 col-sm form-group text-center">
        <input type="text" name="name" placeholder="Имя..." value="<?php echo $employee['name']; ?>" required>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="surname" placeholder="Фамилия..." value="<?php echo $employee['surname']; ?>" required>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="lastname" placeholder="Отчество..." value="<?php echo $employee['lastname']; ?>">
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="gender" id="Select1" required>
            <option <?php if($employee['gender'] == "Мужчина"){ echo 'selected'; } ?>>Мужчина</option>
            <option <?php if($employee['gender'] == "Женщина"){ echo 'selected'; } ?>>Женщина</option>
        </select>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="email" placeholder="Почта..." value="<?php echo $employee['email']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="phone" name="phone" placeholder="Телефон..." value="<?php echo $employee['phone']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="position" placeholder="Должность..." value="<?php echo $employee['position']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="number" name="salary" placeholder="Зарплата..." value="<?php echo $employee['salary']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 text-center">
        <label for="MultiplieSelect1">Отделы</label>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="departments[]" multiple id="MultiplieSelect1" required>
            <?php foreach($departmentsList as $department => $item): ?>
                <option <?php foreach($employee['departments'] as $departments => $employee_department)
                { if($employee_department == $item['title']){ echo 'selected';} } ?>>
                    <?php echo $item['title']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary" type="submit" name="submit">Обновить</button>
</form>


<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>