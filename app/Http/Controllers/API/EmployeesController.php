<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    public function index()
    {
        try {
            $employees = Employes::orderBy('id', 'desc')->get();
            return response()->json(['success' => true, 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('Failed to fetch data employees : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], 422);
        }

        try {
            $employees = Employes::create([
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'gender' => $request->gender
            ]);
            return response()->json(['success' => true, 'message' => 'Employee created successfully', 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('Failed to create employee : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to Create Employee'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $employees = Employes::with('user')->findOrFail($id);
            return response()->json(['success' => true, 'messages' => 'Employee found successfully', 'data' => $employees]);
        } catch (\Throwable $th) {
            Log::error('Failed to fetch data employee : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], 422);
        }

        try {
            $data = [
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'gender' => $request->gender
            ];
            $employees = Employes::with('user')->findOrFail($id);
            $employees->update($data);
        } catch (\Throwable $th) {
            Log::error('Failed to update employee : ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to Update Employee'
            ], 500);
        }
    }
}
