<div class="card mb-3">
    <div class="card-body text-center">
        <img src="<?php echo $user->photo; ?>" class="rounded-circle img-fluid">
        <h5 class="my-3"><?php echo $user->name; ?></h5>
        <p class="text-muted mb-1"><?php echo $user->name; ?></p>
    </div>
</div>
<ul class="list-group">
    <?php
    $uri = service('uri');
    foreach ($menu_user as $m) :
        $active = "";
        if (preg_match("#{$m['base']}#i", $uri->getSegment(1))) $active = "active";
    ?>
        <a href="<?php echo base_url($m['url']) ?>" class="list-group-item list-group-item-action <?php echo $active; ?>" aria-current="true"><?php echo $m['name']; ?></a>
    <?php
    endforeach;
    ?>

</ul>