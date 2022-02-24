<?php
esc($pager->links());

?>
<nav aria-label="<?php echo lang('Pager.pageNavigation') ?>">
  <ul class="pagination">
    <?php //if ($pager->hasPreviousPage()) : ?>
      <li>
        <a href="<?php echo ''//$pager->getFirst() ?>" aria-label="<?php echo lang('Pager.first') ?>">
          <span aria-hidden="true"><?php echo lang('Pager.first') ?></span>
        </a>
      </li>
      <li>
        <a href="<?php echo ''//$pager->getPreviousPage() ?>" aria-label="<?php echo lang('Pager.previous') ?>">
          <span aria-hidden="true"><?php echo lang('Pager.previous') ?></span>
        </a>
      </li>
    <?php //endif ?>

    <?php //foreach ($pager->links() as $link) : ?>
      <li <?php echo '' //$link['active'] ? 'class="active"' : '' ?>>
        <a href="<?php echo '' //$link['uri'] ?>">
          <?php echo ''//$link['title'] ?>
        </a>
      </li>
    <?php //endforeach ?>

    <?php //if ($pager->hasNextPage()) : ?>
      <li>
        <a href="<?php echo ''//$pager->getNextPage() ?>" aria-label="<?php echo lang('Pager.next') ?>">
          <span aria-hidden="true"><?php echo lang('Pager.next') ?></span>
        </a>
      </li>
      <li>
        <a href="<?php echo ''//$pager->getLast() ?>" aria-label="<?php echo lang('Pager.last') ?>">
          <span aria-hidden="true"><?php echo lang('Pager.last') ?></span>
        </a>
      </li>
    <?php //endif ?>
  </ul>
</nav>

<? echo "<hr>" ?>
<? echo "<hr>" ?>
<? echo "<hr>" ?>




<?php
echo "<pre>";
echo var_dump($noticias);
echo "</pre>";
echo "<hr><hr>";
echo "<pre>" . var_dump($pager) . "</pre>";
?>