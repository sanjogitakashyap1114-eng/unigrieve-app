@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid px-4 py-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif
        {{-- PAGE HEADER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h3 class="fw-bold mb-1 text-brand-primary">
                        <i class="fas fa-bullhorn text-dark me-2"></i>
                        Department Notices
                    </h3>

                    <p class="text-muted mb-3">
                        Manage announcements and keep students informed about important
                        deadlines, department activities, university services and official updates.
                    </p>
                </div>

                <div class="mt-1">
                    <button class="btn bg-brand-primary  text-white  px-4" data-bs-toggle="modal"
                        data-bs-target="#addNoticeModal">

                        <i class="fas fa-plus me-2"></i>
                        Add Notice

                    </button>
                </div>

            </div>
        </div>

        {{-- STATISTICS --}}
        <div class="row g-3 mb-4   ">
{{-- 
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <small class="text-muted text-uppercase">
                            Total Notices
                        </small>

                        <h3
                            class="fw-bold mt-2     badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary">
                            {{ $totalNotices ?? 0 }}
                        </h3>

                    </div>
                </div>
            </div> --}}
            
            <div class="col-md-3 ">
            <div class="col-sm-auto d-flex gap-5 p-1   align-items-center">
                <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary badge-active-tracker">
           Total    Notices {{ $totalNotices ?? 0 }}
                </span>
            </div>
            </div>
              <div class="col-md-3">
            <div class="col-sm-auto d-flex gap-2 align-items-center">
                <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary badge-active-tracker">
      Expired Notices {{ $totalNotices ?? 0 }}
                </span>
            </div>
              </div>
          <div class="col-md-3">
            <div class="col-sm-auto d-flex gap-2 align-items-center">
                <span class="badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary badge-active-tracker">
           Active   Notices  {{ $activeNotices ?? 0 }}
                </span>
            </div>
          </div>
{{-- 
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <small class="text-muted text-uppercase">
                            Active Notices
                        </small>

                        <h3
                            class="fw-bold text-success mt-2 mb-0   badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary">
                            {{ $activeNotices ?? 0 }}
                        </h3>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body   ">

                        <small class="text-muted text-uppercase">
                            Expired Notices
                        </small>

                        <h3
                            class="fw-bold text-danger mt-2 mb-0    badge px-3 py-2 rounded-3 fw-bold text-white shadow-sm bg-brand-primary">
                            {{ $expiredNotices ?? 0 }}
                        </h3>

                    </div>
                </div>
            </div> --}}

        </div>

        {{-- SEARCH --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form action="{{ route('department.notices') }}" method="GET">

                    <div class="row align-items-end">

                        <div class="col-md-10">

                            <label class="form-label fw-semibold">
                                Search Notice
                            </label>

                            <input type="text" name="serach" value="{{ request('serach') }}"class="form-control"
                                placeholder="Search by notice title...">

                        </div>

                        <div class="col-md-2">

                            <button class="btn  mb-1    bg-brand-primary text-white w-100">

                                <i class="fas fa-search me-2"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- NOTICE TABLE --}}
        <div class="card border-0 shadow-sm  overflow-hidden">

            <div class="card-header bg-white border-bottom">

                <h5 class="mb-0 fw-semibold">

                    Existing Notices

                </h5>

            </div>

            <div class="table-responsive  ">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>Title</th>

                            <th>Last Date</th>

                            <th>Status</th>

                            <th>Created</th>

                            <th class="text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($notices as $notice)
                            <tr>

                                <td>

                                    <div class="fw-bold">
                                        {{ $notice->title }}
                                    </div>

                                    <small class="text-muted">
                                        {{ Str::limit($notice->description, 60) }}
                                    </small>

                                </td>

                                <td>

                                    {{ $notice->last_date ? \Carbon\Carbon::parse($notice->last_date)->format('d M Y') : '-' }}

                                </td>

                                <td>

                                    @if ($notice->last_date && \Carbon\Carbon::parse($notice->last_date)->isPast())
                                        <span class="badge bg-danger">
                                            Expired
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    {{ $notice->created_at->format('d M Y') }}

                                </td>

                                <td class="text-center">

                                    <a href="" class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form action="" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Delete this notice?')"
                                            class="btn btn-sm btn-outline-danger">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5">

                                    <div class="text-center py-5">

                                        <i class="fas fa-bullhorn fa-3x text-secondary mb-3"></i>

                                        <h5>No Notices Found</h5>

                                        <p class="text-muted">

                                            Click <strong>Add Notice</strong> to publish your first notice.

                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <!-- Add Notice Modal -->
    <div class="modal fade" id="addNoticeModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow">

                <form action="{{ route('department.notices.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">

                            <i class="fas fa-bullhorn text-primary me-2"></i>

                            Publish New Notice

                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-semibold">

                                    Notice Title

                                </label>

                                <input type="text" name="title" class="form-control"
                                    placeholder="Example : Student ID Card Application" required>

                            </div>

                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-semibold">

                                    Description

                                </label>

                                <textarea name="description" rows="5" class="form-control" placeholder="Write complete notice..." required></textarea>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Last Date

                                </label>

                                <input type="date" name="last_date" class="form-control">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">

                                    Attachment

                                </label>

                                <input type="file" name="attachment" class="form-control">

                                <small class="text-muted">

                                    PDF, JPG, PNG (Optional)

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-paper-plane me-2"></i>

                            Publish Notice

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
