<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <div class="col-lg-2 col-md-2 col-sm form-group text-center">
        <input type="text" name="name" placeholder="Имя..." value="<?php echo $Employee['name']; ?>" required>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="surname" placeholder="Фамилия..." value="<?php echo $Employee['surname']; ?>" required>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="text" name="lastname" placeholder="Отчество..." value="<?php echo $Employee['lastname']; ?>">
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="gender" id="Select1" required>
            <option <?php if($Employee['gender'] == "Мужчина"){ echo 'selected'; } ?>>Мужчина</option>
            <option <?php if($Employee['gender'] == "Женщина"){ echo 'selected'; } ?>>Женщина</option>
        </select>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <input type="number" name="salary" placeholder="Зарплата..." value="<?php echo $Employee['salary']; ?>" required>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 text-center">
        <label for="MultiplieSelect1">Отделы</label>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-12 form-group text-center">
        <select class="selectpicker" name="departments[]" multiple id="MultiplieSelect1" required>
            <?php foreach($Departments as $Department => $item): ?>
                <option <?php foreach($Employee['departments'] as $departments => $Employee_department)
                { if($Employee_department == $item['title']){ echo 'selected';} } ?>>
                    <?php echo $item['title']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary" type="submit" name="submit"></button>
</form>


<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>