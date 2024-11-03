<?php $this->load->view('_layouts/auth/auth_start') ?>
<div class="form-signin">
    <?php if($this->session->flashdata('message')): ?>
    <div class="alert alert-success" role="alert">
        <small class="text-success"><?= $this->session->flashdata('message') ?></small>
    </div>
    <?php endif ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <small class="text-danger"><?= $this->session->flashdata('error') ?></small>
    </div>
    <?php endif ?>
    <h1 class="text-center">Forgot Password</h1>
    <p class="text-muted text-center">Please enter your registered email to receive a reset link.</p>
    <form method="POST" action="<?= site_url('auth/forgot-password') ?>">
        <div class="form-group mb-3 <?= form_error('email') ? 'has-error has-feedback' : '' ?>">
            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control"/>
            <small class="form-text text-muted"><?= form_error('email') ?></small>
        </div>
        <button type="submit" class="btn btn-submit btn-success">Send Link</button>
    </form>
</div>
<?php $this->load->view('_layouts/auth/auth_end') ?>
