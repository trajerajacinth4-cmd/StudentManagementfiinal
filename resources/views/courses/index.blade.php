@extends('layouts.app')

@section('title', 'Manage Courses - Student Management')

@section('content')
<!-- Page Header -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="icon-shape-lg bg-indigo-subtle shadow-sm">
            <i class="bi bi-book-fill icon-lg"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark tracking-tight">Course Management</h2>
            <p class="text-muted small mb-0">Create, view, and manage academic courses available for student selection</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button type="button" onclick="openAddCourseModal()" class="btn btn-primary shadow-sm d-flex align-items-center gap-1.5 fw-semibold px-3">
            <i class="bi bi-plus-circle-fill icon-sm"></i> Add New Course
        </button>
    </div>
</div>

<!-- Dynamic Alert Notification Container -->
<div id="jsToastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>

<!-- Search & Statistics Bar -->
<div class="card card-custom border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center g-3">
            <div class="col-md-7 col-lg-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           id="courseSearchInput" 
                           class="form-control border-start-0 ps-0 shadow-none" 
                           placeholder="Type to search by Course Code, Name, or Description..." 
                           onkeyup="filterCourses()"
                           onsearch="filterCourses()">
                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="clearCourseSearch()" title="Clear Search">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-5 col-lg-4 text-md-end">
                <span class="badge bg-indigo-subtle text-indigo px-3 py-2 rounded-pill fs-6 fw-semibold">
                    <i class="bi bi-journal-bookmark-fill me-1"></i> Total Courses: <span id="totalCoursesCount">{{ count($courses) }}</span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Main Courses Table -->
<div class="card card-custom border-0 overflow-hidden">
    <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-secondary d-flex align-items-center gap-2">
            <i class="bi bi-list-stars text-indigo icon-md"></i> Managed Academic Courses
        </h5>
        <span class="text-muted small" id="searchResultsCount">Showing {{ count($courses) }} courses</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0" id="coursesTable">
                <thead>
                    <tr>
                        <th class="ps-4" width="80px">#</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th class="pe-4 text-end" width="160px">Actions</th>
                    </tr>
                </thead>
                <tbody id="coursesTableBody">
                    @forelse($courses as $course)
                        <tr id="courseRow-{{ $course->id }}" class="course-row">
                            <td class="ps-4 text-muted fw-bold row-index">{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-indigo-subtle text-primary font-monospace px-2.5 py-1.5 rounded-pill course-code-text">
                                    {{ $course->code }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark course-name-text">{{ $course->name }}</td>
                            <td class="text-secondary small course-desc-text">{{ $course->description ?? 'No description provided.' }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" 
                                            class="btn btn-outline-warning" 
                                            onclick="openEditCourseModal({{ $course->id }}, '{{ addslashes($course->code) }}', '{{ addslashes($course->name) }}', '{{ addslashes($course->description ?? '') }}')" 
                                            title="Edit Course">
                                        <i class="bi bi-pencil-square icon-sm"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            onclick="confirmDeleteCourse({{ $course->id }}, '{{ addslashes($course->code) }}')" 
                                            title="Delete Course">
                                        <i class="bi bi-trash-fill icon-sm"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noCoursesRow">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="icon-shape-lg bg-indigo-subtle rounded-circle mb-3 mx-auto">
                                        <i class="bi bi-book icon-xl text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No courses added yet</h5>
                                    <p class="small text-muted mb-3">Add academic courses so they can be selected when creating students.</p>
                                    <button type="button" onclick="openAddCourseModal()" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                        <i class="bi bi-plus-lg me-1 icon-sm"></i>Add Course Now
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Course Add / Edit Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-indigo text-white border-0 py-3 rounded-top-4">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="courseModalLabel">
                    <i class="bi bi-journal-plus"></i> <span id="modalTitleText">Add New Course</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="courseForm" onsubmit="saveCourse(event)" novalidate>
                @csrf
                <input type="hidden" id="courseId" name="course_id" value="">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="modal-body p-4">
                    <!-- General Error Alert -->
                    <div id="modalAlert" class="alert alert-danger d-none py-2 px-3 small rounded-3 mb-3"></div>

                    <!-- Course Code -->
                    <div class="mb-3">
                        <label for="courseCode" class="form-label fw-semibold text-secondary">
                            Course Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control rounded-3 text-uppercase font-monospace" 
                               id="courseCode" 
                               name="code" 
                               placeholder="e.g. BSCS, BSIT, BSIS" 
                               required 
                               maxlength="20">
                        <div class="invalid-feedback" id="errorCode">Please enter a unique course code.</div>
                    </div>

                    <!-- Course Name -->
                    <div class="mb-3">
                        <label for="courseName" class="form-label fw-semibold text-secondary">
                            Course Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control rounded-3" 
                               id="courseName" 
                               name="name" 
                               placeholder="e.g. Bachelor of Science in Computer Science" 
                               required 
                               maxlength="255">
                        <div class="invalid-feedback" id="errorName">Please enter the full course name.</div>
                    </div>

                    <!-- Description -->
                    <div class="mb-2">
                        <label for="courseDescription" class="form-label fw-semibold text-secondary">
                            Description <span class="text-muted small">(Optional)</span>
                        </label>
                        <textarea class="form-control rounded-3" 
                                  id="courseDescription" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Brief summary of curriculum or focus area..."></textarea>
                        <div class="invalid-feedback" id="errorDescription">Please provide a valid description.</div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveCourseBtn" class="btn btn-primary rounded-3 px-4 shadow-sm d-flex align-items-center gap-2">
                        <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="bi bi-check-circle-fill" id="saveBtnIcon"></i>
                        <span id="saveBtnText">Save Course</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4 text-center">
            <div class="modal-body p-4">
                <div class="icon-shape-lg bg-rose-subtle text-danger rounded-circle mx-auto mb-3">
                    <i class="bi bi-exclamation-triangle-fill icon-xl"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Delete Course?</h5>
                <p class="text-muted small mb-3">Are you sure you want to delete course <strong id="deleteCourseCodeText" class="text-dark"></strong>? This action cannot be undone.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-3 w-50" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-3 px-3 w-50 shadow-sm">
                        <span id="deleteBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Global JavaScript Variables & Modal Instances
    let courseModalInstance = null;
    let deleteModalInstance = null;
    let pendingDeleteId = null;

    document.addEventListener('DOMContentLoaded', function () {
        courseModalInstance = new bootstrap.Modal(document.getElementById('courseModal'));
        deleteModalInstance = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        
        // Attach click handler for confirmed delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (pendingDeleteId) {
                executeDeleteCourse(pendingDeleteId);
            }
        });
    });

    /**
     * JavaScript Function: Open Modal to Add New Course
     */
    function openAddCourseModal() {
        resetCourseForm();
        document.getElementById('modalTitleText').textContent = 'Add New Course';
        document.getElementById('courseId').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('saveBtnText').textContent = 'Save Course';
        courseModalInstance.show();
    }

    /**
     * JavaScript Function: Open Modal to Edit Existing Course
     */
    function openEditCourseModal(id, code, name, description) {
        resetCourseForm();
        document.getElementById('modalTitleText').textContent = 'Edit Course (' + code + ')';
        document.getElementById('courseId').value = id;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('courseCode').value = code;
        document.getElementById('courseName').value = name;
        document.getElementById('courseDescription').value = description;
        document.getElementById('saveBtnText').textContent = 'Update Course';
        courseModalInstance.show();
    }

    /**
     * JavaScript Function: Reset Form Inputs & Validation States
     */
    function resetCourseForm() {
        const form = document.getElementById('courseForm');
        form.reset();
        document.getElementById('modalAlert').classList.add('d-none');
        document.getElementById('modalAlert').textContent = '';

        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    }

    /**
     * JavaScript Function: Save Course via AJAX Fetch Request
     */
    async function saveCourse(event) {
        event.preventDefault();

        const form = document.getElementById('courseForm');
        const courseId = document.getElementById('courseId').value;
        const isEdit = Boolean(courseId);

        const url = isEdit ? `/courses/${courseId}` : '/courses';
        const method = isEdit ? 'PUT' : 'POST';

        const codeVal = document.getElementById('courseCode').value.trim();
        const nameVal = document.getElementById('courseName').value.trim();
        const descVal = document.getElementById('courseDescription').value.trim();

        // Client-side quick check
        let hasError = false;
        resetCourseForm();
        document.getElementById('courseCode').value = codeVal;
        document.getElementById('courseName').value = nameVal;
        document.getElementById('courseDescription').value = descVal;

        if (!codeVal) {
            markInvalid('courseCode', 'errorCode', 'Course Code is required.');
            hasError = true;
        }
        if (!nameVal) {
            markInvalid('courseName', 'errorName', 'Course Name is required.');
            hasError = true;
        }
        if (hasError) return;

        // UI Loading State
        setSaveLoading(true);

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    code: codeVal,
                    name: nameVal,
                    description: descVal
                })
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // Success: Hide Modal & Update Table dynamically
                courseModalInstance.hide();
                showToast(result.message || 'Course saved successfully!', 'success');
                
                if (isEdit) {
                    updateCourseRowInDOM(result.data);
                } else {
                    addCourseRowToDOM(result.data);
                }
                updateTotalCount();
            } else if (response.status === 422 && result.errors) {
                // Validation Error: Display inline
                displayValidationErrors(result.errors);
            } else {
                showModalAlert(result.message || 'Failed to save course. Please check inputs.');
            }
        } catch (error) {
            console.error('Error saving course:', error);
            showModalAlert('An error occurred while connecting to the server.');
        } finally {
            setSaveLoading(false);
        }
    }

    /**
     * JavaScript Function: Display Field Validation Errors
     */
    function displayValidationErrors(errors) {
        if (errors.code) {
            markInvalid('courseCode', 'errorCode', errors.code[0]);
        }
        if (errors.name) {
            markInvalid('courseName', 'errorName', errors.name[0]);
        }
        if (errors.description) {
            markInvalid('courseDescription', 'errorDescription', errors.description[0]);
        }
    }

    function markInvalid(inputId, errorDivId, message) {
        const input = document.getElementById(inputId);
        const errorDiv = document.getElementById(errorDivId);
        input.classList.add('is-invalid');
        if (errorDiv) errorDiv.textContent = message;
    }

    function showModalAlert(msg) {
        const alertBox = document.getElementById('modalAlert');
        alertBox.textContent = msg;
        alertBox.classList.remove('d-none');
    }

    function setSaveLoading(loading) {
        const btn = document.getElementById('saveCourseBtn');
        const spinner = document.getElementById('saveBtnSpinner');
        const icon = document.getElementById('saveBtnIcon');
        
        btn.disabled = loading;
        if (loading) {
            spinner.classList.remove('d-none');
            icon.classList.add('d-none');
        } else {
            spinner.classList.add('d-none');
            icon.classList.remove('d-none');
        }
    }

    /**
     * JavaScript Function: Prompt Delete Confirmation
     */
    function confirmDeleteCourse(id, code) {
        pendingDeleteId = id;
        document.getElementById('deleteCourseCodeText').textContent = code;
        deleteModalInstance.show();
    }

    /**
     * JavaScript Function: Execute Delete Course via AJAX
     */
    async function executeDeleteCourse(id) {
        const btn = document.getElementById('confirmDeleteBtn');
        const spinner = document.getElementById('deleteBtnSpinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');

        try {
            const response = await fetch(`/courses/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (response.ok && result.success) {
                deleteModalInstance.hide();
                removeCourseRowFromDOM(id);
                showToast(result.message || 'Course deleted successfully!', 'success');
                updateTotalCount();
            } else {
                showToast(result.message || 'Failed to delete course.', 'danger');
            }
        } catch (error) {
            console.error('Error deleting course:', error);
            showToast('Network error while deleting course.', 'danger');
        } finally {
            btn.disabled = false;
            spinner.classList.add('d-none');
            pendingDeleteId = null;
        }
    }

    /**
     * JavaScript Function: Dynamically Add New Row to Table
     */
    function addCourseRowToDOM(course) {
        const tbody = document.getElementById('coursesTableBody');
        const noRow = document.getElementById('noCoursesRow');
        if (noRow) noRow.remove();

        const tr = document.createElement('tr');
        tr.id = `courseRow-${course.id}`;
        tr.className = 'course-row align-middle';
        
        const descText = course.description ? escapeHtml(course.description) : 'No description provided.';
        const codeEsc = escapeHtml(course.code);
        const nameEsc = escapeHtml(course.name);

        tr.innerHTML = `
            <td class="ps-4 text-muted fw-bold row-index">#</td>
            <td>
                <span class="badge bg-indigo-subtle text-primary font-monospace px-2.5 py-1.5 rounded-pill course-code-text">
                    ${codeEsc}
                </span>
            </td>
            <td class="fw-bold text-dark course-name-text">${nameEsc}</td>
            <td class="text-secondary small course-desc-text">${descText}</td>
            <td class="pe-4 text-end">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-warning" onclick="openEditCourseModal(${course.id}, '${codeEsc.replace(/'/g, "\\'")}', '${nameEsc.replace(/'/g, "\\'")}', '${descText.replace(/'/g, "\\'")}')" title="Edit Course">
                        <i class="bi bi-pencil-square icon-sm"></i> Edit
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDeleteCourse(${course.id}, '${codeEsc.replace(/'/g, "\\'")}')" title="Delete Course">
                        <i class="bi bi-trash-fill icon-sm"></i> Delete
                    </button>
                </div>
            </td>
        `;

        tbody.prepend(tr);
        reindexRows();
    }

    /**
     * JavaScript Function: Dynamically Update Existing Row in DOM
     */
    function updateCourseRowInDOM(course) {
        const tr = document.getElementById(`courseRow-${course.id}`);
        if (!tr) return;

        const descText = course.description ? escapeHtml(course.description) : 'No description provided.';
        const codeEsc = escapeHtml(course.code);
        const nameEsc = escapeHtml(course.name);

        tr.querySelector('.course-code-text').textContent = course.code;
        tr.querySelector('.course-name-text').textContent = course.name;
        tr.querySelector('.course-desc-text').textContent = descText;

        // Update Edit button click function arguments
        const editBtn = tr.querySelector('.btn-outline-warning');
        if (editBtn) {
            editBtn.setAttribute('onclick', `openEditCourseModal(${course.id}, '${codeEsc.replace(/'/g, "\\'")}', '${nameEsc.replace(/'/g, "\\'")}', '${descText.replace(/'/g, "\\'")}')`);
        }
        const delBtn = tr.querySelector('.btn-outline-danger');
        if (delBtn) {
            delBtn.setAttribute('onclick', `confirmDeleteCourse(${course.id}, '${codeEsc.replace(/'/g, "\\'")}')`);
        }
    }

    /**
     * JavaScript Function: Remove Row from DOM with Fade Animation
     */
    function removeCourseRowFromDOM(id) {
        const tr = document.getElementById(`courseRow-${id}`);
        if (tr) {
            tr.style.transition = 'opacity 0.3s ease';
            tr.style.opacity = '0';
            setTimeout(() => {
                tr.remove();
                reindexRows();
                
                const tbody = document.getElementById('coursesTableBody');
                if (tbody.children.length === 0) {
                    tbody.innerHTML = `
                        <tr id="noCoursesRow">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <div class="icon-shape-lg bg-indigo-subtle rounded-circle mb-3 mx-auto">
                                        <i class="bi bi-book icon-xl text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">No courses added yet</h5>
                                    <p class="small text-muted mb-3">Add academic courses so they can be selected when creating students.</p>
                                    <button type="button" onclick="openAddCourseModal()" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                        <i class="bi bi-plus-lg me-1 icon-sm"></i>Add Course Now
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                }
            }, 300);
        }
    }

    /**
     * JavaScript Function: Live Client-Side Search / Filter
     */
    function filterCourses() {
        const query = document.getElementById('courseSearchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.course-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const code = row.querySelector('.course-code-text')?.textContent.toLowerCase() || '';
            const name = row.querySelector('.course-name-text')?.textContent.toLowerCase() || '';
            const desc = row.querySelector('.course-desc-text')?.textContent.toLowerCase() || '';

            if (code.includes(query) || name.includes(query) || desc.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const counter = document.getElementById('searchResultsCount');
        if (counter) {
            counter.textContent = query ? `Found ${visibleCount} matching course(s)` : `Showing ${rows.length} courses`;
        }
    }

    /**
     * JavaScript Function: Clear Search Input
     */
    function clearCourseSearch() {
        document.getElementById('courseSearchInput').value = '';
        filterCourses();
    }

    /**
     * Helper JavaScript Functions
     */
    function reindexRows() {
        const rows = document.querySelectorAll('.course-row');
        rows.forEach((row, idx) => {
            const indexCell = row.querySelector('.row-index');
            if (indexCell) indexCell.textContent = idx + 1;
        });
    }

    function updateTotalCount() {
        const rows = document.querySelectorAll('.course-row');
        const countSpan = document.getElementById('totalCoursesCount');
        if (countSpan) countSpan.textContent = rows.length;
        filterCourses();
    }

    function showToast(message, type = 'success') {
        const container = document.getElementById('jsToastContainer');
        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';

        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center ${bgClass} border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2 fs-6">
                        <i class="bi ${icon} fs-5"></i>
                        <span>${escapeHtml(message)}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', toastHtml);

        const toastEl = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();

        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>
@endpush
@endsection
