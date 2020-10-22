<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
    	$students = Student::orderBy('id', 'DESC')->get();
    	return view('students', compact('students'));
    }

    public function addStudent(Request $request){
    	$student = new Student();

    	$student->firstname = $request->firstname;
    	$student->lastname  = $request->lastname;
    	$student->email     = $request->email;
    	$student->phone 	= $request->phone;

    	$student->save();
    	return response()->json();
    }

    public function getStudentById($id){
    	$student = Student::find($id);
    	return response()->json($student);
    }

    public function updateStudent(Request $request){
    	$student = Student::find($request->id);
    	$student->firstname = $request->firstname;
    	$student->lastname = $request->lastname;
    	$student->email = $request->email;
    	$student->phone = $request->phone;
    	$student->save();

    	return response()->json($student);
    }

    public function deleteStudent($id){
    	$student = Student::find($id);
    	$student->delete();
    	return response()->json(['success'=>'record is successfully deleted']);
    }
}
