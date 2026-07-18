@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 py-0 text-start">
        <div class="w-100 bg-white min-vh-100 shadow-sm rounded-0">

            {{-- Professional ERP Header --}}
            <div class="bg-primary text-white p-4 border-bottom border-secondary">
                <div class="d-flex align-items-center">
                    <div class="me-3 fs-3">⚠️</div>
                    <div>
                        <h5 class="fw-bold mb-1 m-0 text-start">Grievance & Complaint Registration</h5>
                        <p class="small mb-0 text-white-50 text-start">File an official grievance tracking ticket. Content
                            will be directly routed to respective department heads.</p>
                    </div>
                </div>
            </div>

            {{-- Main Form Body Content --}}
            <div class="p-4 p-md-5 text-start">
                <div id="alertBox" class="alert d-none text-start mb-4"></div>

                <form id="complaintRequestForm" enctype="multipart/form-data" class="text-start m-0">
                    @csrf

                    {{-- SECTION 1: STUDENT PROFILE INFO (TOP PREFILLED) --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-start text-uppercase tracking-wider">
                        🎓 Student Profile Information</div>
                    <div class="row g-4 mb-5 text-start">
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Full Registered Name</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Communication Email</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Primary Phone Number</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->studentMaster->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Enrolled Course /
                                Stream</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->studentMaster->course ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Current Semester</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->studentMaster->semester ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Registration Batch</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2"
                                value="{{ $user->studentMaster->batch ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    {{-- SECTION 2: COMPLAINT CORE METRICS --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-start text-uppercase tracking-wider">
                        📋 Grievance Parameters</div>
                    <div class="row g-4 mb-5 text-start">
                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Grievance Category <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-sm py-2" name="category" id="complaintCategory" required>
                                <option selected disabled value="">Select Category</option>
                                <option value="Academic">Academic Issues</option>
                                <option value="Hostel">Hostel & Facilities</option>
                                <option value="Fees">Fees&Accounts</option>
                                <option value="Administration">Administration</option>
                                <option value="Safety">Safety&Others</option>
                                <option value="It&Technical">It&Technical</option>
                            </select>
                        </div>

                        <div class="col-xl-4 col-md-6 text-start">
                            <label class="form-label fw-semibold text-secondary small d-block">Target Department <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-sm py-2" name="department_id" required>
                                <option selected disabled value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- SECTION 3: COMPLAINT DETAILS --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-start text-uppercase tracking-wider">
                        📝 Complaint Specifics</div>
                    <div class="mb-4 text-start col-xl-8 col-12">
                        <label class="form-label fw-semibold text-secondary small d-block">Grievance Subject Title <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm py-2" name="title"
                            placeholder="Brief summarizing headline..." required>
                    </div>
                    <div class="mb-5 text-start">
                        <label class="form-label fw-semibold text-secondary small d-block">Comprehensive Description <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" name="description" rows="5"
                            placeholder="Elaborate details including dates, names, occurrences transparently..." required></textarea>
                    </div>

                    {{-- SECTION 4: EVIDENCE FILE ATTACHMENTS --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-start text-uppercase tracking-wider">
                        📎 Validating Evidence Uploads</div>

                    {{-- Contextual Dynamic Guidance Checklist Box --}}
                    <div id="docInstructionBox"
                        class="alert alert-warning d-none mb-3 py-3 px-4 small text-start border-start border-warning border-4"
                        role="alert">
                        <strong class="d-block mb-2 text-dark fs-6">⚠️ Recommended Validation Attachments:</strong>
                        <ul id="docList" class="mb-0 ps-3 text-start text-dark fw-medium"></ul>
                    </div>

                    <div class="mb-5 col-xl-5 col-md-8 text-start">
                        <label class="form-label fw-semibold text-secondary small d-block">Upload Evidence Materials <span
                                class="text-muted">(Multiple selection allowed)</span></label>
                        <input type="file" class="form-control form-control-sm py-2" name="evidence[]" multiple
                            id="evidenceInput">
                        <small class="text-muted d-block mt-1">Supported Formats: PDF, JPG, PNG .</small>
                    </div>

                    {{-- SUBMIT STRIP --}}
                    <div class="col-xl-3 col-md-4 ps-0 text-start">
                        <button type="submit" class="btn btn-danger w-100 submit-btn py-2 fw-bold shadow-sm">
                            File Official Complaint
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Dynamic checklist warning framework on change
            $('#complaintCategory').on('change', function() {
                let category = $(this).val();
                let $box = $('#docInstructionBox');
                let $list = $('#docList');

                $list.empty();
                $box.addClass('d-none');
                const docs = {
                    'Academic': [
                        'University ID Card (both sides)',
                        'Relevant marksheet or grade report copy',
                        'Class timetable or schedule screenshot',
                        'Prior written communication with faculty/HOD (if any)',
                        'Syllabus document copy (if timetable/course related)'
                    ],
                    'Fees': [
                        'University ID Card',
                        'Original fee payment receipt or challan',
                        'Bank transaction screenshot or passbook printout',
                        'Scholarship sanction letter (if scholarship related)',
                        'Previous semester fee clearance receipt (if applicable)'
                    ],
                    'Hostel': [
                        'University ID Card',
                        'Hostel allotment slip or room allocation letter',
                        'Photograph evidence of room defect or issue',
                        'Mess fee receipt (if mess/food related)',
                        'Prior complaint submitted to hostel warden (if any)'
                    ],
                    'Administration': [
                        'University ID Card (mandatory)',
                        'Admission letter or enrollment confirmation',
                        'Relevant official document under dispute',
                        'Exam admit card or hall ticket (if exam related)',
                        'Any prior correspondence with admin office'
                    ],
                    'Safety': [
                        'University ID Card (mandatory)',
                        'Written statement describing the incident with date and time',
                        'Witness names and contact details (if available)',
                        'Photographs or video evidence (if safely available)',
                        'Any prior complaint filed with hostel warden or security'
                    ],
                    'It&Technical': [
                        'University ID Card',
                        'Screenshot of portal error or wifi issue',
                        'IT support complaint reference number (if any)',
                        'Lab fee receipt (if lab access related)',
                        'Any prior communication with IT support desk'
                    ]
                };

                if (docs[category]) {
                    $box.removeClass('d-none');
                    docs[category].forEach(function(doc) {
                        $list.append('<li class="mb-1">' + doc + '</li>');
                    });
                }
            });

            // Handle AJAX processing
            $('#complaintRequestForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('.submit-btn').prop('disabled', true).text('Logging Ticket...');

                $.ajax({
                    url: "{{ route('complaints.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#alertBox').removeClass('d-none alert-danger').addClass(
                                'alert-success').html(response.message);
                            $('#complaintRequestForm')[0].reset();
                            $('#docInstructionBox').addClass('d-none');
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.message ||
                            'Server side failure logging complaint entity instance!';
                        $('#alertBox').removeClass('d-none alert-success').addClass(
                            'alert-danger').text(errorMsg);
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    },
                    complete: function() {
                        $('.submit-btn').prop('disabled', false).text(
                            'File Official Complaint');
                    }
                });
            });
        });
    </script>
@endsection
