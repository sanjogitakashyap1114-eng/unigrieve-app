@extends('layouts.mainlayout')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-section">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            <div class="carousel-item active">
         <img src="{{ asset('images/img1.avif') }}" class="d-block w-100 hero-img" alt="Student Support">
                <div class="carousel-caption">
                    <h1>Student Grievance Portal</h1>
                    <p>Raise and track complaints easily from anywhere.</p>
                    <a href="{{route('login')}}" class="btn btn-warning hero-btn me-2">Raise Complaint</a>
                    <a href="{{route('login')}}" class="btn btn-outline-light hero-btn">Track Status</a>
                </div>
            </div>

            <div class="carousel-item">
                {{-- <img src="resources/assets/img3.avif"
                    class="d-block w-100 hero-img" alt="Track Complaint"> --}}
<img src="{{ asset('images/books.avif') }}" class="d-block w-100 hero-img" alt="Student Services">
                <div class="carousel-caption">
                    <h1>Track Your Complaint</h1>
                    <p>Know the latest status of your submission anytime.</p>
                    <a href="{{route('login')}}" class="btn btn-warning hero-btn">Track Now</a>
                </div>
            </div>

            <div class="carousel-item">
                {{-- <img src="resources/assets/books.avif"
                    class="d-block w-100 hero-img" alt="Student Services"> --}}
<img src="{{ asset('images/img3.avif') }}" class="d-block w-100 hero-img" alt="Track Complaint">
                <div class="carousel-caption">
                    <h1>Digital Student Services</h1>
                    <p>Request certificates and services online — no office visits needed.</p>
                    <a href="#services" class="btn btn-warning hero-btn">Explore Services</a>
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>


{{-- ===== STATS BAR ===== --}}
<section class="stats-bar">
    <div class="container">
        <div class="row g-3 text-center">

            <div class="col-6 col-md-3 stats-item">
                <div class="stats-number">500+</div>
                <div class="stats-label">Complaints Resolved</div>
            </div>

            <div class="col-6 col-md-3 stats-item">
                <div class="stats-number">12</div>
                <div class="stats-label">Departments</div>
            </div>

            <div class="col-6 col-md-3 stats-item">
                <div class="stats-number">24 hrs</div>
                <div class="stats-label">Avg. Response Time</div>
            </div>

            <div class="col-6 col-md-3 stats-item">
                <div class="stats-number">2000+</div>
                <div class="stats-label">Students Registered</div>
            </div>

        </div>
    </div>
</section>


{{-- ===== COMPLAINT CATEGORIES ===== --}}
<section class="section section-light">

    <div class="container">

        <div class="text-center mb-4">
            <h2 class="section-title">Facing a Problem?</h2>
            <p class="section-subtitle">
                Select a category and submit your grievance. We'll route it to the right department.
            </p>
            <div class="section-underline"></div>
        </div>

        <div class="row g-3">

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">📚</div>
                    <div>
                        <div class="category-title">Academic Issues</div>
                        <div class="category-text">Courses, grades, timetable, faculty concerns.</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">🏠</div>
                    <div>
                        <div class="category-title">Hostel & Facilities</div>
                        <div class="category-text">Room issues, maintenance, campus facilities.</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">💰</div>
                    <div>
                        <div class="category-title">Fees & Accounts</div>
                        <div class="category-text">Fee payments, refunds, scholarship issues.</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">🏛️</div>
                    <div>
                        <div class="category-title">Administration</div>
                        <div class="category-text">Admission, exams, permissions, documents.</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">💻</div>
                    <div>
                        <div class="category-title">IT & Technical</div>
                        <div class="category-text">Wi-Fi, portal access, lab, IT support.</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="category-card">
                    <div class="category-icon">🛡️</div>
                    <div>
                        <div class="category-title">Safety & Other</div>
                        <div class="category-text">Ragging, harassment, campus safety concerns.</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center mt-4">
            <a href="{{route('login')}}" class="btn btn-warning px-4 fw-semibold">
                Submit a Complaint
            </a>
        </div>

    </div>
</section>


{{-- ===== STUDENT SERVICES ===== --}}
<section id="services" class="section section-muted">

    <div class="container">

        <div class="text-center mb-4">
            <h2 class="section-title">Student Services Available Online</h2>
            <p class="section-subtitle">
                Apply for university services digitally — no office visits required.
            </p>
            <div class="section-underline"></div>
        </div>

        <div class="row g-3">

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="service-card">
                    <div class="service-icon">🚌</div>
                    <div class="service-title">Bus Pass</div>
                    <div class="service-meta">Administration</div>
                    <a href="{{route('login')}}" class="btn btn-warning btn-sm w-100 fw-semibold mt-3">Request Now</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="service-card">
                    <div class="service-icon">🪪</div>
                    <div class="service-title">ID Card</div>
                    <div class="service-meta">Administration</div>
                    <a href="{{route('login')}}" class="btn btn-warning btn-sm w-100 fw-semibold mt-3">Request Now</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="service-card">
                    <div class="service-icon">🏨</div>
                    <div class="service-title">Scholorship</div>
                    <div class="service-meta">Fee   & Accounts Office</div>
                    <a href="{{route('login')}}" class="btn btn-warning btn-sm w-100 fw-semibold mt-3">Request Now</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="service-card">
                    <div class="service-icon">📶</div>
                    <div class="service-title">Wi-Fi Access</div>
                    <div class="service-meta">IT Department</div>
                    <a href="{{route('login')}}" class="btn btn-warning btn-sm w-100 fw-semibold mt-3">Request Now</a>
                </div>
            </div>

        </div>

    </div>
</section>


{{-- ===== HOW IT WORKS ===== --}}
<section class="section section-light">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">How the System Works</h2>
            <p class="section-subtitle">Four simple steps to get your issue resolved.</p>
            <div class="section-underline"></div>
        </div>

        <div class="hiw-grid position-relative">
            <div class="hiw-connector d-none d-md-block"></div>

            <div class="hiw-card">
                <div class="hiw-badge">1</div>
                <div class="hiw-icon">🔐</div>
                <div class="hiw-step-title">Login</div>
                <p class="hiw-step-text">Sign in with your student ID and university email.</p>
            </div>

            <div class="hiw-card">
                <div class="hiw-badge alt">2</div>
                <div class="hiw-icon">📝</div>
                <div class="hiw-step-title">Submit</div>
                <p class="hiw-step-text">Fill complaint details and upload supporting documents.</p>
            </div>

            <div class="hiw-card">
                <div class="hiw-badge">3</div>
                <div class="hiw-icon">🔍</div>
                <div class="hiw-step-title">Review</div>
                <p class="hiw-step-text">Department reviews your complaint and takes action.</p>
            </div>

            <div class="hiw-card">
                <div class="hiw-badge alt">4</div>
                <div class="hiw-icon">✅</div>
                <div class="hiw-step-title">Resolved</div>
                <p class="hiw-step-text">Get notified when your grievance is resolved.</p>
            </div>

        </div>
    </div>
</section>


{{-- ===== TRACK STATUS ===== --}}
{{-- <section id="track" class="section section-muted">

    <div class="container">

        <div class="text-center mb-4">
            <h2 class="section-title">Track Status</h2>
            <p class="section-subtitle">
                Enter your Complaint ID or Service Request ID.
            </p>
            <div class="section-underline"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="track-box">

                    <label class="form-label fw-semibold section-title">
                        Track Complaint or Service Status
                    </label>

                    <div class="input-group">
                        <input type="text" class="form-control track-input"
                            placeholder="Enter Complaint ID or Service ID">

                        <button class="btn track-btn px-4">
                            Track Status →
                        </button>
                    </div>

                </div>

            </div>
        </div>                

    </div>
</section> --}}

@endsection
