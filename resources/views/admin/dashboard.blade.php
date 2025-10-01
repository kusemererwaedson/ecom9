@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ Auth::guard('admin')->user()->name }}</h3>
                        <h6 class="font-weight-normal mb-0">All systems are running smoothly!</h6>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today ({{ date('d M Y') }})
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Total Sections</p>
                                <p class="fs-30 mb-2">{{$sectionsCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Categories</p>
                                <p class="fs-30 mb-2">{{$categoriesCount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Products</p>
                                <p class="fs-30 mb-2">{{$productsCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Total Brands</p>
                                <p class="fs-30 mb-2">{{$brandsCount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Total Orders</p>
                                <p class="fs-30 mb-2">{{$ordersCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Coupons</p>
                                <p class="fs-30 mb-2">{{$couponsCount}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Users</p>
                                <p class="fs-30 mb-2">{{$usersCount}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-4">Total Subscribers</p>
                                <p class="fs-30 mb-2">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div class="row">
            <!-- Monthly Orders Chart -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Monthly Orders</h4>
                        <canvas id="monthlyOrdersChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Order Status Pie Chart -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Status Distribution</h4>
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Second Charts Row -->
        <div class="row">
            <!-- Monthly Revenue Chart -->
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Monthly Revenue</h4>
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Top Products -->
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Top Products</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach($topProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td class="text-right">{{ $product->orders_count }} orders</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Analytics Cards -->
        <div class="row">
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Sales Analytics</h4>
                        <canvas id="salesDonutChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Performance Overview</h4>
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    @include('admin.layout.footer')
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Prepare data
const monthlyOrders = @json($monthlyOrders);
const monthlyRevenue = @json($monthlyRevenue);
const orderStatus = @json($orderStatus);

// Fill missing months with 0
const monthlyOrdersData = [];
const monthlyRevenueData = [];
for(let i = 1; i <= 12; i++) {
    monthlyOrdersData.push(monthlyOrders[i] || 0);
    monthlyRevenueData.push(monthlyRevenue[i] || 0);
}

// Monthly Orders Chart
const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
new Chart(monthlyOrdersCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Orders',
            data: monthlyOrdersData,
            borderColor: '#4B49AC',
            backgroundColor: 'rgba(75, 73, 172, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

// Order Status Pie Chart
const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(orderStatusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(orderStatus),
        datasets: [{
            data: Object.values(orderStatus),
            backgroundColor: ['#4B49AC', '#7DA0FA', '#98BDFF', '#F3797E', '#FFC100']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Monthly Revenue Chart
const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
new Chart(monthlyRevenueCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Revenue (UGX)',
            data: monthlyRevenueData,
            backgroundColor: 'rgba(75, 73, 172, 0.8)',
            borderColor: '#4B49AC',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

// Sales Donut Chart
const salesDonutCtx = document.getElementById('salesDonutChart').getContext('2d');
new Chart(salesDonutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Products', 'Categories', 'Brands'],
        datasets: [{
            data: [{{ $productsCount }}, {{ $categoriesCount }}, {{ $brandsCount }}],
            backgroundColor: ['#4B49AC', '#7DA0FA', '#98BDFF']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Performance Chart
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
new Chart(performanceCtx, {
    type: 'radar',
    data: {
        labels: ['Orders', 'Users', 'Products', 'Categories', 'Brands', 'Coupons'],
        datasets: [{
            label: 'Performance',
            data: [{{ $ordersCount }}, {{ $usersCount }}, {{ $productsCount }}, {{ $categoriesCount }}, {{ $brandsCount }}, {{ $couponsCount }}],
            borderColor: '#4B49AC',
            backgroundColor: 'rgba(75, 73, 172, 0.2)',
            pointBackgroundColor: '#4B49AC'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { r: { beginAtZero: true } }
    }
});
</script>
@endsection