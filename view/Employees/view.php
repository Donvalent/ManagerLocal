<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-12 col-sm-12 justify-content-center">
        <div class="card text-center">
            <img src="https://via.placeholder.com/500" class="card-img-top" alt="">
            <div class="row card-body">
                <h5 class="card-title col-lg-12 text-primary">
                    <?php
                        echo
                        $EmployeeList['surname'] . ' '
                        . $EmployeeList['name'] . ' '
                        . $EmployeeList['lastname'];
                    ?>
                </h5>
                <div class="col-lg-4 text-info">
                    <p class="cart-text">Пол</p>
                </div>
                <div class="col-lg-6">
                    <p class="cart-text"><?php echo $EmployeeList['gender']; ?></p>
                </div>
                <div class="col-lg-4 text-info">
                    <p class="cart-text">Телефон</p>
                </div>
                <div class="col-lg-6">
                    <p class="cart-text"><?php echo $EmployeeList['phone']; ?></p>
                </div>
                <div class="col-lg-4 text-info">
                    <p class="cart-text">Почта</p>
                </div>
                <div class="col-lg-6">
                    <p class="cart-text"><?php echo $EmployeeList['email']; ?></p>
                </div>
                <div class="col-lg-4 text-info">
                    <p class="cart-text">Должность</p>
                </div>
                <div class="col-lg-6">
                    <p class="cart-text"><?php echo $EmployeeList['position']; ?></p>
                </div>
                <div class="col-lg-4 text-info">
                    <p class="cart-text">Отделы</p>
                </div>
                <div class="col-lg-6">
                    <p class="cart-text"><?php echo implode(', ',$EmployeeList['departments']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>
