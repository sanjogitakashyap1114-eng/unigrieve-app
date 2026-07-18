<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function create()
    {
        $user = Auth::user()->load('studentMaster'); 
        $departments = Department::select('id', 'name')->get();

        return view('dashboard.student.servicereq', compact('user', 'departments'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'service_type'  => 'required|string|in:Bus Pass,Student ID Card,WiFi Registration',
                'department_id' => 'required|exists:departments,id',
                'description'   => 'required|string',
                'evidence.*'    => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
            ]);

            $latest = ServiceRequest::latest()->first();
            $nextId = $latest ? ($latest->id + 1) : 1;
            $serviceId = 'SRV-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

          $uploadedDocs = [];
if ($request->hasFile('evidence')) {
    foreach ($request->file('evidence') as $index => $file) {
        $path = $file->store('service_evidences', 'public');

        // Service + reason ke hisaab se label
        if ($request->service_type === 'Bus Pass') {
            $docLabel = ($index === 0) ? 'Address Proof' : 'Passport Photo';
        } elseif ($request->service_type === 'Student ID Card') {
            if ($request->id_reason === 'Lost Card') {
                $docLabel = ($index === 0) ? 'Fine Fee Receipt' : 'Undertaking Form';
            } else {
                $docLabel = ($index === 0) ? 'Admission Letter' : 'Fee Payment Receipt';
            }
        } else {
            $docLabel = 'Document ' . ($index + 1);
        }

        $uploadedDocs[] = [
            'label'       => $docLabel,
            'path'        => $path,
            'uploaded_at' => now()->toDateTimeString()
        ];
    }
}

// extra_data mein bus/id/wifi fields store karo
$extraData = $request->only([
    'bus_route', 'bus_pickup', 'bus_duration',
    'id_reason',
    'wifi_device', 'wifi_mac'
]);
// Empty values filter karo
$extraData = array_filter($extraData, fn($v) => !empty($v));


            ServiceRequest::create([
                'service_id'    => $serviceId,
                'student_id'    => Auth::id(),
                'department_id' => $request->department_id,
                'service_type'  => $request->service_type,
                'description'   => $request->description,
                'additional_details'    => !empty($extraData) ? json_encode($extraData) : null,
                'evidence'      => !empty($uploadedDocs) ? json_encode($uploadedDocs) : null,
                'status'        => 'Pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => "Service request submitted! Ticket ID: <strong>{$serviceId}</strong>"
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
                'message' => $e->getMessage() // ← exact DB/model error aayega
            ], 500);
        }
    }
}