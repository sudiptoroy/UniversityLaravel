<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\University;
use App\Department;
use App\UniversityDepartmentMapper;
use Validator;

class UniversityController extends Controller
{
    public function getListOfUniversity() {
    	$success = true;
    	$universities = University::all();
    	return response()->json(['success' => $success, 'data' => $universities]);
    }

    public function getListOfDepartmentByUniversity(Request $request) {
    	$success = false;
    	$validator = Validator::make($request->all(), [
    		'university_id' => 'required'
    	]);

    	if ($validator->fails()) {
    		$message = $validator->errors()->all();
    		return response()->json(['success' => $success, 'message' => $message]);
    	}

    	$success = true;
    	if (UniversityDepartmentMapper::where('university_id', $request->university_id)->exists()) {
    		$departments = Department::select('departments.id', 'name', 'number_of_students')
    							->join('university_department_mappers', 'departments.id', 'university_department_mappers.department_id')
    							->where('university_department_mappers.university_id', $request->university_id)
    							->get();
    	} else {
    		$success = false;
    		$message = 'Invalid university id';
    		return response()->json(['success' => $success, 'message' => $message]);
    	}

		return response()->json(['success' => $success, 'data' => $departments]);    
	}


	public function updateUniversity(Request $request) {
    	$success = false;
    	$validator = Validator::make($request->all(), [
    		'university_id' => 'required',
    		'name' => 'required',
    		'address' => 'required'
    	]);

    	if ($validator->fails()) {
    		$message = $validator->errors()->all();
    		return response()->json(['success' => $success, 'message' => $message]);
    	}

    	$success = true;
    	$message = 'University updated successfully!';
    	if (University::where('id', $request->university_id)->exists()) {
    		$university = University::findOrFail($request->university_id);
    		$university->name = $request->name;
    		$university->address = $request->address;
    		$university->save();
    	} else {
    		$success = false;
    		$message = 'Invalid university id';
    		return response()->json(['success' => $success, 'message' => $message]);
    	}

		return response()->json(['success' => $success, 'message' => $message, 'data' => $university]);    
	}
}
