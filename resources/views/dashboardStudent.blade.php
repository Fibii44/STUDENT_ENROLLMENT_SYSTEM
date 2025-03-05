@extends('layouts.dashboardTemplate')

@section('title', 'Student Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-circle"></i>
            </span>
            Student Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    
    <!-- Student Information Card -->
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-gradient-info card-img-holder text-white h-100">
                <div class="card-body">
                    <img src="{{ asset('assets/images/circle.svg') }}" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3">Student Profile</h4>
                    <h2 class="mb-5">{{ $student->name }}</h2>
                    <h6 class="card-text">{{ $student->course }} - Year {{ $student->year }}</h6>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">Personal Information</h4>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted mb-1">Email Address</label>
                                <p class="font-weight-bold">{{ $student->email }}</p>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted mb-1">Age</label>
                                <p class="font-weight-bold">{{ $student->age }} years old</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted mb-1">Year Level</label>
                                <p class="font-weight-bold">{{ $student->year }}st Year</p>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted mb-1">Address</label>
                                <p class="font-weight-bold">{{ $student->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Academic Progress -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Academic Progress</h4>
                    @if($grades->isEmpty())
                        <div class="text-center py-5">
                            <i class="mdi mdi-book-open-page-variant text-muted" style="font-size: 48px;"></i>
                            <p class="mt-3 text-muted">No grades available at the moment.</p>
                        </div>
                    @else
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                        <tr>

                                        <td>{{ $grade->enrollment->subject->subject_code ?? 'N/A' }}</td>
                                        <td>{{ $grade->enrollment->subject->subject_name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="no-edit font-weight-bold
                                                    @if($grade->grade <= 3.0) text-success 
                                                    @elseif($grade->grade > 3.0) text-danger 
                                                    @endif">
                                                    {{ $grade->grade }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($grade->grade === 'Not Yet Graded')
                                                    <span class="badge bg-warning">PENDING</span>
                                                @elseif($grade->grade <= 3.0)
                                                    <span class="badge bg-success">PASSED</span>
                                                @elseif($grade->grade > 3.0)
                                                    <span class="badge bg-danger">FAILED</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span> <!-- Handles unexpected cases -->
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const grades = document.querySelectorAll(".no-edit");

            grades.forEach((grade) => {
                const originalText = grade.innerText; // Store the original text

                setInterval(() => {
                    if (grade.innerText !== originalText) {
                        grade.innerText = originalText; // Reset if modified
                    }
                }, 500); // Check every 500ms (half a second)
            });
        });
</script>









<style>

.no-edit {
    user-select: none; /* Prevents text selection */
    pointer-events: none; /* Disables mouse interactions */
}

.info-item label {
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item p {
    margin-bottom: 0;
    font-size: 1rem;
}

.badge {
    padding: 8px 12px;
    font-weight: 500;
}

.table td, .table th {
    padding: 1rem;
    vertical-align: middle;
}

.card {
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.card-title {
    border-bottom: 2px solid #f3f3f3;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.bg-gradient-info {
    background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
}

.card-img-absolute {
    position: absolute;
    right: 0;
    bottom: 0;
    opacity: 0.1;
}
</style>
@endsection