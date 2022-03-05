<div class="card mb-3">
    <div class="card-body text-center">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar" class="rounded-circle img-fluid" style="width: 100px;">
        <h5 class="my-3">John Smith</h5>
        <p class="text-muted mb-1">Full Stack Developer</p>
        <p class="text-muted mb-1">Bay Area, San Francisco, CA</p>
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