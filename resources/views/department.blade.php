@extends('layouts.mainlayout')

@section('content')

{{-- ===== HERO ===== --}}
<section class="dept-hero">
    <div class="container text-center">
        <h1>University Departments</h1>
        <p>Find contact information and details for all university departments.</p>
    </div>
</section>

{{-- ===== FILTER BAR ===== --}}
<div class="dept-filter-bar">
    <div class="container">
        <div class="dept-filters">
            <button class="dept-filter active" data-filter="all">All Departments</button>
            <button class="dept-filter" data-filter="academic">Academic</button>
            <button class="dept-filter" data-filter="administration">Administration</button>
            <button class="dept-filter" data-filter="it">IT & Technical</button>
            <button class="dept-filter" data-filter="finance">Finance</button>
            <button class="dept-filter" data-filter="student">Student Affairs</button>
        </div>
    </div>
</div>

{{-- ===== DEPARTMENTS GRID ===== --}}
<section class="section section-light">
    <div class="container">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="section-title mb-0">All Departments</h2>
            <span class="dept-count-pill" id="deptCount">6 departments</span>
        </div>

        <div class="row g-3" id="deptGrid">

            {{-- Administration --}}
            <div class="col-12 col-md-6 dept-item" data-category="administration">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-blue">🏛️</div>
                        <div>
                            <div class="dept-card-title">Administration</div>
                            <span class="dept-badge">Administration</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Handles admissions, examination schedules, official documents, permissions, and university-level policy matters.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Block A, Room 101 &nbsp;·&nbsp; Mon–Fri, 10am–4pm</div>
                        <div class="dept-meta-row">📧 admin@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830001</div>
                    </div>
                </div>
            </div>

            {{-- Academic Affairs --}}
            <div class="col-12 col-md-6 dept-item" data-category="academic">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-green">📚</div>
                        <div>
                            <div class="dept-card-title">Academic Affairs</div>
                            <span class="dept-badge">Academic</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Manages course allocation, faculty concerns, timetables, attendance disputes, and grade-related grievances.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Block B, Room 205 &nbsp;·&nbsp; Mon–Sat, 9am–5pm</div>
                        <div class="dept-meta-row">📧 academic@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830012</div>
                    </div>
                </div>
            </div>

            {{-- IT Department --}}
            <div class="col-12 col-md-6 dept-item" data-category="it">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-teal">💻</div>
                        <div>
                            <div class="dept-card-title">IT Department</div>
                            <span class="dept-badge">IT & Technical</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Handles Wi-Fi access, portal login issues, computer lab support, software requests, and network complaints.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Block C, Room 003 &nbsp;·&nbsp; Mon–Fri, 9am–6pm</div>
                        <div class="dept-meta-row">📧 it.support@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830025</div>
                    </div>
                </div>
            </div>

            {{-- Finance --}}
            <div class="col-12 col-md-6 dept-item" data-category="finance">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-amber">💰</div>
                        <div>
                            <div class="dept-card-title">Finance & Accounts</div>
                            <span class="dept-badge">Finance</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Manages fee payments, refund requests, scholarship disbursements, and financial aid-related issues.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Block A, Room 104 &nbsp;·&nbsp; Mon–Fri, 10am–3pm</div>
                        <div class="dept-meta-row">📧 accounts@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830033</div>
                    </div>
                </div>
            </div>

            {{-- Hostel --}}
            <div class="col-12 col-md-6 dept-item" data-category="student">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-purple">🏠</div>
                        <div>
                            <div class="dept-card-title">Hostel & Facilities</div>
                            <span class="dept-badge">Student Affairs</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Handles room allotment, maintenance requests, hostel transfers, mess complaints, and campus facility issues.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Hostel Block, Ground Floor &nbsp;·&nbsp; Mon–Sun, 8am–8pm</div>
                        <div class="dept-meta-row">📧 hostel@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830041</div>
                    </div>
                </div>
            </div>

            {{-- Student Welfare --}}
            <div class="col-12 col-md-6 dept-item" data-category="student">
                <div class="dept-card">
                    <div class="dept-card-top">
                        <div class="dept-icon-wrap dept-icon-coral">🛡️</div>
                        <div>
                            <div class="dept-card-title">Student Welfare</div>
                            <span class="dept-badge">Student Affairs</span>
                        </div>
                    </div>
                    <p class="dept-card-body">
                        Addresses ragging complaints, harassment, mental health support, campus safety, and student counselling needs.
                    </p>
                    <div class="dept-card-meta">
                        <div class="dept-meta-row">📍 Admin Block, Room 110 &nbsp;·&nbsp; Mon–Sat, 9am–5pm</div>
                        <div class="dept-meta-row">📧 welfare@university.edu.in</div>
                        <div class="dept-meta-row">📞 +91-177-2830050</div>
                    </div>
                </div>
            </div>

        </div>

        <div id="noResults" class="text-center py-5 d-none">
            <div style="font-size:2.5rem">🔍</div>
            <p class="mt-2 text-muted">No departments match your search.</p>
        </div>

    </div>
</section>

@endsection

