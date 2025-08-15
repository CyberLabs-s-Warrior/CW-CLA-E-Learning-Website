<?php

namespace App\Http\Controllers;

use App\Models\DetailCourse;
use App\Models\Course;
use Illuminate\Http\Request;

class DetailCourseClientController extends Controller
{
public function index($courseName)
{
    $courseName = urldecode($courseName);

    // Cari course berdasarkan nama
    $course =  Course::where('name', $courseName)->firstOrFail();

    // Cari detail course yang terkait dengan course tersebut
    $detailCourse = DetailCourse::where('course_id', $course->id)->firstOrFail();

    return view('clients.detail.index', compact('detailCourse'));
}


}