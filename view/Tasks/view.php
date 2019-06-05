<!-- Header -->
<?php  include_once(ROOT . '/view/layouts/header.html'); ?>

<!-- Main -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $task['title']; ?></h5>
                <p class="card-text"><?php echo $task['status']['title']; ?></p>
                <p class="card-text"><a href="/employees/view/<?php echo $task['worker']['id']; ?>"><?php echo $task['worker']['shortName']; ?></a></p>
                <p class="card-text"><?php echo $task['description']; ?></p>
                <p class="card-text"><?php echo $task['date'] . " - " . $task['deadline']; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php  include_once(ROOT . '/view/layouts/footer.html'); ?>