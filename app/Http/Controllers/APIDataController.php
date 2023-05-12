<?php

namespace App\Http\Controllers;

class APIDataController extends Controller
{
    public function data()
    {

        $users = \App\Models\User::all();
        return response()->json([
            'users' => $users,
            'students' => $students,
            'classes' => $classes
        ]);
    }
    public function getUsers()
    {

    }
    public function index()
    {

    }
}
