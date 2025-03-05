@extends('layouts.dashboardTemplate')

@section('title', 'Subjects')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-open-page-variant"></i>
            </span>
            Subject Table
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Subject Table</li>
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
                        <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#subjectModal" id="createSubjectButton">
                            + Add Subject
                        </button>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject Code</th>
                                <th>Subject Name</th>
                                <th>Course</th>
                                <th>Year</th> <!-- Added Year Column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($subjects->isEmpty())
                                <tr><td colspan="6" class="text-center">No subjects available.</td></tr>
                            @else
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->id }}</td>
                                        <td>{{ $subject->subject_code }}</td>
                                        <td>{{ $subject->subject_name }}</td>
                                        <td>{{ $subject->course }}</td>
                                        <td>{{ $subject->year }}</td> <!-- Display Year -->
                                        <td>
                                            <button class="btn btn-warning btn-sm" onclick="editSubject({{ $subject->id }})">Edit</button>
                                            <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $subject->id }})">
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
                        {{ $subjects->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Modal -->
    <div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subjectModalLabel">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="subjectForm" action="{{ route('subject.store') }}" method="POST">
                    @csrf
                    <div id="method-field"></div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="subject_code">Subject Code</label>
                            <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                        </div>
                        <div class="form-group">
                            <label for="subject_name">Subject Name</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <select class="form-control" id="course" name="course" required>
                                <option value="" disabled selected>Select a Course</option>
                                <option value="BSIT">BSIT - Information Technology</option>
                                <option value="BSCS">BSCS - Computer Science</option>
                                <option value="BSIS">BSIS - Information Systems</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <select class="form-control" id="year" name="year" required>
                                <option value="" disabled selected>Select Year</option>
                                <option value="1">First Year</option>
                                <option value="2">Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-gradient-primary">Save Subject</button>
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
                <h5 class="modal-title">Confirm Subject Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this subject? This will also delete all associated enrollments and grades.</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-gradient-danger">Delete Subject</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

// DELETE
function confirmDelete(subjectId) {
    const modal = document.getElementById('deleteConfirmationModal');
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/subjects/${subjectId}`;
    
    new bootstrap.Modal(modal).show();
}


    function editSubject(id) {
        fetch(`/subjects/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('subject_code').value = data.subject_code;
                document.getElementById('subject_name').value = data.subject_name;
                document.getElementById('course').value = data.course;

                // **Set the correct Year in the dropdown**
                let yearSelect = document.getElementById('year');
                for (let option of yearSelect.options) {
                    option.selected = option.value == data.year;
                }

                let form = document.getElementById('subjectForm');
                form.action = `/subjects/${id}`;

                document.getElementById('method-field').innerHTML = `
                    <input type="hidden" name="_method" value="PATCH">
                `;

                document.getElementById('subjectModalLabel').textContent = 'Edit Subject';
                form.querySelector('button[type="submit"]').innerText = 'Update Subject';

                var myModal = new bootstrap.Modal(document.getElementById('subjectModal'));
                myModal.show();
            })
            .catch(error => console.error('Error:', error));
    }

    // Reset form for create mode
    document.getElementById('createSubjectButton').addEventListener('click', function() {
        let form = document.getElementById('subjectForm');
        form.reset();
        form.action = '{{ route("subject.store") }}';
        document.getElementById('method-field').innerHTML = '';

        document.getElementById('subjectModalLabel').textContent = 'Add New Subject';
        form.querySelector('button[type="submit"]').innerText = 'Add New Subject';
    });
</script>

@endsection
