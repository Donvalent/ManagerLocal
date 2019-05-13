<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="name" placeholder="Имя..." required>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="surname" placeholder="Фамилия..." required>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="lastname" placeholder="Отчество...">
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <select class="selectpicker" name="gender" id="Select1" required>
                <option>Мужчина</option>
                <option>Женщина</option>
            </select>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="email" placeholder="Почта...">
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="position" placeholder="Должность...">
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="number" name="salary" placeholder="Зарплата..." required>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <label for="MultiplieSelect1">Отделы</label>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <select class="selectpicker" name="departments[]" multiple id="MultiplieSelect1" required>
                <?php foreach($departmentsList as $department => $item): ?>
                    <option>
                        <?php echo $item['title']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 text-center form-group">
            <button class="btn btn-primary" type="submit" name="submit">Добавить</button>
        </div>
    </div>
    
</form>


<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>