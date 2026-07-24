<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - Analytics Portal</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            
            background: linear-gradient(135deg, #0d94edff, #2114d9ff);

            color: #333;
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
        .bg-gradient-primary { background: linear-gradient(135deg, #667eea, #cb31f6ff); color: white; }
        .bg-gradient-info { background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; }
        .bg-gradient-success { background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; }
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

        .btn-modern {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
        }
        .input-modern {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .input-modern:focus {
            box-shadow: 0 0 0 0.25rem rgba(54, 209, 220, 0.25);
            border-color: #36d1dc;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom mb-5">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-graph-up-arrow me-2"></i>Analytics Portal</a>
            <div class="d-flex align-items-center text-white nav-text">
                <span class="me-4"><i class="bi bi-person-workspace me-1"></i> Faculty: {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light text-primary rounded-pill px-3 fw-bold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">Subject: {{ $subject->name }}</h3>
            <span class="text-muted"><i class="bi bi-calendar3 me-1"></i> Academic Year 2025-2026</span>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-primary mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Total Students</h6>
                        <h2 class="mb-0 fw-bold">{{ $analytics['total_students'] }}</h2>
                        <i class="bi bi-people stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-info mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Average Marks</h6>
                        <h2 class="mb-0 fw-bold" id="avg-marks">{{ $analytics['average'] }}</h2>
                        <i class="bi bi-percent stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-success mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Highest Marks</h6>
                        <h2 class="mb-0 fw-bold" id="high-marks">{{ $analytics['highest'] }}</h2>
                        <i class="bi bi-trophy stat-icon text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-gradient-warning mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase fw-bold opacity-75">Pass Rate</h6>
                        <h2 class="mb-0 fw-bold" id="pass-rate">{{ $analytics['total_students'] > 0 ? round(($analytics['passed'] / $analytics['total_students']) * 100) : 0 }}%</h2>
                        <i class="bi bi-graph-up stat-icon text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card table-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-columns-reverse me-2 text-primary"></i>Student List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive p-3">
                            <table class="table table-hover mb-0" id="studentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Roll No</th>
                                        <th>Name</th>
                                        <th>Marks</th>
                                        <th>Status</th>
                                        <th class="pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $result->student->roll_number }}</td>
                                        <td>{{ $result->student->user->name }}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm input-modern" id="marks-{{ $result->id }}" value="{{ $result->marks }}" min="0" max="100" style="width: 80px;">
                                        </td>
                                        <td>
                                            <span class="badge badge-pill {{ $result->marks >= 40 ? 'bg-success' : 'bg-danger' }}" id="status-{{ $result->id }}">
                                                {{ $result->marks >= 40 ? 'Pass' : 'Fail' }}
                                            </span>
                                        </td>
                                        <td class="pe-4 d-flex align-items-center">
                                            <button class="btn btn-sm btn-primary btn-modern update-btn" data-id="{{ $result->id }}">Update</button>
                                            <span class="text-success ms-2 d-none fw-medium small" id="msg-{{ $result->id }}"><i class="bi bi-check-circle-fill"></i> Saved</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card table-card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Analytics</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center p-4">
                        <div style="position: relative; height:300px; width:100%">
                            <canvas id="passFailChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            $('#studentsTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Search Student:"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [2, 4] } // Disable sorting on Marks input and Action column
                ]
            });

            const ctx = document.getElementById('passFailChart').getContext('2d');
            let passFailChart = new Chart(ctx, {
                type: 'doughnut', // changed to doughnut for modern look
                data: {
                    labels: ['Passed', 'Failed'],
                    datasets: [{
                        data: [{{ $analytics['passed'] }}, {{ $analytics['failed'] }}],
                        backgroundColor: ['#43e97b', '#ff0844'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    cutout: '70%'
                }
            });

            const updateButtons = document.querySelectorAll('.update-btn');
            updateButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const marks = document.getElementById('marks-' + id).value;
                    const msg = document.getElementById('msg-' + id);
                    const statusBadge = document.getElementById('status-' + id);

                    msg.classList.add('d-none');
                    this.disabled = true;

                    fetch("{{ route('faculty.updateMarks') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ result_id: id, marks: marks })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.disabled = false;
                        if(data.success) {
                            msg.classList.remove('d-none');
                            setTimeout(() => msg.classList.add('d-none'), 2000);
                            
                            if (marks >= 40) {
                                statusBadge.className = 'badge badge-pill bg-success';
                                statusBadge.textContent = 'Pass';
                            } else {
                                statusBadge.className = 'badge badge-pill bg-danger';
                                statusBadge.textContent = 'Fail';
                            }

                            document.getElementById('avg-marks').textContent = data.analytics.average;
                            document.getElementById('high-marks').textContent = data.analytics.highest;
                            
                            const passRate = data.analytics.passed + data.analytics.failed > 0 
                                ? Math.round((data.analytics.passed / (data.analytics.passed + data.analytics.failed)) * 100) 
                                : 0;
                            document.getElementById('pass-rate').textContent = passRate + '%';

                            passFailChart.data.datasets[0].data = [data.analytics.passed, data.analytics.failed];
                            passFailChart.update();
                        }
                    })
                    .catch(error => {
                        this.disabled = false;
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</body>
</html>
