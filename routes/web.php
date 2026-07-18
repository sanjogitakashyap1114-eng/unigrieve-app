<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Student\ComplaintController;
use App\Http\Controllers\Student\ServiceRequestController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\MyComplaintsController;
use App\Http\Controllers\Student\CreateComplaintController;
use App\Http\Controllers\Student\MyServicesController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AddDepartmentController;
use App\Http\Controllers\Admin\ServiceManagementController;
use App\Http\Controllers\Admin\DepartmentDirectoryController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\department\DepartmentController;
use App\Http\Controllers\department\NoticeController;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('home');
// Route::get('/index', function () {
//     return view('index');
// })->name('home');
Route::get('/departments-overview', function () {
    return view('department');
})->name('public.departments');
// Auth::routes();

Route::middleware('guest')->group(function () {
    Auth::routes(['login' => false]); // Tells Laravel UI not to register the default un-guarded login route
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');;

// ==================== AUTH PROTECTED ROUTES ====================
Route::middleware('auth')->group(function () {
    // Route::get('/logout', [LoginController::class, 'logout'])->name('get.logout');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // ==================== STUDENT ROUTES ====================
    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Complaints
    Route::get('/student/mycomplaint', [MyComplaintsController::class, 'index'])->name('student.mycomplaint');
    Route::get('/student/complaints/{id}', [MyComplaintsController::class, 'show'])->name('student.complaints.show');
    Route::get('/complaints/create', [CreateComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints/store', [CreateComplaintController::class, 'store'])->name('complaints.store');

    // Services
    Route::get('/student/services/create', [ServiceRequestController::class, 'create'])->name('student.services.create');
    Route::post('/student/services/store', [ServiceRequestController::class, 'store'])->name('student.services.store');
    Route::get('/student/myservices', [MyServicesController::class, 'index'])->name('student.myservices');
    Route::get('/student/services/view/{id}', [MyServicesController::class, 'show'])->name('student.services.show');

    // Profile & Docs
    Route::get('/student/docs/{filename}', [MyComplaintsController::class, 'viewDocument'])->name('student.docs.view');
    Route::get('/student/profile', [ProfileController::class, 'showProfile'])->name('student.profile');
    Route::put('/student/profile/update', [ProfileController::class, 'updateProfile'])->name('student.profile.update');

    // ==================== ADMIN ROUTES ====================
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/students/import', [AdminController::class, 'import'])->name('students.import');
    Route::post('/admin/dashboard/add-department', [AddDepartmentController::class, 'store'])->name('admin.departments.store');

    // Admin Complaints
    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('/complaints/{id}/triage', [AdminComplaintController::class, 'handleAction'])->name('complaints.triage');
    // Route::patch('/admin/complaints/{id}/action', [AdminComplaintController::class, 'handleAction'])->name('admin.complaints.action');

    // Admin Services
    Route::get('/services', [ServiceManagementController::class, 'index'])->name('services.index');
    Route::get('/services/{id}', [ServiceManagementController::class, 'show'])->name('services.show');
    Route::patch('/services/{id}/triage', [ServiceManagementController::class, 'update'])->name('services.update');
    Route::patch('/services/{id}/reject', [ServiceManagementController::class, 'reject'])->name('services.reject');

    // Department Directory
    Route::get('/departments', [DepartmentDirectoryController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentDirectoryController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}', [DepartmentDirectoryController::class, 'show'])->name('departments.show');
    Route::patch('/departments/{id}', [DepartmentDirectoryController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentDirectoryController::class, 'destroy'])->name('departments.destroy');
    Route::post('/departments/{id}/add-staff', [DepartmentDirectoryController::class, 'addStaff'])->name('departments.addStaff');
    Route::delete('/departments/{id}/remove-staff/{staffId}', [DepartmentDirectoryController::class, 'removeStaff'])->name('departments.removeStaff');
    //adminprofile
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    // 2. Update Profile Information (Name, Email)
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    // 3. Update Security Password
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    //studentspagedetail
    Route::get('/students', [StudentManagementController::class, 'index'])->name('students.index');
    Route::get('/students/{id}/edit', [StudentManagementController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentManagementController::class, 'update'])->name('students.update');
    Route::get('/student/notices', [DashboardController::class, 'allNotices'])
        ->name('student.notices');
    // ==================== DEPARTMENT ROUTES ====================
    Route::prefix('department')->name('department.')->group(function () {

        Route::get('/dashboard', [DepartmentController::class, 'dashboard'])->name('dashboard');

        // Complaints Management
        Route::get('/complaints', [DepartmentController::class, 'complaints'])->name('complaints');
        Route::get('/complaints/{complaint}', [DepartmentController::class, 'showComplaint'])->name('complaints.show');
        Route::post('/complaints/{complaint}/status', [DepartmentController::class, 'updateComplaintStatus'])->name('complaints.status');
        Route::post('/complaints/{complaint}/quick-reject', [DepartmentController::class, 'quickRejectComplaint'])->name('complaints.quick-reject');

        // Services Management
        Route::get('/services', [DepartmentController::class, 'services'])->name('services');
        Route::get('/services/{serviceRequest}', [DepartmentController::class, 'showService'])->name('services.show');
        Route::post('/services/{serviceRequest}/status', [DepartmentController::class, 'updateServiceStatus'])->name('services.status');
        Route::post('/services/{serviceRequest}/quick-reject', [DepartmentController::class, 'quickRejectService'])->name('services.quick-reject');

        // Settings & Notifications
        Route::get('/notices', [NoticeController::class, 'index'])
            ->name('notices');

        Route::post('/notices', [NoticeController::class, 'store'])
            ->name('notices.store');
        Route::get('/profile', [DepartmentController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [DepartmentController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/password', [DepartmentController::class, 'resetPassword'])->name('profile.password');
    });
});
