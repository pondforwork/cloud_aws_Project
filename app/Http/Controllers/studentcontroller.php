<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class studentcontroller extends Controller
{
    public function index()
    {
        return view('student.student');
    }

    public function getList()
    {
        $students = DB::select('SELECT * FROM student');
        return response()->json($students);
    }
}
