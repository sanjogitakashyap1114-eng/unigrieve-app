<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * Show Notice Page
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $departmentId = Auth::user()->department_id;

        $notices = Notice::where('department_id', $departmentId)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $totalNotices = Notice::where('department_id', $departmentId)->count();

        $activeNotices = Notice::where('department_id', $departmentId)
            ->where('is_active', 1)
            ->count();

        $expiredNotices = Notice::where('department_id', $departmentId)
            ->whereDate('last_date', '<', now())
            ->count();

        return view('dashboard.department.notices', compact(
            'notices',
            'search',
            'totalNotices',
            'activeNotices',
            'expiredNotices'
        ));
    }

    /**
     * Store Notice
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'last_date'   => 'nullable|date',
            'attachment'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $attachment = null;

        if ($request->hasFile('attachment')) {

            $attachment = $request->file('attachment')
                ->store('notices', 'public');
        }

        Notice::create([

            'department_id' => Auth::user()->department_id,

            'title' => $request->title,

            'description' => $request->description,

            'last_date' => $request->last_date,

            'attachment' => $attachment,

            'is_active' => 1,

        ]);

        return redirect()
            ->route('department.notices')
            ->with('success', 'Notice published successfully.');
    }
}          