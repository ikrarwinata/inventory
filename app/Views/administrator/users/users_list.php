<?php
$this->extend('administrator/_templates/Container');
$this->section('content');
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-users"></i>&nbsp;<?php echo $PageAttribute["title"]; ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 mb-3">
            <?php echo form_open_multipart(base_url($PageAttribute['parent'] . '/from_excel'), 'class="form-inline"'); ?>
            <a href="<?php echo base_url($PageAttribute['parent'] . '/create') ?>" class="btn btn-sm btn-primary"><?php echo lang('Default.Button.CreateData', [], $PageAttribute['locale']) ?></a>&nbsp;
            <!--ENDIMPORTEXCELFILE-->
            <!--ENDEXPORTBUTTONS-->
            </form>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/index') ?>" class="form-inline" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" value="<?php echo $keyword; ?>">
                    <span class="input-group-btn">
                        <?php
                        if ($keyword <> '') {
                        ?>
                            <a href="<?php echo base_url($PageAttribute['parent'] . '/index') ?>" class="btn btn-default"><?php echo lang('Default.Button.ResetSearch', [], $PageAttribute['locale']) ?></a>
                        <?php
                        }
                        ?>
                        <button class="btn btn-primary" type="submit"><?php echo lang('Default.Button.SearchData', [], $PageAttribute['locale']) ?></button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form action="<?php echo base_url($PageAttribute['parent'] . '/index') ?>" class="form-inline" method="post">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text form-control">
                            <?php echo lang('Default.perPage', [], $PageAttribute['locale']) ?>
                        </div>
                    </div>
                    <input type="number" class="form-control" min="2" max="9999999999" name="perPage" value="<?php echo $perPage ?>">
                    <button class="btn btn-secondary" type="submit"><?php echo lang('Default.Button.Show', [], $PageAttribute['locale']) ?></button>
                </div>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('ci_flash_message') != NULL) : ?>
        <div class="alert text-center mb-1 mt-0 <?php echo session()->getFlashdata('ci_flash_message_type') ?>" role="alert">
            <small><?php echo session()->getFlashdata('ci_flash_message') ?></small>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo lang('Text.Data', [], $PageAttribute['locale']) ?> <?php echo $PageAttribute["title"]; ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo (site_url($PageAttribute['parent'] . '/delete_batch')) ?>" method="post">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="80px">#</th>
                                            <th class="align-middle" width="80px"><input type="checkbox" class=""></th>
                                            <th style="transform: rotate(0);">
                                                <a href="<?php echo base_url($PageAttribute['parent'] . '/index?sortcolumn=' . base64_encode('username') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                    <?php if ($sortcolumn == "username") : ?>
                                                        <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                        <?php endif ?>Username
                                                </a>
                                            </th>
                                            <th style="transform: rotate(0);">
                                                <a href="<?php echo base_url($PageAttribute['parent'] . '/index?sortcolumn=' . base64_encode('password') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                    <?php if ($sortcolumn == "password") : ?>
                                                        <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                        <?php endif ?>Password
                                                </a>
                                            </th>
                                            <th style="transform: rotate(0);">
                                                <a href="<?php echo base_url($PageAttribute['parent'] . '/index?sortcolumn=' . base64_encode('nama') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                    <?php if ($sortcolumn == "nama") : ?>
                                                        <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                        <?php endif ?>Nama
                                                </a>
                                            </th>
                                            <th style="transform: rotate(0);">
                                                <a href="<?php echo base_url($PageAttribute['parent'] . '/index?sortcolumn=' . base64_encode('level') . '&sortorder=' . ($sortorder == 'ASC' ? 'DESC' : 'ASC')); ?>" class="stretched-link text-decoration-none" style="text-decoration: none;color: #243245;">
                                                    <?php if ($sortcolumn == "level") : ?>
                                                        <i class="fa fa-sort-<?php echo ($sortorder == 'DESC' ? 'down' : 'up'); ?>"></i>&nbsp;
                                                        <?php endif ?>Level
                                                </a>
                                            </th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    </tbody>
                                    <?php
                                    $counter = $start;
                                    foreach ($data as $value) :
                                    ?>
                                        <tr>
                                            <td><?php echo $counter++ ?></td>
                                            <td class="align-middle"><input type="checkbox" class="" name="removeme[]" value="<?php echo $value->username ?>"></td>
                                            <td><?php echo $value->username ?></td>
                                            <td><?php echo $value->password ?></td>
                                            <td><?php echo $value->nama ?></td>
                                            <td><?php echo $value->level ?></td>
                                            <td>
                                                <span class="float-right">
                                                    <a type="button" class="btn btn-sm btn-primary" href="<?php echo base_url($PageAttribute['parent'] . '/read/' . $value->username) ?>" title="<?php echo (lang('Default.Tooltips.Read', [], $PageAttribute["locale"])) ?>"><i class="fa fa-eye fa-lg"></i></a>
                                                    <a type="button" class="btn btn-sm btn-warning" href="<?php echo base_url($PageAttribute['parent'] . '/update/' . $value->username) ?>" title="<?php echo (lang('Default.Tooltips.Update', [], $PageAttribute["locale"])) ?>"><i class="fa fa-edit fa-lg"></i></a>
                                                    <a type="button" class="btn btn-sm btn-danger" href="<?php echo base_url($PageAttribute['parent'] . '/delete/' . $value->username) ?>" onclick="javascript: return confirm('<?php echo (lang('Promp.Delete', [], $PageAttribute["locale"])) ?>')" title="<?php echo (lang('Default.Tooltips.Delete', [], $PageAttribute["locale"])) ?>"><i class="fa fa-trash fa-lg"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-sm btn-outline-warning ml-2 mt-2 mb-2" title="<?php echo lang('Default.Tooltips.DeleteSelected', [], $PageAttribute['locale']) ?>" onclick="return confirm('<?php echo lang('Promp.DeleteSelected', [], $PageAttribute['locale']) ?>')">
                                <i class="fa fa-minus-square"></i>&nbsp;<?php echo lang("Default.Button.DeleteSelected", [], $PageAttribute["locale"]) ?>
                            </button>
                            <a href="<?php echo site_url($PageAttribute['parent'] . '/truncate') ?>" class="btn btn-sm btn-outline-danger ml-2 mt-2 mb-2" onclick="return confirm('<?php echo lang('Promp.Truncate', [], $PageAttribute['locale']) ?>')">
                                <i class="fa fa-trash"></i>&nbsp;<?php echo lang("Default.Button.Truncate", [], $PageAttribute["locale"]) ?>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="x_footer">
                    <div class="row">
                        <!-- pagination -->
                        <?php echo $pager->makeLinks($currentPage, $perPage, $totalrecord, 'custom_pagination') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection(); ?>;