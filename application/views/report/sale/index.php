<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Report Sales</h3>
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
            <div class="card-header d-flex align-items-center justify-content-between">
                <form action="" id="formDate" class="d-flex">
                    <div class="form-group mx-2">
                        <label for="start_date">Start Date</label>
                        <input type="datetime-local" id="start_date" name="start_date" class="form-control"/>
                    </div>
                    <div class="form-group mx-2">
                        <label for="end_date">End Date</label>
                        <input type="datetime-local" id="end_date" name="end_date" class="form-control"/>
                    </div>
                    <div class="form-group mx-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-filter">Filter</button>
                    </div>
                </form>
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="datatable"
                class="display table-head-bg-primary table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th width="20%">ID Sales</th>
                    <th width="30%">Sale Date</th>
                    <th width="25%">Customer</th>
                    <th width="25%">Sale Total</th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th width="20%">ID Sales</th>
                      <th width="30%">Sale Date</th>
                      <th width="25%">Customer</th>
                      <th width="25%">Sale Total</th>
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
        <button type="button" class="btn btn-primary btn-save">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  var table;
  var form;

  $(document).ready(function() {
    table = $('#datatable').DataTable({
      "ajax": {
        "url": "<?php echo site_url('report/sale/fetch_data') ?>",
        "type": "POST",
        "data": {start_date: null, end_date: null},
        "dataType": "JSON",
      },
      "columns": [
        {"data": "id"},
        {"data": "sale_date"},
        {"data": "customer_name"},
        {"data": "sale_total"},
      ]
    })

    $('.btn-filter').click(function() {
        let startDate = $('#start_date').val()
        let endDate = $('#end_date').val()

        $('#datatable').DataTable().clear().destroy()
        $('#datatable').DataTable({
            "ajax": {
                "url": "<?php echo site_url('report/sale/fetch_data') ?>",
                "type": "POST",
                "data": {start_date: startDate, end_date: endDate},
                "dataType": "JSON",
            },
            "columns": [
                {"data": "id"},
                {"data": "sale_date"},
                {"data": "customer_name"},
                {"data": "sale_total"},
            ]
        })
    })
  })
</script>