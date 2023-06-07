<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Marks;
use App\Models\Student;
use App\Models\Subjects;
use App\Models\Teacher;
use App\Models\User;
use Date;
use DB;
use Hash;
use http\Env\Response;
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
        if (!is_null($request->input('name'))){
            $user->name = $request->input('name');
        }
        if (!is_null($request->input('is_verified'))){
            $user->is_verified = $request->input('is_verified');
        }
        if (!is_null($request->input('is_teacher'))){
            $user->is_teacher = $request->input('is_teacher');
        }
        if (!is_null($request->input('password'))){
            $user->password = Hash::make($request->input('password'));
        }
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
        $class = $request->input('class_id');
        $user = User::where('email','=',$request->input('email'))->first();
        if ($user != null){
            if (Student::where('UserID', '=', $user->id)->first() != null){
                return response()->json(['message' => 'Пользователь уже существует!'], 409);
            }
            if (Teacher::where('UserID', '=', $user->id)->first() != null) {
                return response()->json(['message' => 'Этот пользователь является учителем!'],409);
            }
            return response()->json(['message' => 'Обратитесь к администратору']);
        }
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->is_verified = false;
        $user->is_teacher = false;
        $user->save();

        $student = new Student;
        $student->UserID = $user->id;
        $student->class_id = $class;
        $student->save();

        return response()->json([
            'message' => 'Студент создан успешно!',
            'user' => $user,
            'group' => $student->class_id,
        ], 201);
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
        $student = Student::where('UserID','=',$id)->first();

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
        $user = User::where('email','=', $request->input('email'))->first();
        echo $user;
        if ($user != null){
            if (Student::where('UserID', '=', $user->id)->first() != null){
                return response()->json(['message' => 'Этот пользователь является студентом!'], 409);
            }
            if (Teacher::where('UserID', '=', $user->id)->first() != null) {
                return response()->json(['message' => 'Пользователь уже существует!'],409);
            }
            return response()->json(['message' => 'Обратитесь к администратору']);
        }
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->is_verified = false;
        $user->is_teacher = true;
        $user->save();

        $teacher = new Teacher;
        $teacher->UserID = $user->id;
        $teacher->Qualification = $request->input('qualification');
        $teacher->save();

        return response()->json([
            'message' => 'Учитель создан успешно!',
            'user' => $user,
        ], 201);

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
        $teachers = Teacher::with('user')->get();
        return response()->json($teachers);
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
        $result = Classes::create($class);
        return response()->json($result, 201);
    }
    public function deleteClass($id)
    {
        $class = Classes::findOrFail($id);
        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        if (Student::where('class_id','=',$class->id)->count() > 0){
            return response()->json(['message' => 'Невозможно удалить класс так как в нем находятся студенты!'], 422);
        }
        $class->delete();
        return response()->json(['message' => 'Удалено']);
    }
    public function getClasses()
    {
        return response(Classes::all());
    }
    public function getClass($id)
    {
        $class = Classes::find($id);

        if (!$class) {
            return response()->json(['message' => 'Class not found'], 404);
        }

        return response()->json($class);
    }
    public function getStudentsByGroupId($groupId) {
        $students = Student::where('class_id', '=', $groupId)->get();
        $userIds = [];
        foreach ($students as $student) {
            $userIds[] = $student->UserID;
        }
        $users = User::whereIn('id', $userIds)->with('student')->get();
        return $users;
    }
    public function getSubjectsOfGroup($groupId){
        $subjects = Subjects::with('teacher.user')->where('classID','=',$groupId)->get();
        return response()->json($subjects);
    }

    public function getMarksFromCurrentSubject(Request $request)
    {
        $subjectID = $request->input('subject_id');
        //return response()->json(Marks::where('case_id', '=', $subjectID)->get());
        return response()->json(Marks::where('case_id', '=', $subjectID)->get());
    }
    public function markAddOrUpdate(Request $request){
        $month = $request->input('month');
        $day = $request->input('day');
        $year = $request->input('year');
        $date = mktime(0,0,0,$month, $day, $year);
        $mark = Marks::where('case_id', $request->input('case_id'))
            ->where('student_id', $request->input('student_id'))
            ->where('date', date('Y-m-d', $date))->first();
        echo $mark;
        if ($mark){
            $mark->mark = $request->input('mark');
            $mark->save();
            return response()->json(['message' => "Оценка изменена"]);
        };
        $mark = new Marks;
        $mark->case_id = $request->input('case_id');
        $mark->student_id = $request->input('student_id');
        $mark->date = date('Y-m-d', $date);
        $mark->mark = $request->input('mark');
        $mark->save();
        return response()->json(['message'=>'Оценка поствлена']);
    }
    public function getMark(Request $request){
        $studentID = $request->input('student_id');
        $caseID = $request->input('case_id');
        $date = $request->input('date');
        $answer = Marks::where('case_id','=',$caseID)
            ->where('student_id', '=', $studentID)
            ->where('date', '=', $date)
            ->first('mark');
        if ($answer==null){
            return response()->json(['mark'=> '-']);
        }
        return response()->json(
            $answer
        );
    }
}

