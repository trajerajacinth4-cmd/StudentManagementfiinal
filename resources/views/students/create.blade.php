@extends('layouts.app')

@section('title', 'Add New Student - Student Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card card-custom border-0 overflow-hidden" id="addStudentCard">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape bg-white bg-opacity-20 text-white shadow-sm">
                        <i class="bi bi-person-plus-fill icon-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Add New Student</h4>
                        <small class="text-white opacity-75">Create a new student academic profile</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                {{-- JS alert area (errors / success) --}}
                <div id="jsAlertArea"></div>

                <form id="addStudentForm" novalidate>
                    @csrf

                    {{-- ── Avatar Preview + Upload ── --}}
                    <div class="mb-4 d-flex flex-column align-items-center">
                        <div class="position-relative mb-2">
                            <img id="avatarPreview"
                                 src="{{ asset('images/default_avatar.png') }}"
                                 alt="Avatar Preview"
                                 width="96" height="96"
                                 class="rounded-circle border border-3 shadow-sm"
                                 style="object-fit:cover; cursor:pointer; border-color:#e0d9ff !important;"
                                 onclick="document.getElementById('avatar').click()">
                            <span class="position-absolute bottom-0 end-0 rounded-circle d-flex align-items-center justify-content-center shadow"
                                  style="width:28px;height:28px;cursor:pointer;background:linear-gradient(135deg,#4f46e5,#7c3aed);"
                                  onclick="document.getElementById('avatar').click()">
                                <i class="bi bi-camera-fill text-white" style="font-size:13px;"></i>
                            </span>
                        </div>
                        <span class="form-label fw-semibold text-secondary mb-0 small">Click avatar to upload photo</span>
                        <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                        <span class="small text-muted">Optional · Max 2 MB (JPEG, PNG, WEBP)</span>
                        <div class="text-danger small mt-1" id="avatarError"></div>
                    </div>

                    {{-- ── Student Number ── --}}
                    <div class="mb-3">
                        <label for="student_number" class="form-label fw-semibold text-secondary">Student ID Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-cyan-subtle border-end-0">
                                <i class="bi bi-card-heading text-cyan icon-md"></i>
                            </span>
                            <input type="text" name="student_number" id="student_number"
                                   class="form-control"
                                   placeholder="Auto-generated if left blank (e.g. STD-2026-00100)">
                            <button type="button" class="btn btn-outline-secondary" id="generateIdBtn"
                                    title="Auto-generate a Student ID">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                <span class="d-none d-sm-inline small">Generate</span>
                            </button>
                        </div>
                        <div class="text-danger small mt-1" id="student_numberError"></div>
                    </div>

                    {{-- ── Name Row ── --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="first_name" class="form-label fw-semibold text-secondary">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0">
                                    <i class="bi bi-person text-indigo icon-md"></i>
                                </span>
                                <input type="text" name="first_name" id="first_name"
                                       class="form-control" placeholder="e.g. John" required autofocus>
                            </div>
                            <div class="text-danger small mt-1" id="first_nameError"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="middle_name" class="form-label fw-semibold text-secondary">
                                Middle Name <span class="text-muted fw-normal">(Optional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0">
                                    <i class="bi bi-person text-indigo icon-md"></i>
                                </span>
                                <input type="text" name="middle_name" id="middle_name"
                                       class="form-control" placeholder="e.g. Mark">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="last_name" class="form-label fw-semibold text-secondary">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0">
                                    <i class="bi bi-person text-indigo icon-md"></i>
                                </span>
                                <input type="text" name="last_name" id="last_name"
                                       class="form-control" placeholder="e.g. Mayo" required>
                            </div>
                            <div class="text-danger small mt-1" id="last_nameError"></div>
                        </div>
                    </div>

                    {{-- ── Email ── --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-emerald-subtle border-end-0">
                                <i class="bi bi-envelope text-emerald icon-md"></i>
                            </span>
                            <input type="email" name="email" id="email"
                                   class="form-control" placeholder="e.g. john.doe@example.com" required>
                        </div>
                        <div class="text-danger small mt-1" id="emailError"></div>
                    </div>

                    {{-- ── Course + Year Level ── --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="course" class="form-label fw-semibold text-secondary mb-0">Course / Major</label>
                                <a href="{{ route('courses.create') }}" class="small text-decoration-none fw-semibold text-primary" target="_blank">
                                    <i class="bi bi-plus-circle me-1"></i>Add Course
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-amber-subtle border-end-0">
                                    <i class="bi bi-book text-amber icon-md"></i>
                                </span>
                                <select name="course" id="course" class="form-select" required>
                                    <option value="" disabled selected>Choose a Managed Course...</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->code }}">{{ $c->code }} — {{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-danger small mt-1" id="courseError"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="year_level" class="form-label fw-semibold text-secondary">Grade / Year Level</label>
                            <div class="input-group">
                                <span class="input-group-text bg-violet-subtle border-end-0">
                                    <i class="bi bi-mortarboard text-violet icon-md"></i>
                                </span>
                                <select name="year_level" id="year_level" class="form-select" required>
                                    @foreach($yearLevels as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-danger small mt-1" id="year_levelError"></div>
                        </div>
                    </div>

                    {{-- ── Status + GPA + Age ── --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label fw-semibold text-secondary">Enrollment Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-emerald-subtle border-end-0">
                                    <i class="bi bi-info-circle text-emerald icon-md"></i>
                                </span>
                                <select name="status" id="status" class="form-select" required>
                                    @foreach($statuses as $st)
                                        <option value="{{ $st }}" {{ $st === 'Active' ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="gpa" class="form-label fw-semibold text-secondary">GPA</label>
                            <div class="input-group">
                                <span class="input-group-text bg-amber-subtle border-end-0">
                                    <i class="bi bi-star text-amber icon-md"></i>
                                </span>
                                <input type="number" step="0.01" min="0.00" max="5.00"
                                       name="gpa" id="gpa" class="form-control" placeholder="e.g. 3.75">
                            </div>
                            <div class="text-danger small mt-1" id="gpaError"></div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="age" class="form-label fw-semibold text-secondary">Age</label>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-subtle border-end-0">
                                    <i class="bi bi-calendar-event text-indigo icon-md"></i>
                                </span>
                                <input type="number" name="age" id="age"
                                       class="form-control" value="20" placeholder="20" min="15" max="100" required>
                            </div>
                            <div class="text-danger small mt-1" id="ageError"></div>
                        </div>
                    </div>

                    {{-- ── Buttons ── --}}
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('students.index') }}" id="cancelBtn"
                           class="btn btn-outline-secondary px-4 d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left icon-sm"></i> Cancel
                        </a>
                        <button type="submit" id="submitStudentBtn"
                                class="btn btn-primary px-4 shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill icon-sm"></i>
                            <span id="submitBtnText">Save Student</span>
                            <span id="submitBtnSpinner" class="spinner-border spinner-border-sm d-none"
                                  role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

            </div>{{-- /card-body --}}
        </div>{{-- /card --}}
    </div>
</div>

@push('scripts')
<script>
// ============================================================
//  ADD STUDENT — JavaScript Functions (AJAX / Fetch API)
// ============================================================
(function () {
    'use strict';

    const STORE_URL  = '{{ route('students.store') }}';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content
                       || '{{ csrf_token() }}';

    // ── 1. Avatar live preview ───────────────────────────────
    document.getElementById('avatar').addEventListener('change', function () {
        const file = this.files[0];
        clearError('avatar');
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            showError('avatar', 'File size must not exceed 2 MB.');
            this.value = '';
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            showError('avatar', 'Only JPEG, PNG, and WEBP images are allowed.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => { document.getElementById('avatarPreview').src = e.target.result; };
        reader.readAsDataURL(file);
    });

    // ── 2. Generate Student ID button ────────────────────────
    document.getElementById('generateIdBtn').addEventListener('click', function () {
        const year = new Date().getFullYear();
        const rand = String(Math.floor(Math.random() * 99999) + 1).padStart(5, '0');
        document.getElementById('student_number').value = `STD-${year}-${rand}`;
        // Flash button green
        this.classList.replace('btn-outline-secondary', 'btn-success');
        setTimeout(() => this.classList.replace('btn-success', 'btn-outline-secondary'), 900);
    });

    // ── 3. Clear per-field error on user input ───────────────
    ['first_name', 'middle_name', 'last_name', 'email', 'gpa', 'age', 'student_number']
        .forEach(id => document.getElementById(id)?.addEventListener('input', () => clearError(id)));
    ['course', 'year_level', 'status']
        .forEach(id => document.getElementById(id)?.addEventListener('change', () => clearError(id)));

    // ── 4. AJAX Form Submission via Fetch API ────────────────
    document.getElementById('addStudentForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        clearAllErrors();

        // --- Client-side validation ---
        let valid = true;
        const first_name = document.getElementById('first_name').value.trim();
        const last_name  = document.getElementById('last_name').value.trim();
        const email      = document.getElementById('email').value.trim();
        const course     = document.getElementById('course').value;
        const year_level = document.getElementById('year_level').value;
        const ageRaw     = document.getElementById('age').value;
        const age        = parseInt(ageRaw, 10);

        if (!first_name) { showError('first_name', 'First name is required.');      valid = false; }
        if (!last_name)  { showError('last_name',  'Last name is required.');       valid = false; }
        if (!email) {
            showError('email', 'Email address is required.');                        valid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('email', 'Please enter a valid email address.');               valid = false;
        }
        if (!course)     { showError('course',     'Please select a course.');      valid = false; }
        if (!year_level) { showError('year_level', 'Please select a year level.'); valid = false; }
        if (!ageRaw || isNaN(age) || age < 15 || age > 100) {
            showError('age', 'Age must be between 15 and 100.');                     valid = false;
        }

        if (!valid) {
            showAlert('danger',
                '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
                'Please fix the highlighted errors before submitting.');
            return;
        }

        // --- Loading state ---
        setSubmitting(true);

        try {
            const response = await fetch(STORE_URL, {
                method:  'POST',
                headers: {
                    'Accept':           'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN':     CSRF_TOKEN,
                },
                body: new FormData(this),
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // ✅ Success
                showAlert('success',
                    '<i class="bi bi-check-circle-fill me-2"></i>' +
                    '<strong>' + escapeHtml(data.message) + '</strong>' +
                    '<br><small class="opacity-75">Redirecting to student list…</small>');

                document.getElementById('cancelBtn').style.pointerEvents = 'none';
                document.getElementById('submitStudentBtn').disabled = true;

                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route('students.index') }}';
                }, 1800);

            } else if (response.status === 422 && data.errors) {
                // ❌ Laravel validation errors
                setSubmitting(false);
                const messages = [];
                for (const [field, msgs] of Object.entries(data.errors)) {
                    showError(field, msgs[0]);
                    messages.push(escapeHtml(msgs[0]));
                }
                showAlert('danger',
                    '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
                    '<strong>Please fix the following errors:</strong>' +
                    '<ul class="mb-0 ps-3 small mt-1">' +
                    messages.map(m => `<li>${m}</li>`).join('') + '</ul>');

            } else {
                // ❌ Other server error
                setSubmitting(false);
                showAlert('danger',
                    '<i class="bi bi-x-circle-fill me-2"></i>' +
                    (data.message ? escapeHtml(data.message) : 'An unexpected error occurred.'));
            }

        } catch (err) {
            setSubmitting(false);
            showAlert('danger',
                '<i class="bi bi-wifi-off me-2"></i>' +
                'Network error — please check your connection and try again.');
            console.error('[AddStudent]', err);
        }
    });

    // ── Helper Functions ─────────────────────────────────────

    function showError(field, message) {
        const el    = document.getElementById(`${field}Error`);
        const input = document.getElementById(field) || document.querySelector(`[name="${field}"]`);
        if (el)    el.textContent = message;
        if (input) input.classList.add('is-invalid');
    }

    function clearError(field) {
        const el    = document.getElementById(`${field}Error`);
        const input = document.getElementById(field) || document.querySelector(`[name="${field}"]`);
        if (el)    el.textContent = '';
        if (input) input.classList.remove('is-invalid');
    }

    function clearAllErrors() {
        document.querySelectorAll('[id$="Error"]').forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('jsAlertArea').innerHTML = '';
    }

    function showAlert(type, html) {
        document.getElementById('jsAlertArea').innerHTML =
            `<div class="alert alert-${type} alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert">
                ${html}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>`;
        document.getElementById('addStudentCard')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function setSubmitting(on) {
        document.getElementById('submitStudentBtn').disabled = on;
        document.getElementById('submitBtnText').textContent = on ? 'Saving…' : 'Save Student';
        document.getElementById('submitBtnSpinner').classList.toggle('d-none', !on);
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

})();
</script>
@endpush
@endsection