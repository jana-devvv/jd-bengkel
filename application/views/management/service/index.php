<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Management Service</h3>
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
            <button type="button" class="btn btn-success btn-add"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Service</button>
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
                    <th width="50%">Name</th>
                    <th width="30%">Price</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="50%">Name</th>
                    <th width="30%">Price</th>
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
<div class="modal fade" id="modalService" tabindex="-1" aria-labelledby="modalService" aria-hidden="true">
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
            <label for="price">Price</label>
            <input type="text" id="price" name="price" placeholder="example: 300000" class="form-control input-number"/>
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
        "url": "<?php echo site_url('management/service/fetch_all') ?>",
        "type": "GET",
      },
      "columns": [
        {"data": "id"},
        {"data": "name"},
        {
          "data": "price",
          "render": function(data, type, row) {
            return rupiah(data)
          }
        },
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
      $('#modalService').modal('show')
      $('#modalTitle').text('Form Add Service')

      $('#id').val("")
      $('#name').val("")
      $('#price').val("")
    })

    $('.btn-save').click(function() {
      var id = $('#id').val()
      var name = $('#name').val()
      var price = $('#price').val()
      
      if(id) {
        $.ajax({
          url: "<?php echo site_url('management/service/update') ?>",
          type: "POST",
          dataType: "JSON",
          data: { id, name, price },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalService').modal('hide')
              swal({
                title: "Success!",
                text: "Service updated successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem updating the service. Please try again.",
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
          url: "<?php echo site_url('management/service/insert') ?>",
          type: "POST",
          dataType: "JSON",
          data: { name, price },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalService').modal('hide')
              swal({
                title: "Success!",
                text: "Service created successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem creating the service. Please try again.",
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
        url: "<?php echo site_url('management/service/edit/') ?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#id').val(data.id)
          $('#name').val(data.name)
          $('#price').val(data.price)

          $('#modalTitle').text('Form Edit Service')
          $('#modalService').modal('show')
        }
      })
    })

    $('#datatable tbody').on('click', '.btn-delete', function() {
      var id = $(this).data('id')
      swal({
        title: "Are you sure?",
        text: "You want delete this service?",
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
            url: "<?php echo site_url('management/service/destroy/') ?>"+id,
            type: "POST",
            success: function(data) {
              table.ajax.reload()
              swal({
                title: "Deleted!",
                text: "Service has been deleted.",
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