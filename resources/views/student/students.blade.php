@extends('layouts.dashboardTemplate')

@section('title', 'Students')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-details"></i>
            </span>
            Student Table
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Student Table</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#studentModal" id="createStudentButton">
                            + Add Student
                        </button>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Year</th>
                                <th>Course</th>
                                <th>Address</th>
                                <th>Has Account</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($students->isEmpty())
                                <tr><td colspan="9" class="text-center">No students found.</td></tr>
                            @else
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->age }}</td>
                                        <td>{{ $student->year }}</td>
                                        <td>{{ $student->course }}</td>
                                        <td>{{ $student->address }}</td>
                                        <td>
                                            @if($student->has_account)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- View Info Button -->
                                            <a href="{{ route('student.info', $student->id) }}" class="btn btn-primary btn-sm">View Info</a>

                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm" onclick="editStudent({{ $student->id }})">Edit</button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete({{ $student->id }})">
                                                    <i class="mdi mdi-delete"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $students->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="studentForm" action="{{ route('student.store') }}" method="POST">
                    @csrf
                    <div id="method-field"></div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Year Level</label>
                            <select class="form-control" name="year" required>
                                <option value="">Select Year Level</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select class="form-control" name="course" required>
                                <option value="BSIT">BSIT</option>
                                <option value="BSCS">BSCS</option>
                                <option value="BSIS">BSIS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-gradient-primary">Save Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


     <!-- Delete Confirmation Modal -->
     <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student?</p>
                    <p class="text-danger"><strong>This action cannot be undone.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-gradient-danger">Delete Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<script>

//Delete Confirmation Modal
function confirmDelete(studentId) {
    const modal = document.getElementById('deleteConfirmationModal');
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/students/${studentId}`;
    
    new bootstrap.Modal(modal).show();
}


function editStudent(id) {
    fetch(`/students/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('[name="name"]').value = data.name;
            document.querySelector('[name="email"]').value = data.email;
            document.querySelector('[name="age"]').value = data.age;
            document.querySelector('[name="course"]').value = data.course;
            document.querySelector('[name="address"]').value = data.address;

            // **Set the correct year in the dropdown**
            let yearSelect = document.querySelector('[name="year"]');
            for (let option of yearSelect.options) {
                option.selected = option.value == data.year;
            }

            let form = document.getElementById('studentForm');
            form.action = `/students/${id}`;
            document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';

            // **Change Modal Title to "Edit Student"**
            document.getElementById('studentModalLabel').textContent = 'Edit Student';

            var studentModal = new bootstrap.Modal(document.getElementById('studentModal'));
            studentModal.show();
        })
        .catch(error => console.error('Error fetching student data:', error));
}

document.getElementById('createStudentButton').addEventListener('click', function() {
    let form = document.getElementById('studentForm');
    form.reset();
    form.action = '{{ route("student.store") }}';
    document.getElementById('method-field').innerHTML = '';

    // **Reset Modal Title to "Add New Student"**
    document.getElementById('studentModalLabel').textContent = 'Add New Student';
});


</script>

@endsection
