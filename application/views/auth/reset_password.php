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

        
        <h1 class="text-center">Reset Password</h1>
        <p class="text-muted text-center">Create a new password for you account.</p>
        <form method="POST" action="<?= site_url('auth/reset-password/' . $token) ?>">
            <!-- New Password -->
            <div class="form-group mb-3 <?= $this->session->flashdata('new_password_error') ? 'has-error has-feedback' : ''  ?>">
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-icon">
                <input type="password" id="new_password" name="new_password" placeholder="New password" class="form-control input-password"/>
                <span class="input-icon-addon toggle-password">
                    <i class="fa fa-eye"></i>
                </span>
                </div>
                <small class="form-text text-muted"><?= $this->session->flashdata('new_password_error') ?></small>
            </div>
            <!-- Confirm Password -->
            <div class="form-group mb-3  <?= $this->session->flashdata('confirm_password_error') ? 'has-error has-feedback' : '' ?>">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-icon">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Password confirmation" class="form-control input-password"/>
                <span class="input-icon-addon toggle-password">
                    <i class="fa fa-eye"></i>
                </span>
                </div>
                <small class="form-text text-muted"><?= $this->session->flashdata('confirm_password_error') ?></small>
            </div>
            <button type="submit" class="btn btn-submit btn-primary">Reset Password</button>
        </form>
    </div>
<?php $this->load->view('_layouts/auth/auth_end') ?>
