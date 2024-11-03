<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Management Customer</h3>
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
            <button type="button" class="btn btn-success btn-add"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Customer</button>
            <button type="button" class="btn btn-danger btn-pdf float-end"><span class="btn-label"><i class="fa fa-file-pdf"></i></span> Export PDF</button>
            <button type="button" class="btn btn-secondary btn-excel float-end me-2"><span class="btn-label"><i class="fa fa-file-excel"></i></span> Export Excel</button>
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
                    <th width="20%">Name</th>
                    <th width="25%">Phone Number</th>
                    <th width="35%">Address</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="20%">Name</th>
                    <th width="25%">Phone Number</th>
                    <th width="35%">Address</th>
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
<div class="modal fade" id="modalCustomer" tabindex="-1" aria-labelledby="modalCustomer" aria-hidden="true">
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
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="example: Jana" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" placeholder="example: 081234567890" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="5"></textarea>
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
        "url": "<?php echo site_url('management/customer/fetch_all') ?>",
        "type": "GET",
      },
      "columns": [
        {"data": "id"},
        {"data": "name"},
        {"data": "phone_number"},
        {"data": "address"},
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

    $('.btn-pdf').click(function() {
      window.open('<?php echo site_url('management/customer/pdf') ?>', '_blank')
    })
    
    $('.btn-excel').click(function() {
      window.open('<?php echo site_url('management/customer/excel') ?>', '_blank')
    })

    $('.btn-add').click(function() {
      $('#form')[0].reset()
      $('#form .form-group').removeClass('has-error has-feedback');
      $('#form .form-text').text('')
      $('#modalCustomer').modal('show')
      $('#modalTitle').text('Form Add Customer')

      $('#id').val("")
      $('#name').val("")
      $('#phone').val("")
      $('#address').val("")
    })

    $('.btn-save').click(function() {
      var id = $('#id').val()
      var name = $('#name').val()
      var phone = $('#phone').val()
      var address = $('#address').val()
      
      if(id) {
        $.ajax({
          url: "<?php echo site_url('management/customer/update') ?>",
          type: "POST",
          dataType: "JSON",
          data: { id, name, phone, address },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalCustomer').modal('hide')
              swal({
                title: "Success!",
                text: "Customer updated successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem updating the customer. Please try again.",
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
          url: "<?php echo site_url('management/customer/insert') ?>",
          type: "POST",
          dataType: "JSON",
          data: { name, phone, address },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalCustomer').modal('hide')
              swal({
                title: "Success!",
                text: "Customer created successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem creating the customer. Please try again.",
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
        url: "<?php echo site_url('management/customer/edit/') ?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#id').val(data.id)
          $('#name').val(data.name)
          $('#phone').val(data.phone_number)
          $('#address').val(data.address)

          $('#modalTitle').text('Form Edit Customer')
          $('#modalCustomer').modal('show')
        }
      })
    })

    $('#datatable tbody').on('click', '.btn-delete', function() {
      var id = $(this).data('id')
      swal({
        title: "Are you sure?",
        text: "You want delete this customer?",
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
            url: "<?php echo site_url('management/customer/destroy/') ?>"+id,
            type: "POST",
            success: function(data) {
              table.ajax.reload()
              swal({
                title: "Deleted!",
                text: "Customer has been deleted.",
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