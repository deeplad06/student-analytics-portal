<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Result;
use App\Models\Faculty;

class FacultyController extends Controller
{
    public function dashboard()
    {
        $faculty = auth()->user()->faculty()->with('subject')->first();
        if (!$faculty) {
            abort(404, 'Faculty profile not found.');
        }

        $subject = $faculty->subject;

        $results = Result::with('student.user')->where('subject_id', $subject->id)->get();

        $analytics = [
            'total_students' => $results->count(),
            'average' => $results->avg('marks') ?? 0,
            'highest' => $results->max('marks') ?? 0,
            'lowest' => $results->min('marks') ?? 0,
            'passed' => $results->where('marks', '>=', 40)->count(),
            'failed' => $results->where('marks', '<', 40)->count(),
        ];

        return view('faculty.dashboard', compact('subject', 'results', 'analytics'));
    }

    public function updateMarks(Request $request)
    {
        $request->validate([
            'result_id' => 'required|exists:results,id',
            'marks' => 'required|integer|min:0|max:100',
        ]);

        $faculty = auth()->user()->faculty;
        $result = Result::where('id', $request->result_id)
                        ->where('subject_id', $faculty->subject_id)
                        ->firstOrFail();

        $result->marks = $request->marks;
        $result->save();

        $results = Result::where('subject_id', $faculty->subject_id)->get();
        $analytics = [
            'average' => round($results->avg('marks') ?? 0, 2),
            'highest' => $results->max('marks') ?? 0,
            'lowest' => $results->min('marks') ?? 0,
            'passed' => $results->where('marks', '>=', 40)->count(),
            'failed' => $results->where('marks', '<', 40)->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Marks updated successfully',
            'analytics' => $analytics
        ]);
    }
}
