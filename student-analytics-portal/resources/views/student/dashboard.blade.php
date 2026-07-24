<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Analytics Portal</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d94edff, #2114d9ff);
            color: white
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand {
            font-weight: 600;
            color: #fff;
            letter-spacing: 1px;
        }
        .navbar-custom .nav-text {
            font-weight: 500;
        }

        /* Card Styling */
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            position: relative;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }
        .stat-card .card-body {
            padding: 1.5rem;
            position: relative;
            z-index: 2;
        }
        .stat-icon {
            font-size: 2.5rem;
            position: absolute;
            right: 20px;
            bottom: 10px;
            opacity: 0.2;
            z-index: 1;
        }

        /* Specific Gradients */
        .bg-gradient-primary { background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; }
        .bg-gradient-info { background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; }
        .bg-gradient-success { background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; }
        .bg-gradient-danger { background: linear-gradient(135deg, #ff0844, #ffb199); color: white; }
        .bg-gradient-warning { background: linear-gradient(135deg, #f6d365, #fda085); color: white; }
        
        /* Table Styling */
        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }
        .table-card .card-header {
            background-color: #fff;
            border-bottom: 1px solid #edf2f9;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem 1.5rem;
        }
        .table-card .card-header h5 {
            font-weight: 600;
            color: #2c3e50;
        }
        .table th {
            font-weight: 500;
            color: #6c757d;
            border-bottom-width: 1px;
        }
        .table td {
            vertical-align: middle;
        }
        
        .badge-pill {
            border-radius: 50px;
            padding: 0.4em 0.8em;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-graph-up-arrow me-2"></i>Analytics Portal</a>
            <div class="d-flex align-items-center text-white nav-text">
                <span class="me-4"><i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} ({{ $student->roll_number }})</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light text-primary rounded-pill px-3 fw-bold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">My Dashboard</h3>
            <span class="text-muted"><i class="bi bi-calendar3 me-1"></i> Academic Year 2025-2026</span>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-primary mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Total Marks</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalMarks }}</h2>
                        <i class="bi bi-award stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-info mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Average</h6>
                        <h2 class="mb-0 fw-bold">{{ $averageMarks }}%</h2>
                        <i class="bi bi-percent stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card {{ $overallStatus == 'Pass' ? 'bg-gradient-success' : 'bg-gradient-danger' }} mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Status</h6>
                        <h2 class="mb-0 fw-bold">{{ $overallStatus }}</h2>
                        <i class="bi bi-patch-check stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-warning mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Top Subject</h6>
                        <h4 class="mb-0 mt-1 fw-bold">{{ $highestSubject ? $highestSubject->subject->name : 'N/A' }}</h4>
                        <i class="bi bi-trophy stat-icon text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2 text-primary"></i>Marks Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Subject</th>
                                        <th>Marks</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $result->subject->name }}</td>
                                        <td><strong>{{ $result->marks }}</strong> / 100</td>
                                        <td>
                                            <span class="badge badge-pill {{ $result->marks >= 40 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $result->marks >= 40 ? 'Pass' : 'Fail' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card table-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Performance Graph</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center p-4">
                        <div style="position: relative; height:300px; width:100%">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            
            // Create a gradient for the chart bars
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, '#5b86e5');   
            gradient.addColorStop(1, '#36d1dc');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Marks out of 100',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: gradient,
                        borderRadius: 5,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: 100,
                            grid: {
                                color: '#f0f0f0',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
