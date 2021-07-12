<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$surround = 2;
$pager->setSurroundCount($surround);
?>
<div class="row">
    <div class="col-sm-12">
        <?php echo lang('Default.TotalData', ['start' => $start, 'end'=>$end, 'total'=>$totalrecord], $PageAttribute['locale']) ?>
    </div>
</div>
<hr>
<nav aria-label="<?php echo lang('Pager.pageNavigation') ?>">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="btn btn-primary btn-sm page-link" href="<?php echo $pager->getFirst() ?>" aria-label="<?php echo lang('Pager.first') ?>" style="border-radius: 23px 5px 5px 23px">
                    <span aria-hidden="true"><?php echo lang('Pager.first') ?></span>
                </a>
            </li>&nbsp;
            <li class="page-item">
                <a class="btn btn-primary btn-sm page-link" href="<?php echo $pager->getPrevious() ?>" aria-label="<?php echo lang('Pager.previous') ?>" style="border-radius: 5px 5px 5px 5px;">
                    <span aria-hidden="true"><?php echo lang('Pager.previous') ?></span>
                </a>
            </li>&nbsp;
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <?php if ($link['active']): ?>
                <li  class="<?php echo $link['active'] ?  'active' : 'page-item' ?> rounded">
                    <span class="btn btn-default btn-sm rounded-pill" style="border: 1px solid #669cf2">
                        <?php echo $link['title'] ?>
                    </span>
                </li>&nbsp;
            <?php else: ?>
                <li  class="<?php echo $link['active'] ?  'active' : 'page-item' ?> rounded">
                    <a href="<?php echo $link['uri'] ?>" class="btn btn-default btn-sm rounded-pill page-link" style="color:blue; ">
                        <?php echo $link['title'] ?>
                    </a>
                </li>&nbsp;
            <?php endif ?>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="btn btn-primary btn-sm page-link" href="<?php echo $pager->getNext() ?>" aria-label="<?php echo lang('Pager.next') ?>" style="border-radius: 5px 5px 5px 5px;">
                    <span aria-hidden="true"><?php echo lang('Pager.next') ?></span>
                </a>
            </li>&nbsp;
            <li class="page-item">
                <a class="btn btn-primary btn-sm page-link" href="<?php echo $pager->getLast() ?>" aria-label="<?php echo lang('Pager.last') ?>" style="border-radius: 5px 23px 23px 5px;">
                    <span aria-hidden="true"><?php echo lang('Pager.last') ?></span>
                </a>
            </li>&nbsp;
        <?php endif ?>
    </ul>
</nav>