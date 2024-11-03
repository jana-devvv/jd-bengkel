<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Transaction Sale</h3>
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
        <div class="card">
          <div class="card-header">
            <button type="button" class="btn btn-success btn-add"><span class="btn-label"><i class="fa fa-plus"></i></span>Add Transaction</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="datatable-sale"
                class="display table-head-bg-primary table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="25%">Customer</th>
                    <th width="25%">Sale Date</th>
                    <th width="20%">Sale Total</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">ID</th>
                    <th width="25%">Customer</th>
                    <th width="25%">Sale Date</th>
                    <th width="20%">Sale Total</th>
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
<div class="modal fade" id="modalSale" tabindex="-1" aria-labelledby="modalSale" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="step1">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Modal Add / Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="formSale">
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="customer">Customer</label>
            <select class="form-control" id="customer" name="customer">
              <option value="">-- Select Customer --</option>
              <?php foreach($customers as $customer): ?>
                <option value="<?= $customer->id ?>"><?= $customer->name ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="sale_date">Sale Date</label>
            <input type="datetime-local" id="sale_date" name="sale_date" class="form-control"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-next">Next</button>
      </div>
    </div>

    <div class="modal-content" id="step2" style="display: none">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Modal Add / Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header">
            <button type="button" class="btn btn-success btn-add-row"><span class="btn-label"><i class="fa fa-plus"></i></span> Add Row</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="table-add-detail"
                class="display table-head-bg-info table table-striped"
              >
                <thead>
                  <tr>
                    <th width="5%">No.</th>
                    <th width="20%">Type</th>
                    <th width="20%">Name</th>
                    <th width="20%">Price</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Subtotal</th>
                    <th width="5%">Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="5%">No.</th>
                    <th width="20%">Type</th>
                    <th width="20%">Name</th>
                    <th width="20%">Price</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Subtotal</th>
                    <th width="5%">Action</th>
                  </tr>
                </tfoot>
                <tbody>
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-prev">Previous</button>
        <button type="button" class="btn btn-primary btn-save">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetail" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailTitle">Modal Detail Transaction Sale</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="datatable-detail"
                class="w-100 display table-head-bg-primary table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th width="10%">No.</th>
                    <th width="20%">Type</th>
                    <th width="25%">Name</th>
                    <th width="20%">Quantity</th>
                    <th width="25%">Subtotal</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th width="10%">No.</th>
                    <th width="20%">Type</th>
                    <th width="25%">Name</th>
                    <th width="20%">Quantity</th>
                    <th width="25%">Subtotal</th>
                  </tr>
                </tfoot>
                <tbody>
                 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  var table;

  $(document).ready(function() {
    table = $('#datatable-sale').DataTable({
      "ajax": {
        "url": "<?php echo site_url('transaction/sale/fetch_all') ?>",
        "type": "GET",
      },
      "columns": [
        {"data": "id"},
        {"data": "customer_name"},
        {"data": "sale_date"},
        {
          "data": "sale_total", 
          "render": function(data, type, row) {
            return rupiah(data)
          }
        },
        {
          "data": null,
          "render": function(data, type, row) {
            return `<div class="btn-group" role="group">
            <button type="button" class="btn btn-icon btn-info btn-detail" data-id="${data.id}"><i class="fa fa-eye"></i></button> 
            <button type="button" class="btn btn-icon btn-warning btn-edit" data-id="${data.id}"><i class="fa fa-pencil-alt"></i></button> 
            <button type="button" class="btn btn-icon btn-danger btn-delete" data-id="${data.id}"><i class="fa fa-trash"></i></button>
            </div>`
          }
        },
      ]
    })

    $('#datatable-sale tbody').on('click', '.btn-detail', function() {
      $('#datatable-detail').DataTable().clear().destroy()
      $('#modalDetail').modal('show')
      var id = $(this).data('id')

      $('#datatable-detail').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "lengthChange": false,
        "ajax": {
          "url": "<?php echo site_url('transaction/sale/show') ?>",
          "type": "POST",
          "data": function(d) {
            d.id = id
          },
        },
        "columns": [
          {"data": "id"},
          {
            "data": null,
            "render": function(data, type, row) {
              return data.id_service === null ? "item" : "service"
            }
          },
          {
            "data": null,
            "render": function(data, type, row) {
              return data.id_service === null ? data.item_name : data.service_name
            }
          },
          {"data": "amount"},
          {
            "data": "subtotal", 
            "render": function(data, type, row) {
              return rupiah(data)
            }
          }
        ]
      })
    })

    $('.btn-next').on('click', function() {
      $('#modalSale .modal-dialog').addClass('modal-xl')
      $('#step1').hide()
      $('#step2').show()
    })

    
    $('.btn-prev').on('click', function() {
      $('#modalSale .modal-dialog').removeClass('modal-xl')
      $('#step1').show()
      $('#step2').hide()
    })

    function updateRowNumbers() {
      $('#table-add-detail').DataTable().$('tr').each(function(index) {
        $(this).find('td:first').html(index + 1)
      })
    }

    var selectType = `<div class="form-group">
                        <select name="type[]" class="form-control type">
                          <option value="" disabled selected>-- Select Type --</option>
                          <option value="service">Service</option>
                          <option value="item">Item</option>
                        </select>
                      </div>`
                      
    var nameSale = `<div class="form-group">
                      <select disabled name="name[]" class="form-control name">
                        <option value="" disabled selected>-- Select Name --</option>
                      </select>
                    </div>`

    var priceSale = `<p class="text-success price">0</p>`

    var quantitySale = `<div class="form-group">
                          <input disabled type="text" value="0" class="form-control quantity">
                        </div>`

    var subtotal = `<p data-subtotal="0" class="text-success subtotal">0</p>`

    var buttonDelete = `<button type="button" class="btn btn-icon btn-danger btn-remove-row"><i class="fa fa-trash"></i></button>`

    var deletedRows = []

    $('.btn-add-row').click(function() {
      $('#table-add-detail').dataTable().fnAddData([
        '',
        selectType,
        nameSale,
        priceSale,
        quantitySale,
        subtotal,
        buttonDelete
      ])
      updateRowNumbers()
    })

    $('#table-add-detail tbody').on('click', '.btn-remove-row', function() {
      var row = $(this).closest('tr')
      var id = row.find('.subtotal').data('id')
      if(id) deletedRows.push(id)
      $('#table-add-detail').dataTable().fnDeleteRow(row[0])
      
      updateRowNumbers()
    })

    $('#table-add-detail tbody').on('change', '.type', function() {
      let type = $(this).val()
      let name = $(this).closest('tr').find('.name')
      $(this).closest('tr').find('.price').text(0)
      $(this).closest('tr').find('input.quantity').val(0)
      $(this).closest('tr').find('.subtotal').text(0)
      $(this).closest('tr').find('.subtotal').attr('data-subtotal', 0)

      $.ajax({
        url: "<?php echo site_url('transaction/sale/fetch_data') ?>",
        type: "POST",
        data: { type: type },
        dataType: "JSON",
        success: function(response) {
          name.empty()
          name.append('<option value="" disabled selected>-- Select Name --</option>')

          $.each(response, function(index, value) {
            name.attr('disabled', false)
            name.append(`<option data-price="${value.price ? value.price : value.selling_price}" value="${value.id}">${value.name}</option>`)
          })
        }
      })
    })

    function calculateSubtotal(element, quantity, price){
      let subtotal = parseInt(quantity) * parseInt(price)
      let format = rupiah(subtotal)

      if(isNaN(quantity) || quantity < 1) {
        $(element).closest('tr').find('.subtotal').text(0)
      } else {
        $(element).closest('tr').find('.subtotal').text(format)
        $(element).closest('tr').find('.subtotal').data('subtotal', subtotal)
      }
    }

    $('#table-add-detail tbody').on('change', '.name', function() {
      let price = $(this).find('option:selected').data('price')
      let quantity = $(this).closest('tr').find('.quantity').val()
      let format = rupiah(price)
      $(this).closest('tr').find('.quantity').attr('disabled', false)
      $(this).closest('tr').find('.price').text(format)
      calculateSubtotal(this, quantity, price)
    })

    $('#table-add-detail tbody').on('input', '.quantity', function() {
      let quantity = $(this).val()
      let price = $(this).closest('tr').find('.name option:selected').data('price')
      
      calculateSubtotal(this, quantity, price)
    })

    $('.btn-add').click(function() {
      $('#table-add-detail').DataTable().clear().destroy();
      $('#table-add-detail').DataTable({
        paging: false,
        searching: false,
        info: false,
        lengthChange: false
      })
      $('#formSale .form-group').removeClass('has-error has-feedback');
      $('#formSale .form-text').text('')
      $('#modalSale').modal('show')
      $('#modalTitle').text('Form Add Transaction Sale')

      $('#id').val("")
      $('#customer').val("")
      $('#sale_date').val("")
    })

    $('.btn-save').click(function() {
      var id = $('#id').val()
      var customer = $('#customer').val()
      var sale_date = $('#sale_date').val()
      var transaction = []
      var sale_total = 0

      $('#table-add-detail tbody tr').each(function() {
        var id_detail = $(this).find('.subtotal').data('id') ? $(this).find('.subtotal').data('id') : null 
        var type = $(this).find('select.type').val()
        var name = $(this).find('select.name').val()
        var quantity = $(this).find('input.quantity').val()
        var subtotal = $(this).find('.subtotal').data('subtotal')
        sale_total += parseInt(subtotal)
        
        transaction.push({ id_detail, type, name, quantity, subtotal })
      })
      
      if(id) {
        $.ajax({
          url: "<?php echo site_url('transaction/sale/update') ?>",
          type: "POST",
          dataType: "JSON",
          data: { id, customer, sale_date, sale_total, transaction, deletedRows },
          success: function(response) {
            deletedRows = [];
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalSale').modal('hide')
              swal({
                title: "Success!",
                text: "Transaction updated successfully!",
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
          url: "<?php echo site_url('transaction/sale/insert') ?>",
          type: "POST",
          dataType: "JSON",
          data: { customer, sale_date, sale_total, transaction },
          success: function(response) {
            if(response.status === 'error') {
              showErrors(response.errors)
            } else {
              table.ajax.reload()
              $('#modalSale').modal('hide')
              swal({
                title: "Success!",
                text: "Transaction created successfully!",
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

    $('#datatable-sale tbody').on('click', '.btn-edit', function() {
      $('#formSale')[0].reset()
      $('#formSale .form-group').removeClass('has-error has-feedback');
      $('#formSale .form-text').text('')

      var id = $(this).data('id');
      $.ajax({
          url: "<?php echo site_url('transaction/sale/edit/') ?>" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
              $('#id').val(data.sale.id);
              $('#customer').val(data.sale.id_customer);
              $('#sale_date').val(data.sale.sale_date);

              $('#table-add-detail').DataTable().clear().destroy();
              $('#table-add-detail').DataTable({
                paging: false,
                searching: false,
                info: false,
                lengthChange: false
              })

              $.each(data.detail, function(index, detail) {
                  var editType = detail.id_service !== null ? "service" : "item";

                  var options = '';
                  $.each(data.type, function(i, value) {
                      options += `
                        <option data-price="${value.selling_price !== null ? value.selling_price : value.price}" value="${value.id}"
                          ${((editType === 'service' && value.id === detail.id_service) || (editType === 'item' && value.id === detail.id_item)) ? 'selected' : ''}>
                          ${value.name}
                        </option>`;
                  });

                  $('#table-add-detail').dataTable().fnAddData([
                      '',
                      `<div class="form-group">
                        <select name="type[]" class="form-control type">
                          <option value="" disabled>-- Select Type --</option>
                          <option ${detail.id_service !== null ? 'selected' : ''} value="service">Service</option>
                          <option ${detail.id_item !== null ? 'selected' : ''} value="item">Item</option>
                        </select>
                      </div>`,
                      `<div class="form-group">
                        <select disabled name="name[]" class="form-control name">
                          <option data-price="${detail.service_price !== null ? detail.service_price : detail.item_price}" value="${detail.id_item ? detail.id_item : detail.id_service}" selected>${detail.item_name ? detail.item_name : detail.service_name}</option>
                        </select>
                      </div>`,
                      `<p class="text-success price">
                        ${rupiah(detail.service_price !== null ? detail.service_price : detail.item_price)}
                      </p>`,
                      `<div class="form-group">
                        <input type="text" value="${detail.amount}" class="form-control quantity">
                      </div>`,
                      `<p data-id="${detail.id}" data-subtotal="${detail.subtotal}" class="text-success subtotal">${rupiah(detail.subtotal)}</p>`,
                      `<button type="button" class="btn btn-icon btn-danger btn-remove-row"><i class="fa fa-trash"></i></button>`
                  ]);

                  updateRowNumbers();
              });

              $('#modalTitle').text('Form Edit User');
              $('#modalSale').modal('show');
          }
      });

    })

    $('#datatable-sale tbody').on('click', '.btn-delete', function() {
      var id = $(this).data('id')
      swal({
        title: "Are you sure?",
        text: "You want delete this user?",
        icon: "warning",
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
            url: "<?php echo site_url('transaction/sale/destroy/') ?>"+id,
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