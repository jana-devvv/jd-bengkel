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
          <div class="card-header d-md-flex justify-content-between align-items-center">
            <form action="" id="formDate" class="d-flex justify-content-center">
              <div class="form-group mx-2">
                <input type="date" id="date" name="date" class="form-control" />
              </div>
              <div class="form-group mx-2 d-flex align-items-end">
                <button type="button" class="btn btn-primary btn-filter">Filter</button>
              </div>
            </form>
            
            <div class="d-flex justify-content-center">
              <button type="button" class="btn btn-secondary btn-excel me-2">
                <span class="btn-label"><i class="fa fa-file-excel"></i></span> Export Excel
              </button>
              <button type="button" class="btn btn-danger btn-pdf">
                <span class="btn-label"><i class="fa fa-file-pdf"></i></span> Export PDF
              </button>
            </div>
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
                    <th width="35%">Sales</th>
                    <th width="35%">Expenditure</th>
                    <th width="20%">Date</th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th width="10%">ID</th>
                      <th width="35%">Sales</th>
                      <th width="35%">Expenditure</th>
                      <th width="20%">Date</th>
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
    const now = new Date()
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0')
    const day = String(now.getDate()).padStart(2, '0')

    const date = `${year}-${month}-${day}`
    let dateFilter = date;

    table = $('#datatable').DataTable({
      "ajax": {
        "url": "<?php echo site_url('report/sale/fetch_data') ?>",
        "type": "POST",
        "data": {date},
        "dataType": "JSON",
      },
      "columns": [
        {"data": "id"},
        {
          "data": "total_sales",
          "render": function(data,type,row) {
            return rupiah(data)
          }
        },
        {
          "data": "total_expenditure",
          "render": function(data,type,row) {
            return rupiah(data)
          }
        },
        {"data": "report_date"},
      ]
    })

    $('.btn-filter').click(function() {
        dateFilter = $('#date').val() ? $('#date').val() : date

        $('#datatable').DataTable().clear().destroy()
        $('#datatable').DataTable({
            "ajax": {
                "url": "<?php echo site_url('report/sale/fetch_data') ?>",
                "type": "POST",
                "data": {date: dateFilter},
                "dataType": "JSON",
            },
            "columns": [
              {"data": "id"},
              {
                "data": "total_sales",
                "render": function(data,type,row) {
                  return rupiah(data)
                }
              },
              {
                "data": "total_expenditure",
                "render": function(data,type,row) {
                  return rupiah(data)
                }
              },
              {"data": "report_date"},
            ]
        })
    })

    $('.btn-pdf').click(function() {
      window.open('<?php echo site_url('report/sale/pdf/') ?>' + dateFilter, '_blank')
    })
    
    $('.btn-excel').click(function() {
      window.open('<?php echo site_url('report/sale/excel/') ?>' + dateFilter, '_blank')
    })
  })
</script>