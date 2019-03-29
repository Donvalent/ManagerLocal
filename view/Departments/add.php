<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<form action="#" method="post">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <input type="text" name="title" placeholder="Название..." required>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
            <label for="MultiplieSelect1">Добавить сотрудников</label>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 form-group text-center">
            <select multiple class="selectpicker" name="employees[]" data-live-search="true" data-size="5" id="MultiplieSelect1">
                <?php foreach($employeesList as $employees => $employee): ?>
                    <option title="<?php  echo $employee['shortName'];?>">
                        <?php echo $employee['surname'] . ' ' . $employee['name'] . ' ' . $employee['lastname']; ?>
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