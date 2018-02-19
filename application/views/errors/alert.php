<?php if (validation_errors()): ?>
    <br>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <?= validation_errors() ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('message_error')): ?>
    <br>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <?= $this->session->flashdata('message_error') ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('message_info')): ?>
    <br>
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <?= $this->session->flashdata('message_info') ?>
    </div>
<?php endif; ?>
