<?php $this->load->view('_layouts/auth/auth_start') ?>
<div class="form-signin">
    <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <small class="text-success"><?= $this->session->flashdata('message') ?></small>
        </div>
    <?php endif ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <small class="text-danger"><?= $this->session->flashdata('error') ?></small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <h1 class="text-center">Sign In</h1>
    <p class="text-muted text-center">Welcome back! Please sign in to continue</p>
    <form method="POST" action="<?= site_url('auth/login') ?>">
        <div class="form-group mb-0 <?= form_error('email') ? 'has-error has-feedback' : '' ?>">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control"/>
            <small id="emailHelp" class="form-text text-muted"><?= form_error('email') ?></small>
        </div>
        <div class="form-group mb-3 <?= form_error('password') ? 'has-error has-feedback' : '' ?>">
            <label for="password" class="form-label">Password</label>
            <div class="input-icon">
                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control input-password"/>
                <span class="input-icon-addon toggle-password">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
            <small class="form-text text-muted"><?= form_error('password') ?></small>
        </div>
        <button type="submit" class="btn btn-submit btn-primary">Sign In</button>
        <div class="mb-3 form-text text-center">
            <a href="<?= site_url('auth/forgot-password') ?>" class="text-decoration-none">Forgot password?</a>
        </div>
    </form>
</div>
<?php $this->load->view('_layouts/auth/auth_end') ?>