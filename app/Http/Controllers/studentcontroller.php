<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

    public function saveData(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'year' => 'required|integer|min:1',
            'sex' => 'required|in:m,f',
        ]);

        try {
            // Prepare a raw SQL insert statement
            DB::insert('INSERT INTO student (name, surname, age, year, sex, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)', [
                $validatedData['name'],
                $validatedData['surname'],
                $validatedData['age'],
                $validatedData['year'],
                $validatedData['sex'],
                now(),
                now(),
            ]);

            return response()->json(200);

        } catch (QueryException $e) {
            // Log the exception message (optional)
            \Log::error('Database Query Error: ' . $e->getMessage());

            return response()->json(['error' => 'Could not save data.'], 500); // Return 500 Internal Server Error
        }
    }
}
