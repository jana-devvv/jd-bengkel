<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Management User</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="#">
            <i class="icon-home"></i>
          </a>
        </li>
        <?php foreach($breadcrumbs as $breadcrumb): ?>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#"><?= $breadcrumb ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header">
            <button type="button" class="btn btn-success btn-add"><span class="btn-label"><i class="fa fa-plus"></i></span>Add User</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="datatable"
                class="display table-head-bg-primary table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="25%">Username</th>
                    <th width="25%">Email</th>
                    <th width="20%">Role</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="30%">Username</th>
                    <th width="30%">Email</th>
                    <th width="20%">Role</th>
                    <th width="10%">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add / Edit -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUser" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Modal Add / Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="example: jana-devvv" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example: example@gmail.com" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="password" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
              <option value="">-- Select Role --</option>
              <?php foreach($roles as $role): ?>
                <option value="<?= $role ?>"><?= $role ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-save">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  var table;

  $(document).ready(function() {
    table = $('#datatable').DataTable({
      "ajax": {
        "url": "<?php echo site_url('management/user/fetch_all') ?>",
        "type": "GET",
      },
      "columns": [
        {"data": "id"},
        {"data": "username"},
        {"data": "email"},
        {"data": "role"},
        {
          "data": null,
          "render": function(data, type, row) {
            return `<div class="btn-group" role="group">
            <button type="button" class="btn btn-icon btn-warning btn-edit" data-id="${data.id}"><i class="fa fa-pencil-alt"></i></button> 
            <button type="button" class="btn btn-icon btn-danger btn-delete" data-id="${data.id}"><i class="fa fa-trash"></i></button>
            </div>`
          }
        },
      ]
    })

    $('.btn-add').click(function() {
      $('#form')[0].reset()
      $('#form .form-group').removeClass('has-error has-feedback');
      $('#form .form-text').text('')
      $('#modalUser').modal('show')
      $('#modalTitle').text('Form Add User')
      $('#password').closest('.form-group').find('label').text('Password')
      $('#password').attr('placeholder', 'Password')

      $('#id').val("")
      $('#username').val("")
      $('#email').val("")
      $('#password').val("")
      $('#role').val("")
    })

    $('.btn-save').click(function() {
      var id = $('#id').val()
      var username = $('#username').val()
      var email = $('#email').val()
      var password = $('#password').val()
      var role = $('#role').val()
      
      if(id) {
        var new_password = $('#new_password').val()
        $.ajax({
          url: "<?php echo site_url('management/user/update') ?>",
          type: "POST",
          dataType: "JSON",
          data: { id, username, email, new_password, role },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalUser').modal('hide')
              swal({
                title: "Success!",
                text: "User updated successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem updating the user. Please try again.",
              icon: "error",
              buttons: {
                confirm: {
                  className: "btn btn-success",
                },
              },
            });
          }
        })
      } else {
        $.ajax({
          url: "<?php echo site_url('management/user/insert') ?>",
          type: "POST",
          dataType: "JSON",
          data: { username, email, password, role },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalUser').modal('hide')
              swal({
                title: "Success!",
                text: "User created successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem creating the user. Please try again.",
              icon: "error",
              buttons: {
                confirm: {
                  className: "btn btn-success",
                },
              },
            });
          }
        })
      }
    })

    $('#datatable tbody').on('click', '.btn-edit', function() {
      $('#form')[0].reset()
      $('#form .form-group').removeClass('has-error has-feedback');
      $('#form .form-text').text('')

      var id = $(this).data('id')
      $.ajax({
        url: "<?php echo site_url('management/user/edit/') ?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#id').val(data.id)
          $('#username').val(data.username)
          $('#email').val(data.email)
          $('#role').val(data.role)

          $('#password').closest('.form-group').find('label').text('New Password')
          $('#password').attr('placeholder', 'New Password')
          $('#password').attr('name', 'new_password')
          $('#password').attr('type', 'new_password')
          $('#password').attr('id', 'new_password')
          $('#modalTitle').text('Form Edit User')
          $('#modalUser').modal('show')
        }
      })
    })

    $('#datatable tbody').on('click', '.btn-delete', function() {
      var id = $(this).data('id')
      swal({
        title: "Are you sure?",
        text: "You want delete this user?",
        type: "warning",
        buttons: {
          cancel: {
            visible: true,
            text: "Cancel",
            className: "btn btn-danger",
          },
          confirm: {
            text: "Yes, delete it!",
            className: "btn btn-success",
          },
        },
      }).then((Delete) => {
        if (Delete) {
          $.ajax({
            url: "<?php echo site_url('management/user/destroy/') ?>"+id,
            type: "POST",
            success: function(data) {
              table.ajax.reload()
              swal({
                title: "Deleted!",
                text: "User has been deleted.",
                type: "success",
                buttons: {
                  confirm: {
                    className: "btn btn-success",
                  },
                },
              });
            }
          })
        } else {
          swal.close();
        }
      });
    })
  })
</script>