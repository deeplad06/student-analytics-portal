<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Result;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user()->student;
        if (!$student) {
            abort(404, 'Student profile not found.');
        }

        $results = Result::with('subject')->where('student_id', $student->id)->get();

        $totalMarks = $results->sum('marks');
        $averageMarks = round($results->avg('marks') ?? 0, 2);
        
        $highestSubject = $results->sortByDesc('marks')->first();
        $lowestSubject = $results->sortBy('marks')->first();
        
        $overallStatus = $averageMarks >= 40 ? 'Pass' : 'Fail';
        if ($results->where('marks', '<', 40)->count() > 0) {
             $overallStatus = 'Fail';
        }

        $chartLabels = $results->pluck('subject.name');
        $chartData = $results->pluck('marks');

        return view('student.dashboard', compact(
            'student', 
            'results', 
            'totalMarks', 
            'averageMarks', 
            'highestSubject', 
            'lowestSubject', 
            'overallStatus',
            'chartLabels',
            'chartData'
        ));
    }
}
