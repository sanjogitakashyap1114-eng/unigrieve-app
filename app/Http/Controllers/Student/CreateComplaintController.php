<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class CreateComplaintController extends Controller
{
    // Render the complaint form with student profile & available departments
    public function create()
    {
        // Assuming your User model has a relationship named 'studentMaster'
        $user = Auth::user()->load('studentMaster'); 
        $departments = Department::select('id', 'name')->get();

        return view('dashboard.student.createcomplaint', compact('user', 'departments'));
    }

    // Handle AJAX multipart dynamic file storage via JSON column
 public function store(Request $request)
{
    try {
        $request->validate([
            'category'      => 'required|string|in:Academic,Hostel,Fees,Administration,Safety,It&Technical',
            'department_id' => 'required|exists:departments,id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'evidence.*'    => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $latest = Complaint::latest()->first();
        $nextId = $latest ? ($latest->id + 1) : 1;
        $complaintId = 'COMP-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $uploadedDocs = [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $index => $file) {
                $path = $file->store('complaint_evidences', 'public');

                // $docLabel = 'Evidence Document ' . ($index + 1);
                // if ($request->category === 'Fees') {
                //     $docLabel = ($index === 0) ? 'Disputed Fee Receipt' : 'Bank Transaction Copy';
                // } elseif ($request->category === 'Hostel') {
                //     $docLabel = ($index === 0) ? 'Hostel Allotment Slip' : 'Room Condition Proof';
                // } elseif ($request->category === 'Academic') {
                //     $docLabel = ($index === 0) ? 'Syllabus / Schedule Doc' : 'Prior Correspondence';
                // }

                $uploadedDocs[] = [
                    'label'       => 'Evidence Document ',
                    'path'        => $path,
                    'uploaded_at' => now()->toDateTimeString()
                ];
            }
        }

        Complaint::create([
            'complaint_id' => $complaintId,
            'student_id'   => Auth::id(),
            'department_id'=> $request->department_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'category'     => $request->category,
            'evidence'     => !empty($uploadedDocs) ? json_encode($uploadedDocs) : null,
            'priority'     => 'Medium',
            'status'       => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Complaint logged! Ticket ID: <strong>{$complaintId}</strong>"
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors'  => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage() // ← exact error aayega
        ], 500);
    }
}
}