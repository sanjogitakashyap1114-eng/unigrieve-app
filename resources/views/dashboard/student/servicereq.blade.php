@extends('layouts.app')

@section('content')
    <div class="container-fluid px-0 py-0 text-start">
        <div class="w-100 bg-white min-vh-100 shadow-sm rounded-0">

            <div class="bg-success text-white p-4 border-bottom border-secondary">
                <div class="d-flex align-items-center">
                    <div class="me-3 fs-3"><i class="fas fa-cogs me-2"></i><i class="bi bi-headset me-2"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1 m-0 text-start">Create Service Request</h5>
                        <p class="small mb-0 text-white-50 text-start">Submit a service request and track its status online through the student utility portal.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 p-md-5 text-start">
                <div id="alertBox" class="alert d-none text-start mb-4"></div>

                <form id="serviceRequestForm" enctype="multipart/form-data" class="text-start m-0">
                    @csrf

                    {{-- SECTION 1: STUDENT PROFILE (TOP, PREFILLED, READONLY) --}}
                    <div class="fs-6 fw-bold  border-bottom pb-2 mb-3 text-uppercase">🎓 Student Information</div>
                    <div class="row g-4 mb-5">
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Full Name</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Email</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Phone</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->studentMaster->phone ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Course</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->studentMaster->course ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Semester</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->studentMaster->semester ?? 'N/A' }}" readonly>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Batch</label>
                            <input type="text" class="form-control form-control-sm bg-light py-2" value="{{ $user->studentMaster->batch ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    {{-- SECTION 2: SERVICE INFO --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-uppercase">📋 Service Information</div>
                    <div class="row g-4 mb-4">
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm py-2" name="service_type" id="serviceType" required>
                                <option selected disabled value="">Select Service</option>
                                <option value="Bus Pass">Bus Pass</option>
                                <option value="Student ID Card">Student ID Card</option>
                                <option value="WiFi Registration">WiFi Registration</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label fw-semibold text-secondary small d-block">Handling Department <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm py-2" name="department_id" id="department_id" required>
                                <option selected disabled value="">Select Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- DYNAMIC FIELD: BUS PASS --}}
                    <div id="busFields" class="service-section d-none border p-4 rounded mb-5 bg-light">
                        <div class="fs-6 text-success mb-3 fw-bold">🚌 Bus Pass Details</div>
                        <div class="row g-3">
                            <div class="col-xl-3 col-md-4">
                                <label class="form-label small d-block">Route</label>
                                <select class="form-select form-select-sm" name="bus_route">
                                    <option value="Route A">Route A</option>
                                    <option value="Route B">Route B</option>
                                    <option value="Route C">Route C</option>
                                </select>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <label class="form-label small d-block">Pickup Point</label>
                                <input type="text" class="form-control form-control-sm" name="bus_pickup" placeholder="Enter pickup point">
                            </div>
                            <div class="col-xl-3 col-md-4">
                                <label class="form-label small d-block">Pass Duration</label>
                                <select class="form-select form-select-sm" name="bus_duration">
                                    <option value="Monthly">Monthly</option>
                                    <option value="Semester">Semester</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- DYNAMIC FIELD: ID CARD --}}
                    <div id="idFields" class="service-section d-none border p-4 rounded mb-5 bg-light">
                        <div class="fs-6 text-danger mb-3 fw-bold">🪪 ID Card Details</div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label small d-block">Reason for Request</label>
                            <select class="form-select form-select-sm" name="id_reason" id="idReason">
                                <option value="Fresh Issue">Fresh Issue</option>
                                <option value="Lost Card">Lost Card</option>
                                <option value="Damaged Card">Damaged Card</option>
                            </select>
                        </div>
                    </div>

                    {{-- DYNAMIC FIELD: WIFI --}}
                    <div id="wifiFields" class="service-section d-none border p-4 rounded mb-5 bg-light">
                        <div class="fs-6 text-info mb-3 fw-bold">📶 WiFi Registration</div>
                        <div class="row g-3">
                            <div class="col-xl-4 col-md-6">
                                <label class="form-label small d-block">Device Name</label>
                                <input type="text" class="form-control form-control-sm" name="wifi_device" placeholder="Laptop / Mobile">
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <label class="form-label small d-block">MAC Address</label>
                                <input type="text" class="form-control form-control-sm" name="wifi_mac" placeholder="00:1A:2B:3C:4D:5E">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: DESCRIPTION --}}
                    <div class="fs-6 fw-bold  border-bottom pb-2 mb-3 text-uppercase">📝 Additional Information</div>
                    <div class="mb-5">
                        <label class="form-label fw-semibold text-secondary small d-block">Reason / Description <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-sm" name="description" rows="4" placeholder="Provide detailed specifics regarding your request..." required></textarea>
                    </div>

                    {{-- SECTION 4: EVIDENCE --}}
                    <div class="fs-6 fw-bold text-primary border-bottom pb-2 mb-3 text-uppercase"><i class="fa-solid fa-paperclip"></i> Supporting Documents</div>

                    <div id="docInstructionBox" class="alert alert-warning d-none mb-3 py-3 px-4 small border-start border-warning border-4" role="alert">
                        <strong class="d-block mb-2 text-dark fs-6">⚠️ Required File Upload Checklist:</strong>
                        <ul id="docList" class="mb-0 ps-3 text-dark fw-medium"></ul>
                    </div>

                    <div class="mb-5 col-xl-5 col-md-8">
                        <label class="form-label fw-semibold text-secondary small d-block">Upload Files <span class="text-muted">(Multiple allowed)</span></label>
                        <input type="file" class="form-control form-control-sm py-2" name="evidence[]" multiple id="evidenceInput">
                        <small class="text-muted d-block mt-1">Accepted: PDF, JPG, PNG.</small>
                    </div>

                    <div class="col-xl-3 col-md-4 ps-0">
                        <button type="submit" class="btn btn-success w-100 submit-btn py-2 fw-bold shadow-sm">
                            Submit Service Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Doc checklist update
            function updateDocInstructions() {
                let service = $('#serviceType').val();
                let reason = $('#idReason').val();
                let $box = $('#docInstructionBox');
                let $list = $('#docList');

                $list.empty();
                $box.addClass('d-none');

                if (service === 'Student ID Card') {
                    $box.removeClass('d-none');
                    if (reason === 'Lost Card') {
                        $list.append('<li class="mb-1">Official Fine Fee Receipt (Lost ID Fine)</li><li>Duly completed Undertaking Form</li>');
                    } else {
                        $list.append('<li class="mb-1">College Admission Letter</li><li>Current Term Fee Payment Receipt</li>');
                    }
                } else if (service === 'Bus Pass') {
                    $box.removeClass('d-none');
                    $list.append('<li class="mb-1">Address Proof (Aadhar / Residence Certificate)</li><li>Passport Size Photograph</li>');
                }
            }

            // Service type change — show dynamic fields + doc checklist
            $('#serviceType').on('change', function() {
                let selectedService = $(this).val();
                $('.service-section').addClass('d-none');

                if (selectedService === 'Bus Pass') {
                    $('#busFields').removeClass('d-none');
                } else if (selectedService === 'Student ID Card') {
                    $('#idFields').removeClass('d-none');
                } else if (selectedService === 'WiFi Registration') {
                    $('#wifiFields').removeClass('d-none');
                }

                updateDocInstructions();
            });

            // ID reason change — update doc checklist
            $('#idReason').on('change', function() {
                updateDocInstructions();
            });

            // Form submit
            $('#serviceRequestForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                $('.submit-btn').prop('disabled', true).text('Processing Request...');

                $.ajax({
                    url: "{{ route('student.services.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#alertBox').removeClass('d-none alert-danger').addClass('alert-success').html(response.message);
                            $('#serviceRequestForm')[0].reset();
                            $('.service-section').addClass('d-none');
                            $('#docInstructionBox').addClass('d-none');
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let errorMsg = xhr.responseJSON?.message || 'Unknown error';

                        if (errors) {
                            let errorList = Object.values(errors).flat().join('<br>');
                            $('#alertBox').removeClass('d-none alert-success').addClass('alert-danger').html('<strong>Validation Errors:</strong><br>' + errorList);
                        } else {
                            $('#alertBox').removeClass('d-none alert-success').addClass('alert-danger').text(errorMsg);
                        }
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    },
                    complete: function() {
                        $('.submit-btn').prop('disabled', false).text('Submit Service Request');
                    }
                });
            });
        });
    </script>
@endsection