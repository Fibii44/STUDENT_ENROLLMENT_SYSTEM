@extends('layouts.dashboardTemplate')

@section('title', 'Student Info')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-details"></i>
            </span>
            Student Information
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students') }}">Students</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Details</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Student Profile Card -->
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

        <!-- Student Details Card -->
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
                                <label class="text-muted mb-1">Year Level</label>
                                <p class="font-weight-bold">{{ $student->year }}st Year</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted mb-1">Course</label>
                                <p class="font-weight-bold">{{ $student->course }}</p>
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

    <!-- Academic Records -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Academic Records</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#enrollmentModal">
                        <i class="mdi mdi-plus me-2"></i>Enroll Subject
                    </button>
                </div>
                    @if($student->subjects->isEmpty())
                        <div class="text-center py-5">
                            <i class="mdi mdi-book-open-page-variant text-muted" style="font-size: 48px;"></i>
                            <p class="mt-3 text-muted">No subjects enrolled at the moment.</p>
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enrollments as $enrollment)
                                            <tr>
                                                <td>{{ $enrollment->subject->subject_code }}</td>
                                                <td>{{ $enrollment->subject->subject_name }}</td>
                                                <td>
                                                        @php $firstGrade = optional($enrollment->grades->first())->grade; @endphp
                                                        @if($firstGrade)
                                                            <span class="font-weight-bold 
                                                                @if($firstGrade <= 3.0) text-success 
                                                                @elseif($firstGrade > 3.0) text-danger 
                                                                @endif">
                                                                {{ $firstGrade }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Not yet graded</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php $firstGrade = optional($enrollment->grades->first())->grade; @endphp
                                                        @if($firstGrade === "Not Yet Graded")
                                                            <span class="badge bg-warning">PENDING</span>
                                                        @elseif($firstGrade !== null && $firstGrade <= 3.0)
                                                            <span class="badge bg-success">PASSED</span>
                                                        @elseif($firstGrade !== null && $firstGrade > 3.0)
                                                            <span class="badge bg-danger">FAILED</span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 0.5rem">
                                                        <button type="button" 
                                                                class="btn btn-gradient-warning btn-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#selectActionModal{{ $enrollment->id }}">
                                                            <i class="mdi mdi-pencil-outline"></i>
                                                        </button>
                                                        
                                                        <form action="{{ route('enrollment.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" 
                                                                class="btn btn-gradient-danger btn-sm" 
                                                                onclick="confirmDelete({{ $enrollment->id }})">
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="mdi mdi-alert-circle-outline text-muted mb-2" style="font-size: 24px;"></i>
                                                        <p class="text-muted mb-0">No subjects enrolled yet</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollmentModalLabel">Enroll Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('enrollment.store', ['id' => $student->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="subject_id" class="form-label">Select Subject</label>
                    <select class="form-select" id="subject_id" name="subject_id" required>
                        <option value="">Choose a subject...</option>
                        @foreach($availableSubjects ?? [] as $subject)
                            @if($subject->year == $student->year)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_code }} - {{ $subject->subject_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                    <div class="form-group">
                            <label for="semester">Semester</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                <option value="First">First Semester</option>
                                <option value="Second">Second Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary">Enroll</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($enrollments->isNotEmpty())
@foreach($enrollments as $enrollment)
<!-- Edit Enrollment Modal -->
<div class="modal fade" id="editEnrollmentModal{{ $enrollment->id }}" tabindex="-1" aria-labelledby="editEnrollmentModalLabel{{ $enrollment->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEnrollmentModalLabel{{ $enrollment->id }}">Edit Enrollment & Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Enrollment Form -->
                <form action="{{ route('enrollment.update', $enrollment->id) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3">
                        <label for="subject_id" class="form-label">Select Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="{{ $enrollment->subject_id }}">{{ $enrollment->subject->subject_code }} - {{ $enrollment->subject->subject_name }} (Current)</option>
                            @foreach($availableSubjects ?? [] as $subject)
                                @if($subject->id != $enrollment->subject_id)
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->subject_code }} - {{ $subject->subject_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="First" {{ $enrollment->semester == 'First' ? 'selected' : '' }}>First Semester</option>
                            <option value="Second" {{ $enrollment->semester == 'Second' ? 'selected' : '' }}>Second Semester</option>
                            <option value="Summer" {{ $enrollment->semester == 'Summer' ? 'selected' : '' }}>Summer</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-warning">Update Enrollment</button>
                    </div>
                </form>

                <hr>

               
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editGradeModal{{ $enrollment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('grade.update', $enrollment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3">
                        <label for="grade" class="form-label">Grade</label>
                        <select class="form-select" id="grade" name="grade" required>
                            <option value="">Select Grade</option>
                            <option value="1.00" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '1.00' ? 'selected' : '' }}>1.00</option>
                            <option value="1.25" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '1.25' ? 'selected' : '' }}>1.25</option>
                            <option value="1.50" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '1.50' ? 'selected' : '' }}>1.50</option>
                            <option value="1.75" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '1.75' ? 'selected' : '' }}>1.75</option>
                            <option value="2.00" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '2.00' ? 'selected' : '' }}>2.00</option>
                            <option value="2.25" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '2.25' ? 'selected' : '' }}>2.25</option>
                            <option value="2.50" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '2.50' ? 'selected' : '' }}>2.50</option>
                            <option value="2.75" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '2.75' ? 'selected' : '' }}>2.75</option>
                            <option value="3.00" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '3.00' ? 'selected' : '' }}>3.00</option>
                            <option value="5.00" {{ isset($enrollment->grades->first()->grade) && $enrollment->grades->first()->grade == '5.00' ? 'selected' : '' }}>5.00</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-warning">Update Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Selection modal -->
<div class="modal fade" id="selectActionModal{{ $enrollment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn btn-gradient-primary" 
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal" 
                            data-bs-target="#editEnrollmentModal{{ $enrollment->id }}">
                        Edit Enrollment
                    </button>
                    <button type="button" 
                            class="btn btn-gradient-info" 
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal" 
                            data-bs-target="#editGradeModal{{ $enrollment->id }}">
                        Edit Grade
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
@endif

<!-- Delete modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this enrollment?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-gradient-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this script section -->
<script>
    function confirmDelete(enrollmentId) {
        const modal = document.getElementById('deleteConfirmationModal');
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = "{{ route('enrollment.destroy', '') }}/" + enrollmentId;
        
        new bootstrap.Modal(modal).show();
    }
</script>


<style>
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