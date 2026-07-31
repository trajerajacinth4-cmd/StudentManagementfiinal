<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Student App</a>
        <div class="d-flex align-items-center">
            <span class="text-light me-3">Welcome, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Log Out</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student List</h2>
        <div>
            <a href="{{ route('students.pdf') }}" class="btn btn-danger me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf me-1" viewBox="0 0 16 16">
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                    <path d="M4.603 12.087a.8.8 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.997-.757.517-.208 1.176-.367 1.944-.472A12.4 12.4 0 0 1 8.2 7.764c.328-.86.602-1.745.748-2.585.176-.995.127-1.636-.263-2.023-.198-.198-.445-.263-.687-.24-.316.03-.618.232-.825.55-.47.72-.455 1.8.06 3.018a14 14 0 0 0 .524 1.054 1.16 1.16 0 0 0-.25.596 11 11 0 0 0-.324 1.344c-.672.316-1.503.655-2.274.966-.75.303-1.423.59-1.928.847m2.327-4.135a13 13 0 0 1-.41-.832c-.374-.827-.37-1.488-.063-1.957.098-.15.228-.243.376-.254.12-.009.244.02.34.116.208.208.225.674.093 1.416a13.6 13.6 0 0 1-.336 1.517m-1.572 2.766c.28-.157.653-.346 1.077-.55a12.7 12.7 0 0 1-.806.27c-.432.126-.74.204-.954.246.083-.095.197-.193.33-.311m4.356-1.485c.296.223.57.48.81.765.25.297.417.589.476.843.054.23.01.425-.11.53-.1.088-.24.114-.37.078-.186-.052-.408-.22-.635-.49a9.6 9.6 0 0 1-.728-.996c.218-.219.405-.46.557-.73"/>
                </svg>
                Download PDF
            </a>
            <a href="{{ route('students.create') }}" class="btn btn-primary">Add New Student</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Age</th>
                        <th width="200px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->age }}</td>
                            <td>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No students found. <a href="{{ route('students.create') }}">Add one now</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $students->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
