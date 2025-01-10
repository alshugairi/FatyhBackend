@extends('admin.layouts.app')

@section('content')

    <div class="app-content mt-4">
        <div class="container-fluid">
            <h4 class="mb-3 fw-bold">
                <span class="text-warning">Good Evening:</span>
                <span class="text-dark">{{ auth()->user()->name }}</span>
            </h4>

            @include('admin.partial.dashboard.shimmer')

            <div class="page-data" style="display: none">
                <div class="row mb-3"> <!--begin::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3 id="orders_count">0</h3>
                                <p>Total Orders</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                            </svg>
                        </div> <!--end::Small Box Widget 1-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3 id="earnings_count">0</h3>
                                <p>Total Earnings</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                            </svg>
                        </div> <!--end::Small Box Widget 2-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3 id="clients_count">0</h3>
                                <p>Total Clients</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                            </svg>
                        </div> <!--end::Small Box Widget 3-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3 id="products_count">0</h3>
                                <p>Total Products</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                            </svg>
                        </div> <!--end::Small Box Widget 4-->
                    </div> <!--end::Col-->
                </div>

                <h5 class="mb-3 fw-bold">Orders</h5>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm"><i class="bi bi-gear-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Orders</span> <span class="info-box-number" id="orders_count2">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm"> <i class="bi bi-hand-thumbs-up-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pending</span> <span class="info-box-number" id="pending_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm"> <i class="bi bi-cart-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Processing</span> <span class="info-box-number" id="processing_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">On hold</span> <span class="info-box-number" id="on_hold_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm"><i class="bi bi-gear-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Shipped</span> <span class="info-box-number" id="shipped_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm"> <i class="bi bi-hand-thumbs-up-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Delivered</span> <span class="info-box-number" id="delivered_count">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm"> <i class="bi bi-cart-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Returned</span> <span class="info-box-number" id="refunded_count">760</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cancelled</span> <span class="info-box-number" id="cancelled_count">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Sales Summary Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Sales Summary</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Summary Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Orders Summary</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="ordersChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Customer Stats Chart -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Customer Stats</h3>
                                <div class="card-tools">
                                    <input type="text" class="form-control" style="width: 200px;" placeholder="Select Date Range">
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="customerStatsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Top Customers -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Top Customers</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Customer 1 -->
                                    <div class="col-6">
                                        <div class="border rounded-3 p-3 text-center">
                                            <img src="{{ asset('assets/admin') }}/images/avatar.png" class="rounded-circle mb-2 height-70" alt="Customer">
                                            <h6 class="mb-1">Will Smith</h6>
                                            <div class="bg-primary text-white rounded-pill py-1">3 Orders</div>
                                        </div>
                                    </div>
                                    <!-- Customer 2 -->
                                    <div class="col-6">
                                        <div class="border rounded-3 p-3 text-center">
                                            <img src="{{ asset('assets/admin') }}/images/avatar.png" class="rounded-circle mb-2 height-70" alt="Customer">
                                            <h6 class="mb-1">Walking Customer</h6>
                                            <div class="bg-primary text-white rounded-pill py-1">2 Orders</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        // Orders Summary Pie Chart

        function getLast30Days() {
            const days = [];
            const data = [];
            for (let i = 29; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                days.push(date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                }));
                // Generate random data between 5 and 25 for demonstration
                data.push(Math.floor(Math.random() * 20) + 5);
            }
            return { days, data };
        }

        // Get the data
        const { days, data } = getLast30Days();

        // Customer Stats Chart
        const customerStatsCtx = document.getElementById('customerStatsChart').getContext('2d');
        const customerStatsChart = new Chart(customerStatsCtx, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: 'Customer Activity',
                    data: data,
                    backgroundColor: 'rgba(94, 62, 255, 0.8)',
                    borderColor: 'rgba(94, 62, 255, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    maxBarThickness: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} Customers`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 5
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>

    <script>
        function loadData() {
            $('.shimmer-container').show();
            $.ajax({
                url: '{{ route("admin.dashboard.loadData") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response, status, xhr) {
                    var data = response.data
                    if (xhr.status === 200) {
                        $('#orders_count,#orders_count2').text(data.counts.orders_count);
                        $('#clients_count').text(data.counts.clients_count);
                        $('#products_count').text(data.counts.products_count);

                        $('#pending_count').text(data.orders_by_status.pending_count);
                        $('#processing_count').text(data.orders_by_status.processing_count);
                        $('#on_hold_count').text(data.orders_by_status.on_hold_count);
                        $('#shipped_count').text(data.orders_by_status.shipped_count);
                        $('#delivered_count').text(data.orders_by_status.delivered_count);
                        $('#cancelled_count').text(data.orders_by_status.cancelled_count);
                        $('#refunded_count').text(data.orders_by_status.refunded_count);
                    }
                    const statusValues = [
                        data.orders_by_status.pending_count,
                        data.orders_by_status.processing_count,
                        data.orders_by_status.on_hold_count,
                        data.orders_by_status.shipped_count,
                        data.orders_by_status.delivered_count,
                        data.orders_by_status.refunded_count,
                        data.orders_by_status.cancelled_count
                    ];
                    orderStatusesChart(statusValues);
                    salesChart(data.monthly_sales.labels, data.monthly_sales.values);
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.statusText);
                },
                complete: function() {
                    $('.shimmer-container').hide();
                    $('.page-data').show();
                }
            });
        }

        function orderStatusesChart(statuses)
        {
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'pie',
                data: {
                    labels: ['Pending', 'Processing', 'On hold', 'Shipped', 'Delivered', 'Returned', 'Cancelled'],
                    datasets: [{
                        data: statuses,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(201, 203, 207, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 20,
                                boxWidth: 12
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                                    const percentage = ((value * 100) / total).toFixed(1);
                                    return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        function salesChart(labels, values)
        {
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales ($)',
                        data: values,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        loadData()
    </script>
@endpush

