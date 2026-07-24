<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Subjects
        $python = \App\Models\Subject::create(['name' => 'Python']);
        $c = \App\Models\Subject::create(['name' => 'C Programming']);
        $java = \App\Models\Subject::create(['name' => 'Java']);

        // Create Faculties
        $f1 = User::create(['name' => 'Python Faculty', 'email' => 'python@faculty.com', 'password' => bcrypt('password'), 'role' => 'faculty']);
        \App\Models\Faculty::create(['user_id' => $f1->id, 'subject_id' => $python->id]);

        $f2 = User::create(['name' => 'C Faculty', 'email' => 'c@faculty.com', 'password' => bcrypt('password'), 'role' => 'faculty']);
        \App\Models\Faculty::create(['user_id' => $f2->id, 'subject_id' => $c->id]);

        $f3 = User::create(['name' => 'Java Faculty', 'email' => 'java@faculty.com', 'password' => bcrypt('password'), 'role' => 'faculty']);
        \App\Models\Faculty::create(['user_id' => $f3->id, 'subject_id' => $java->id]);

        // Create Students and Results
        $studentNames = ['Rahul', 'Shruti', 'Kavya', 'Prathm', 'Bhavik','Deep'];
        
        foreach ($studentNames as $index => $name) {
            $email = strtolower($name) . '@student.com';
            $user = User::create(['name' => $name, 'email' => $email, 'password' => bcrypt('password'), 'role' => 'student']);
            $student = \App\Models\Student::create(['user_id' => $user->id, 'roll_number' => "STU100" . ($index + 1)]);

            \App\Models\Result::create(['student_id' => $student->id, 'subject_id' => $python->id, 'marks' => rand(30, 100)]);
            \App\Models\Result::create(['student_id' => $student->id, 'subject_id' => $c->id, 'marks' => rand(30, 100)]);
            \App\Models\Result::create(['student_id' => $student->id, 'subject_id' => $java->id, 'marks' => rand(30, 100)]);
        }
    }
}
