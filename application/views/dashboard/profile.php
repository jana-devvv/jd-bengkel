<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">Point of Sales | JD Bengkel</h6>
      </div>        
    </div>

    <!-- Widget -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header" style="background-image: url('assets/kaiaadmin/assets/img/blogpost.jpg')" >
                  <div class="profile-picture">
                    <div class="avatar avatar-xl">
                      <img
                        src="<?= base_url('assets/img/avatar-1.png') ?>"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="user-profile text-center">
                    <div id="profile-name" class="name"><?= $profile->name ?? "Who?" ?></div>
                    <div id="profile-position" class="job"><?= $profile->position ?? "???" ?></div>
                    <div id="profile-bio" class="desc"><?= isset($profile->bio) ? htmlspecialchars($profile->bio) : "?" ?></div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row user-stats text-center">
                    <div class="col">
                      <div id="profile-age" class="number"><?= $profile->age ?? "?" ?></div>
                      <div class="title">Age</div>
                    </div>
                    <div class="col">
                      <div class="number"><?= $user->role ?></div>
                      <div class="title">Role</div>
                    </div>
                    <div class="col">
                      <div id="profile-gender" class="number"><?= $profile->gender ?? "?" ?></div>
                      <div class="title">Gender</div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Settings</h4>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="line-profile-tab" data-bs-toggle="pill" href="#line-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="line-credential-tab" data-bs-toggle="pill" href="#line-credential" role="tab" aria-controls="pills-credential" aria-selected="false">Credential</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="line-password-tab" data-bs-toggle="pill" href="#line-password" role="tab" aria-controls="pills-password" aria-selected="false">Password</a>
						</li>
					</ul>
					<div class="tab-content mt-3 mb-3" id="line-tabContent">
						<div class="tab-pane fade show active" id="line-profile" role="tabpanel" aria-labelledby="line-profile-tab">
							<form method="POST" id="formProfile">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" value="<?= $profile->name ?? "" ?>" name="name" id="name" placeholder="ex: Jana" />
                </div>
                <div class="form-group">
                  <label for="age">Age</label>
                  <input type="text" class="form-control input-number" value="<?= $profile->age ?? "" ?>" name="age" id="age" placeholder="ex: 18" />
                </div>
                <div class="form-group">
                  <label for="position">Position</label>
                  <input type="text" class="form-control" id="position" value="<?= $profile->position ?? "" ?>" name="position" placeholder="ex: IT Support" />
                </div>
                <div class="form-group">
                  <label>Gender</label><br />
                  <div class="d-flex">
                    <div class="form-check">
                      <input class="form-check-input" value="male" type="radio" name="gender" id="male" <?= $profile->gender === "male" ? 'checked' : '' ?> />
                      <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" value="female" type="radio" name="gender" id="female" <?= $profile->gender === "female" ? 'checked' : '' ?> />
                      <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" value="unknown" type="radio" name="gender" id="unknown" <?= $profile->gender === "unknown" ? 'checked' : '' ?> />
                      <label class="form-check-label" for="unknown">Unknown</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="bio">Biodata</label>
                  <textarea class="form-control" name="bio" id="bio" rows="5"><?= isset($profile->bio) ? htmlspecialchars($profile->bio) : "" ?></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
						</div>
						<div class="tab-pane fade" id="line-credential" role="tabpanel" aria-labelledby="line-credential-tab">
							<form method="POST" id="formCredential">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" value="<?= $user->username ?? "" ?>" name="username" id="username" placeholder="ex: Jana Dev" />
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" value="<?= $user->email ?>" name="email" id="email" placeholder="ex: Jana@example.com" />
                </div>
                <div class="form-group">
                  <button class="btn btn-primary">Save changes</button>
                </div>
              </form>
						</div>
						<div class="tab-pane fade" id="line-password" role="tabpanel" aria-labelledby="line-password-tab">
              <form method="POST" id="formPassword">
                <div class="form-group mb-3 <?= $this->session->flashdata('error_old_password') ? "has-error has-feedback" : "" ?>">
                  <label for="old_password" class="form-label">Old Password</label>
                  <div class="input-icon">
                    <input type="password" id="old_password" name="old_password" placeholder="Enter old password" class="form-control input-password"/>
                    <span class="input-icon-addon toggle-password">
                      <i class="fa fa-eye"></i>
                    </span>
                  </div>
                  <small class="form-text text-muted"><?= $this->session->flashdata('error_old_password') ?></small>
                </div>
                <div class="form-group mb-3">
                  <label for="new_password" class="form-label">New Password</label>
                  <div class="input-icon">
                    <input type="password" id="new_password" name="new_password" placeholder="Enter new password" class="form-control input-password"/>
                    <span class="input-icon-addon toggle-password">
                      <i class="fa fa-eye"></i>
                    </span>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="confirm_password" class="form-label">Confirm New Password</label>
                  <div class="input-icon">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter confirm new password" class="form-control input-password"/>
                    <span class="input-icon-addon toggle-password">
                      <i class="fa fa-eye"></i>
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // $.ajax({
    //   type: "POST",
    //   url: "<?php echo site_url('profile/fetch_data') ?>",
    //   dataType: "JSON",
    //   success: function(response) {
    //     $('#name').val(response.name)
    //     $('#age').val(response.age)
    //     $('#position').val(response.position)
    //     $(`input[name=gender][value=${response.gender}]`).prop('checked', true)
    //     $('#bio').val(response.bio)
    //   }
    // })

    $('#formProfile').submit(function(e) {
      e.preventDefault()
      var formData = $(this).serialize()

      $.ajax({
        type: "POST",
        url: "<?php echo site_url('profile/save_profile') ?>",
        data: formData,
        dataType: "JSON",
        success: function(response) {
          $('#profile-name').text(response.name)
          $('#profile-age').text(response.age)
          $('#profile-position').text(response.position)
          $('#profile-gender').text(response.gender)
          $('#profile-bio').text(response.bio)
        }
      })
    })

    $('#formCredential').submit(function(e) {
      e.preventDefault()
      var formData = $(this).serialize()

      $.ajax({
        type: "POST",
        url: "<?php echo site_url('profile/save_credential') ?>",
        data: formData,
        dataType: "JSON",
        success: function(response) {
          $('#navbar-username').text(response.username)
          $('#profile-username').text(response.username)
          $('#profile-email').text(response.email)
        }
      })
    })

    $('#formPassword').submit(function(e) {
      e.preventDefault()
      var formData = $(this).serialize()

      $.ajax({
        type: "POST",
        url: "<?php echo site_url('profile/save_password') ?>",
        data: formData,
        dataType: "JSON",
        success: function(response) {
          if(response.status == "error") {
            showErrors(response.errors)
          } else {
            console.log('Yes')
          }
        }
      })
    })
  })
</script>