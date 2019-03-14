<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<div class="profile">
    <img src="https://via.placeholder.com/200" alt="" class="profile-img">
    <div class="profile-info">
        <p class="profile-surname"><?php echo $Employee['surname']; ?></p>
        <p class="profile-name"><?php echo $Employee['name']; ?></p>
        <p class="profile-lastname"><?php echo $Employee['lastname']; ?></p>
        <p class="profile-phone"><?php echo $Employee['phone']; ?></p>
        <p class="profile-email"><?php echo $Employee['email']; ?></p>
        <p class="profile-position"><?php echo $Employee['position']; ?></p>
        <p class="salary"><?php echo $Employee['salary']; ?></p>
        <div class="profile-departments">
            <p class="department-title">
                <?php foreach($Employee['departments'] as $departments => $department_title): ?>
                    <?php echo '<a href="">' . $department_title .'</a>'; ?>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
</div>
<div class="content">
    
</div>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>
