<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    public function index()
    {
        return view('admin.patients.index');
    }

    public function getAllPatients()
    {
        try {
            $patients = Patient::all();
            return response()->json([
                'status' => 'success',
                'data' => $patients
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve patients',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'phone_number' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$|^[0-9]{10}$/'],
                'email' => 'required|email|unique:patients,email',
                'address' => 'required|string',
                'emergency_contact_name' => 'required|string|max:255',
                'emergency_contact_phone' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$|^[0-9]{10}$/'],
                'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'medical_history' => 'nullable|string',
                'allergies' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $patient = Patient::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Patient created successfully',
                'data' => $patient
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create patient',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Patient $patient)
{
    try {
        DB::beginTransaction();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients,email,' . $patient->id,
            'address' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string'
        ]);

        $patient->update($validated);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Patient updated successfully',
            'patient' => $patient
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => 'Error updating patient: ' . $e->getMessage()
        ], 500);
    }
}

    public function show(Patient $patient)
    {
        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        try {
            DB::beginTransaction();
    
            $patient->forceDelete();
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Patient deleted successfully'
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting patient: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting patient: ' . $e->getMessage()
            ], 500);
        }
    }
}
