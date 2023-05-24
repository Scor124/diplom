<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Date;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Testing\Concerns\Has;

class APIDataController extends Controller
{

    public function createUser(Request $request)
    {
        // Получаем данные из запроса
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        // Хешируем пароль с помощью Hash::make()
        $hashedPassword = Hash::make($password);

        // Создаем нового пользователя в базе данных
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $hashedPassword;
        $user->save();

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->is_verified = $request->input('is_verified');
        $user->is_teacher = $request->input('is_teacher');
        //$user->fill($request->all());
        $user->save();

        return response()->json([
            'message' => 'User update successfully',
            'data' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function getUsers()
    {
        return response(User::all());
    }
    public function createStudent(Request $request)
    {
        $student = $request->all();

        if (Student::where('UserID', $student['UserID'])->exists()) {
            return response()->json(['message' => 'User already exists in students table'], 409);
        }

        $result = Student::create($student);

        return response()->json($result, 201);
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->fill($request->all());

        if (Student::where('UserId', $student['UserId'])->where('id', '!=', $id)->exists()) {
            return response()->json(['message' => 'User already exists in students table'], 409);
        }

        $student->save();

        return response()->json($student);
    }

    public function deleteStudent($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted']);
    }
    public function getStudents()
    {
        return response()->json(Student::all());
    }
    public function getStudent($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    public function createTeacher(Request $request)
    {
        $teacher = $request->all();

        if (Teacher::where('UserId', $teacher['user_id'])->exists()
            || Student::where('UserId', $teacher['UserId'])->exists()) {
            return response()->json(['message' =>
                'User already exists in teachers or students table'], 409);
        }

        $result = Teacher::create($teacher);

        return response()->json($result, 201);
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $teacher->fill($request->all());

        if (Teacher::where('UserId', $teacher['UserId'])->where('id', '!=', $id)->exists()
            || Student::where('UserId', $teacher['UserId'])->exists()) {
            return response()->json(['message' => 'User already exists in teachers or students table'], 409);
        }

        $teacher->save();

        return response()->json($teacher);
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted']);
    }

    public function getTeachers()
    {
        return response()->json(Teacher::all());
    }
    public function getTeacher($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        return response()->json($teacher);
    }

    public function createClass(Request $request)
    {
        $class = $request->all();

        if (!Teacher::find($class['teacher_id'])) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $result = Classes::create($class);

        return response()->json($result, 201);
    }

    public function updateClass(Request $request, $id)
    {
        $class = Classes::find($id);

        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->fill($request->all());

        if (!Teacher::find($class['teacher_id'])) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $class->save();

        return response()->json($class);
    }

    public function deleteClass($id)
    {
        $class = Classes::find($id);

        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        $class->delete();

        return response()->json(['message' => 'Class deleted']);
    }
    public function getClasses()
    {
        return response(Classes::all());
        //return response()->json(Classes::all());
    }
    public function getClass($id)
    {
        $class = Classes::find($id);

        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        return response()->json($class);
    }
}
