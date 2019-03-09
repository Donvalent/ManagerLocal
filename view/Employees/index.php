<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<div class="employees">
    <div class="cardContainer">
        <?php foreach($EmployeesList as $Employees => $Employee): ?>
            <a href="/employees/<?php echo $Employee['id']; ?>">
                <div class="employee">
                    <img src="https://via.placeholder.com/100" class="avatar">
                    <div class="employee-info">
                        <strong class="name"><?php echo $Employee['fullName']; ?></strong>
                        <p class="phone"><?php echo $Employee['phone']; ?></p>
                        <p class="email"><?php echo $Employee['email']; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>
