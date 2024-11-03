<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Management Item</h3>
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
            <button type="button" class="btn btn-success btn-add"><span class="btn-label"><i class="fa fa-plus"></i></span> Add Item</button>
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
                    <th width="30%">Name</th>
                    <th width="10%">Category</th>
                    <th width="10%">Stock</th>
                    <th width="10%">Purchase</th>
                    <th width="10%">Selling</th>
                    <th width="20%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="30%">Name</th>
                    <th width="10%">Category</th>
                    <th width="10%">Stock</th>
                    <th width="10%">Purchase</th>
                    <th width="10%">Selling</th>
                    <th width="20%">Action</th>
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
<div class="modal fade" id="modalItem" tabindex="-1" aria-labelledby="modalItem" aria-hidden="true">
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
            <input type="text" id="name" name="name" placeholder="example: computer" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" placeholder="example: electronics" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="stock">Stock</label>
            <input type="text" id="stock" name="stock" placeholder="example: 10" class="form-control input-number"/>
          </div>
          <div class="form-group">
            <label for="purchase">Purchase Price</label>
            <input type="text" id="purchase" name="purchase" placeholder="example: 5000000" class="form-control input-number"/>
          </div>
          <div class="form-group">
            <label for="selling">Selling Price</label>
            <input type="text" id="selling" name="selling" placeholder="example: 10000000" class="form-control input-number"/>
          </div>
          <div class="form-group">
            <label for="date">Date In</label>
            <input type="date" id="date" name="date" class="form-control"/>
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
        "url": "<?php echo site_url('management/item/fetch_all') ?>",
        "type": "GET",
      },
      "columns": [
        {"data": "id"},
        {"data": "name"},
        {"data": "category"},
        {"data": "stock"},
        {
          "data": "purchase_price",
          "render": function(data, type, row) {
            return rupiah(data)
          } 
        },
        {
          "data": "selling_price",
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

    $('.btn-pdf').click(function() {
      window.open('<?php echo site_url('management/item/pdf') ?>', '_blank')
    })
    
    $('.btn-excel').click(function() {
      window.open('<?php echo site_url('management/item/excel') ?>', '_blank')
    })

    $('.btn-add').click(function() {
      $('#form')[0].reset()
      $('#form .form-group').removeClass('has-error has-feedback');
      $('#form .form-text').text('')
      $('#modalItem').modal('show')
      $('#modalTitle').text('Form Add Item')

      $('#id').val("")
      $('#name').val("")
      $('#category').val("")
      $('#stock').val("")
      $('#purchase').val("")
      $('#selling').val("")
      $('#date').val("")
    })

    $('.btn-save').click(function() {
      var id = $('#id').val()
      var name = $('#name').val()
      var category = $('#category').val()
      var stock = $('#stock').val()
      var purchase = $('#purchase').val()
      var selling = $('#selling').val()
      var date = $('#date').val()
      
      if(id) {
        $.ajax({
          url: "<?php echo site_url('management/item/update') ?>",
          type: "POST",
          dataType: "JSON",
          data: { id, name, category, stock, purchase, selling, date },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalItem').modal('hide')
              swal({
                title: "Success!",
                text: "Item updated successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem updating the item. Please try again.",
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
          url: "<?php echo site_url('management/item/insert') ?>",
          type: "POST",
          dataType: "JSON",
          data: { name, category, stock, purchase, selling, date },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalItem').modal('hide')
              swal({
                title: "Success!",
                text: "Item created successfully!",
                icon: "success",
                buttons: false,
                timer: 1000,
              });
            }
          },
          error: function(){
            swal({
              title: "Error!",
              text: "There was a problem creating the item. Please try again.",
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
        url: "<?php echo site_url('management/item/edit/') ?>"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#id').val(data.id)
          $('#name').val(data.name)
          $('#category').val(data.category)
          $('#stock').val(data.stock)
          $('#purchase').val(data.purchase_price)
          $('#selling').val(data.selling_price)
          $('#date').val(data.date_in)

          $('#modalTitle').text('Form Edit Item')
          $('#modalItem').modal('show')
        }
      })
    })

    $('#datatable tbody').on('click', '.btn-delete', function() {
      var id = $(this).data('id')
      swal({
        title: "Are you sure?",
        text: "You want delete this item?",
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
            url: "<?php echo site_url('management/item/destroy/') ?>"+id,
            type: "POST",
            success: function(data) {
              table.ajax.reload()
              swal({
                title: "Deleted!",
                text: "Item has been deleted.",
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