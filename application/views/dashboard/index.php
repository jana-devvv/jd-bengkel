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
      <!-- Total Sales Today / Total Penjualan Hari Ini -->
      <div class="col-sm-6 col-lg-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <span class="stamp stamp-md bg-success me-3">
              <i class="fa fa-dollar-sign"></i>
            </span>
            <div>
              <h5 class="mb-1"><b><small>Total Sales Today</small></b></h5>
              <small class="text-muted" id="total_sales_today">0</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Number of New Customers / Jumlah Pelanggan Baru -->
      <div class="col-sm-6 col-lg-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <span class="stamp stamp-md bg-info me-3">
              <i class="fa fa-user-friends"></i>
            </span>
            <div>
              <h5 class="mb-1"><b><small>New Customers Today</small></b></h5>
              <small class="text-muted" id="number_of_new_customers">0</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Most Popular Sale / Penjualan Paling Populer -->
      <div class="col-sm-6 col-lg-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <span class="stamp stamp-md bg-secondary me-3">
              <i class="fa fa-user"></i>
            </span>
            <div>
              <h5 class="mb-1">
                <b
                  ><small>Total All User</small></b
                >
              </h5>
              <small class="text-muted" id="total_user">0</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Total Sales</div>
              <div class="card-tools">
                <a href="#" class="btn btn-label-success btn-round btn-sm me-2" >
                  <span class="btn-label"><i class="fa fa-pencil"></i></span>Export
                </a>
                <a href="#" class="btn btn-label-info btn-round btn-sm">
                  <span class="btn-label"><i class="fa fa-print"></i></span>Print
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="chart-container" style="min-height: 375px">
              <canvas id="statisticsChart"></canvas>
            </div>
            <div id="myChartLegend"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card card-round">
          <div class="card-header">                    
          </div>
          <div class="card-body pb-0">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Popular Sales</div>
              <div class="card-tools">
                <div class="dropdown">
                  <button
                    class="btn btn-sm btn-label-primary dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Export
                  </button>
                  <div
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton"
                  >
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#"
                      >Something else here</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="card-category">Item/Service</div>
          </div>
          <div class="card-body pb-0">
            <div class="mb-4 mt-2">
              <p>Popular Item / Service</p>
              <ul class="list-group list-group-flush" id="popular_sales"><span class="text-danger">No Item/Service</span></ul>
            </div>
          </div>
        </div>
        <div class="card card-round">
          <div class="card-body pb-0">
            <div class="float-end">
              <select class="form-control" id="select_item">
                <option value="" selected>-- category --</option>
              </select>
            </div>
            <h4 class="mb-4">Stock Item</h4>
            <p id="stock" class="text-muted"><span class="text-danger">No Item</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      header: { 
        left: 'prev,next',
        center: 'title',
        right: 'month,agendaWeek,agendaDay',
      }
    })

    $('#select_item').change(function() {
      let category = $('#select_item').val()
      let text = `<span class="text-danger">No Item</span>`
      $('#stock').empty()

      if(category === "") {
        $('#stock').html(text)
      }

      $.ajax({
        url: "<?php echo site_url('dashboard/total_stock') ?>",
        type: "POST",
        data: {category},
        dataType: "JSON",
        success: function(response) {
          $.each(response.data, function(index, item) {
            $('#stock').append(`${item.name} <span class="badge badge-secondary float-end">Remaining : ${item.stock}</span><br/>`)
          })
        }
      })
    })

    $.ajax({
      url: "<?php echo site_url('management/item/fetch_categories') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(response) {
        $.each(response.data, function(index, item) {
          $('#select_item').append(`<option value="${item.category}">${item.category}</option>`)
        })
      }
    })

    $.ajax({
      url: "<?php echo site_url('dashboard/total_sales_today') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#total_sales_today').text(rupiah(data.total_sales_today))
      }
    })

    $.ajax({
      url: "<?php echo site_url('dashboard/total_user') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#total_user').text(data.total)
      }
    })

    $.ajax({
      url: "<?php echo site_url('dashboard/new_customers_count') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('#number_of_new_customers').text(data.new_customers_count)
      }
    })

    $.ajax({
      url: "<?php echo site_url('dashboard/popular_sales') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(response) {
        if(response.data.length > 0) {
          $('#popular_sales').empty();
          $.each(response.data, function(index, popular) {
            let value = popular.item_name ? popular.item_name : popular.service_name
            let type = popular.item_name ? "Item" : "Service"
            $('#popular_sales').append(`<li class="list-group-item">${index + 1}. ${value} | <span class="text-info ms-1">${type}</span> <span class="badge badge-success">Total : ${popular.total_sales}</span></li>`)
          })
        }
      }
    })

    function loadChartData(year) {
      $.ajax({
        url: "<?php echo site_url('dashboard/get_sales_data') ?>",
        type: "GET",
        data: { year },
        dataType: "JSON",
        success: function(response) {
          const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
          let monthlySales = Array(12).fill(0)
          response.data.forEach(item => {
            monthlySales[item.month - 1] = item.total_sales
          })

          updateChart(monthlySales, year)
        }
      })
    }

    var ctx = document.getElementById('statisticsChart').getContext('2d');

    var salesChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [ {
          label: "Total Sales",
          borderColor: '#1527e8',
          pointBackgroundColor: 'rgba(21, 39, 232, 0.6)',
          pointRadius: 0,
          backgroundColor: 'rgba(21, 39, 232, 0.4)',
          legendColor: '#1527e8',
          fill: true,
          borderWidth: 2,
          data: []
        }]
      },
      options : {
        responsive: true, 
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          bodySpacing: 4,
          mode:"nearest",
          intersect: 0,
          position:"nearest",
          xPadding:10,
          yPadding:10,
          caretPadding:10
        },
        layout:{
          padding:{left:5,right:5,top:15,bottom:15}
        },
        scales: {
          yAxes: [{
            ticks: {
              fontStyle: "500",
              beginAtZero: false,
              maxTicksLimit: 5,
              padding: 10
            },
            gridLines: {
              drawTicks: false,
              display: false
            }
          }],
          xAxes: [{
            gridLines: {
              zeroLineColor: "transparent"
            },
            ticks: {
              padding: 10,
              fontStyle: "500"
            }
          }]
        }, 
        legendCallback: function(chart) { 
          var text = []; 
          text.push('<ul class="' + chart.id + '-legend html-legend">'); 
          for (var i = 0; i < chart.data.datasets.length; i++) { 
            text.push('<li><span style="background-color:' + chart.data.datasets[i].legendColor + '"></span>'); 
            if (chart.data.datasets[i].label) { 
              text.push(chart.data.datasets[i].label); 
            } 
            text.push('</li>'); 
          } 
          text.push('</ul>'); 
          return text.join(''); 
        }  
      }
    });

    function updateChart(data, year) {
      salesChart.data.datasets[0].data = data
      salesChart.options.plugins.title = {
        display: true,
        text: "Total Sales Year " + year,
      }
      salesChart.update()
    }

    loadChartData(new Date().getFullYear())

    var myLegendContainer = document.getElementById("myChartLegend");

    myLegendContainer.innerHTML = salesChart.generateLegend();

    var legendItems = myLegendContainer.getElementsByTagName('li');
    for (var i = 0; i < legendItems.length; i += 1) {
      legendItems[i].addEventListener("click", legendClickCallback, false);
    }
  })
</script>