<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Dashboard</h6>
  <ul class="d-flex align-items-center gap-2">
    <li class="fw-medium">
      <a href="javascript:void()" class="d-flex align-items-center gap-1 hover-text-primary">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li>-</li>
    <li class="fw-medium">SIMPORA</li>
  </ul>
</div>

<?php if (session()->getFlashdata('welcome')) : ?>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast" class="toast shadow-lg border-0 rounded-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="6500">
      <div class="toast-header bg-primary-500 text-white rounded-top-3">
        <i class="bi bi-person-check me-2"></i>
        <strong class="me-auto">Login Berhasil</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <?= session()->getFlashdata('welcome'); ?>
      </div>
    </div>
  </div>

  <script>
    const toastEl = document.getElementById('toast');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  </script>
<?php endif; ?>


<div class="row gy-4 mb-24">
  <!-- ======================= First Row Cards Start =================== -->
  <div class="col-xxl-8">
    <div class="card h-100 radius-8 border-0 p-20">
      <div class="row gy-4">
        <div class="col-xxl-12">
          <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 mb-12">
            <div class="card-body p-0">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                  <span
                    class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                    <i class="ri-team-fill"></i>
                  </span>
                  <div>
                    <span class="mb-0 fw-medium text-secondary-light text-lg">Total Atlet</span>
                  </div>
                </div>
                <h5 class="fw-semibold mb-0">15,000</h5>
              </div>

            </div>
          </div>
          <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-12">
            <div class="card-body p-0">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                  <span
                    class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                    <i class="ri-group-3-fill"></i>
                  </span>
                  <div>
                    <span class="mb-0 fw-medium text-secondary-light text-lg">Total Tenaga Olahraga</span>
                  </div>
                </div>
                <h5 class="fw-semibold mb-0">15,000</h5>
              </div>

            </div>
          </div>
          <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-3 mb-12">
            <div class="card-body p-0">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                  <span
                    class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                    <i class="ri-football-line"></i>
                  </span>
                  <div>
                    <span class="mb-0 fw-medium text-secondary-light text-lg">Total Cabor</span>
                  </div>
                </div>
                <h5 class="fw-semibold mb-0">15,000</h5>
              </div>

            </div>
          </div>
          <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 mb-12">
            <div class="card-body p-0">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                  <span
                    class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                    <i class="ri-football-line"></i>
                  </span>
                  <div>
                    <span class="mb-0 fw-medium text-secondary-light text-lg">Total Medali</span>
                  </div>
                </div>
                <h5 class="fw-semibold mb-0">100</h5>
              </div>

            </div>
          </div>
          <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-12">
            <div class="card-body p-0">
              <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                  <span
                    class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                    <i class="ri-football-line"></i>
                  </span>
                  <div>
                    <span class="mb-0 fw-medium text-secondary-light text-lg">Total Medali</span>
                  </div>
                </div>
                <h5 class="fw-semibold mb-0">100</h5>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xxl-4 col-md-6">
    <div class="card h-100 radius-8 border-0">
      <div class="card-body p-24 d-flex flex-column justify-content-between gap-8">
        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
          <h6 class="mb-2 fw-bold text-lg mb-0">Jumlah Atlet Per Kategori</h6>
        </div>
        <div id="userOverviewDonutChart" class="margin-16-minus y-value-left apexcharts-tooltip-z-none">
        </div>

        <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
              <span class="text-secondary-light text-sm fw-semibold">Atletik</span>
            </div>
            <span class="text-primary-light fw-bold">210 Atlet</span>
          </li>

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-warning-600"></span>
              <span class="text-secondary-light text-sm fw-semibold">Bulu Tangkis</span>
            </div>
            <span class="text-primary-light fw-bold">120 Atlet</span>
          </li>

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-success-600"></span>
              <span class="text-secondary-light text-sm fw-semibold">Basket</span>
            </div>
            <span class="text-primary-light fw-bold">96 Atlet</span>
          </li>

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-danger-600"></span>
              <span class="text-secondary-light text-sm fw-semibold">Sepak Bola</span>
            </div>
            <span class="text-primary-light fw-bold">150 Atlet</span>
          </li>

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-secondary"></span>
              <span class="text-secondary-light text-sm fw-semibold">Renang</span>
            </div>
            <span class="text-primary-light fw-bold">85 Atlet</span>
          </li>

          <li class="d-flex flex-column gap-8">
            <div class="d-flex align-items-center gap-2">
              <span class="w-12-px h-12-px rounded-circle bg-info"></span>
              <span class="text-secondary-light text-sm fw-semibold">Pencak Silat</span>
            </div>
            <span class="text-primary-light fw-bold">180 Atlet</span>
          </li>

        </ul>

      </div>
    </div>
  </div>
  <!-- ======================= First Row Cards End =================== -->

  <!-- ================== Second Row Cards End ======================= -->


  <!-- ================== Third Row Cards Start ======================= -->
  <div class="col-xxl-8">
    <div class="card h-100">
      <div class="card-header">
        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
          <h6 class="mb-2 fw-bold text-lg mb-0">Kompetisi Terkini</h6>
          <a href="javascript:void(0)"
            class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
            View All
            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
          </a>
        </div>
      </div>
      <div class="card-body p-24">
        <div class="table-responsive scroll-sm">
          <table class="table bordered-table mb-0">
            <thead>
              <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Cabor</th>
                <th scope="col">Nama</th>
                <th scope="col">Tingkat</th>
                <th scope="col">Penyelenggara</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <span class="text-secondary-light">24 Jun 2024</span>
                </td>
                <td>
                  <span class="text-secondary-light">Basket</span>
                </td>
                <td>
                  <div class="text-secondary-light">
                    <h6 class="text-md mb-0 fw-normal">Liga Perbasi Banjarnegara</h6>
                    <span class="text-sm fw-normal">Antar Sekolah</span>
                  </div>
                </td>
                <td>
                  <span class="text-secondary-light">Kabupaten</span>
                </td>
                <td>
                  <span class="text-secondary-light">PENGKAB PERBASI BANJARNEGARA</span>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="text-secondary-light">24 Jun 2024</span>
                </td>
                <td>
                  <span class="text-secondary-light">Volly</span>
                </td>
                <td>
                  <div class="text-secondary-light">
                    <h6 class="text-md mb-0 fw-normal">Liga Volly Banjarnegara</h6>
                    <span class="text-sm fw-normal">Antar Sekolah</span>
                  </div>
                </td>
                <td>
                  <span class="text-secondary-light">Kabupaten</span>
                </td>
                <td>
                  <span class="text-secondary-light">PBVSI BANJARNEGARA</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xxl-4">
    <div class="card h-100">
      <div class="card-header">
        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
          <h6 class="mb-2 fw-bold text-lg mb-0">Perolehan Medali</h6>
          <a href="javascript:void(0)"
            class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
            View All
            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
          </a>
        </div>
      </div>
      <div class="card-body p-24">
        <ul class="d-flex flex-wrap align-items-center justify-content-center my-3 gap-3">
          <li class="d-flex align-items-center gap-2">
            <span class="w-12-px h-12-px rounded-circle bg-warning-600"></span>
            <span class="text-secondary-light text-sm fw-semibold"> Emas:
              <span class="text-primary-light fw-bold">50</span>
            </span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
            <span class="text-secondary-light text-sm fw-semibold"> Perak:
              <span class="text-primary-light fw-bold">30</span>
            </span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
            <span class="text-secondary-light text-sm fw-semibold"> Perunggu:
              <span class="text-primary-light fw-bold">30</span>
            </span>
          </li>
        </ul>
        <div id="perolehanMedaliChart" class="margin-16-minus y-value-left"></div>
      </div>
    </div>
  </div>
  <!-- ================== Third Row Cards End ======================= -->

  <script>
    // ===================== Average Enrollment Rate Start =============================== 
    function createChartTwo(chartId, color1, color2) {
      var options = {
        series: [{
          name: 'series1',
          data: [48, 35, 55, 32, 48, 30, 55, 50, 57]
        }, {
          name: 'series2',
          data: [12, 20, 15, 26, 22, 60, 40, 48, 25]
        }],
        legend: {
          show: false
        },
        chart: {
          type: 'area',
          width: '100%',
          height: 270,
          toolbar: {
            show: false
          },
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 3,
          colors: [color1, color2], // Use two colors for the lines
          lineCap: 'round'
        },
        grid: {
          show: true,
          borderColor: '#D1D5DB',
          strokeDashArray: 1,
          position: 'back',
          xaxis: {
            lines: {
              show: false
            }
          },
          yaxis: {
            lines: {
              show: true
            }
          },
          row: {
            colors: undefined,
            opacity: 0.5
          },
          column: {
            colors: undefined,
            opacity: 0.5
          },
          padding: {
            top: -20,
            right: 0,
            bottom: -10,
            left: 0
          },
        },
        colors: [color1, color2], // Set color for series
        fill: {
          type: 'gradient',
          colors: [color1, color2], // Use two colors for the gradient
          // gradient: {
          //     shade: 'light',
          //     type: 'vertical',
          //     shadeIntensity: 0.5,
          //     gradientToColors: [`${color1}`, `${color2}00`], // Bottom gradient colors with transparency
          //     inverseColors: false,
          //     opacityFrom: .6,
          //     opacityTo: 0.3,
          //     stops: [0, 100],
          // },
          gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: [undefined, `${color2}00`], // Apply transparency to both colors
            inverseColors: false,
            opacityFrom: [0.4, 0.4], // Starting opacity for both colors
            opacityTo: [0.3, 0.3], // Ending opacity for both colors
            stops: [0, 100],
          },
        },
        markers: {
          colors: [color1, color2], // Use two colors for the markers
          strokeWidth: 3,
          size: 0,
          hover: {
            size: 10
          }
        },
        xaxis: {
          labels: {
            show: false
          },
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          tooltip: {
            enabled: false
          },
          labels: {
            formatter: function(value) {
              return value;
            },
            style: {
              fontSize: "14px"
            }
          }
        },
        yaxis: {
          labels: {
            formatter: function(value) {
              return "$" + value + "k";
            },
            style: {
              fontSize: "14px"
            }
          },
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          }
        }
      };

      var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
      chart.render();
    }

    createChartTwo('enrollmentChart', '#45B369', '#487fff');
    // ===================== Average Enrollment Rate End =============================== 


    // ================================ Users Overview Donut chart Start ================================ 
    var options = {
      series: [500, 500, 500, 500, 500, 500],
      colors: ['#FF9F29', '#487FFF', '#dc3545', '#6c757d', '#16A34A', '#0dcaf0'],
      labels: ['Bulu Tangkis', 'Atletik', 'Sepak Bola', 'Renang', 'Basket', 'Pencak Silat'],
      legend: {
        show: false
      },
      chart: {
        type: 'donut',
        height: 270,
        sparkline: {
          enabled: true // Remove whitespace
        },
        margin: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        }
      },
      stroke: {
        width: 0,
      },
      dataLabels: {
        enabled: false
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }],
    };

    var chart = new ApexCharts(document.querySelector("#userOverviewDonutChart"), options);
    chart.render();
    // ================================ Users Overview Donut chart End ================================ 

    // ================================ Client Payment Status chart End ================================ 
    var options = {
      series: [{
        name: 'Medali Emas',
        data: [44, 100, 40, 56, 30, 58]
      }, {
        name: 'Medali Perak',
        data: [60, 120, 60, 90, 50, 95]
      }, {
        name: 'Medali Perunggu',
        data: [44, 100, 40, 56, 30, 58]
      }],
      colors: ['#D4AF37', '#C0C0C0', '#CD7F32'],
      labels: ['Active', 'New', 'Total'],

      legend: {
        show: false
      },
      chart: {
        type: 'bar',
        height: 420,
        toolbar: {
          show: false
        },
      },
      grid: {
        show: true,
        borderColor: '#D1D5DB',
        strokeDashArray: 4, // Use a number for dashed style
        position: 'back',
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          columnWidth: 8,
        },
      },
      dataLabels: {
        enabled: false
      },
      states: {
        hover: {
          filter: {
            type: 'none'
          }
        }
      },
      stroke: {
        show: true,
        width: 0,
        colors: ['transparent']
      },
      xaxis: {
        categories: ['Bola', 'Volly', 'Bulu Tangkis', 'Renang', 'Basket', 'Silat'],
      },
      fill: {
        opacity: 1,
        width: 18,
      },
    };

    var chart = new ApexCharts(document.querySelector("#perolehanMedaliChart"), options);
    chart.render();
    // ================================ Client Payment Status chart End ================================ 

    // ================================ Aminated Radial Progress Bar Start ================================ 
    $('svg.radial-progress').each(function(index, value) {
      $(this).find($('circle.complete')).removeAttr('style');
    });

    // Activate progress animation on scroll
    $(window).scroll(function() {
      $('svg.radial-progress').each(function(index, value) {
        // Trigger when the element is fully in the viewport
        if (
          $(window).scrollTop() >= $(this).offset().top - $(window).height() &&
          $(window).scrollTop() <= $(this).offset().top + $(this).height()
        ) {
          // Get percentage of progress
          const percent = $(value).data('percentage');
          // Get radius of the svg's circle.complete
          const radius = $(this).find($('circle.complete')).attr('r');
          // Get circumference (2πr)
          const circumference = 2 * Math.PI * radius;
          // Get stroke-dashoffset value based on the percentage of the circumference
          const strokeDashOffset = circumference - ((percent * circumference) / 100);
          // Transition progress for 1.25 seconds
          $(this).find($('circle.complete')).animate({
            'stroke-dashoffset': strokeDashOffset
          }, 1250);
        }
      });
    }).trigger('scroll');
    // ================================ Aminated Radial Progress Bar End ================================ 
  </script>

  <?= $this->endSection(); ?>