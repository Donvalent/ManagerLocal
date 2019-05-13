<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="card">
            <img src="https://via.placeholder.com/128" class="card-img-top" alt="">
            <div class="card-body">
                <h5 class="card-title"><?php echo $employee['surname'] . ' ' . $employee['name'] . ' ' . $employee['lastname']; ?></h5>
                <p class="card-text"><?php echo $employee['phone']; ?></p>
                <p class="card-text"><?php echo $employee['email']; ?></p>
                <p class="card-text"><?php echo $employee['position']; ?></p>
                <p class="card-text"><?php echo $employee['salary'] . ' руб'; ?></p>
                <p class="card-text">
                    <?php foreach($employee['departments'] as $item): ?>
                        <a href="#"><? echo $item; ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
    <!-- Table of day info -->
    <table class="table col-lg-9">
        <thead>
            <tr scope="col">
                <th scope="col">Программы</th>
                <th scope="col">Время</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($daysInfo as $processTitle => $time): ?>
                <tr>
                    <td><?php echo $processTitle; ?></td>
                    <td><?php echo ($time < 60) ? $time . ' мин' : round($time / 60, 1) . ' ч'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>
