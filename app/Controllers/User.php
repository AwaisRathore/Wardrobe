<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\StudentNoteModel;
use App\Models\GuardianModel;
use App\Models\TestModel;
use App\Models\SessionModel;
use App\Models\SessionFieldsModel;
use App\Models\LessonModel;
use App\Models\CourseModel;
use App\Models\ClassesModel;
use App\Models\FormModel;

class User extends BaseController
{
    private $userModel = null;
    private $lessonModel = null;
    private $roleModle = null;
    private $studentNoteModel = null;
    private $testModel = null;
    private $sessionModel = null;
    private $courseModel = null;
    private $classModel = null;
    private $formModel = null;
    private $auth = null;
    private $guardianModel = null;
    private $sessionFieldModel = null;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModle = new RoleModel();
        $this->formModel = new FormModel();
        $this->studentNoteModel = new StudentNoteModel();
        $this->guardianModel = new GuardianModel();
        $this->testModel = new TestModel();
        $this->sessionModel = new SessionModel();
        $this->lessonModel = new LessonModel();
        $this->courseModel = new CourseModel();
        $this->classModel = new ClassesModel();
        $this->sessionFieldModel = new SessionFieldsModel();
        $this->auth = service("auth");
    }
    public function index($role = "all")
    {
        if (!$this->auth->getUserRole()->CanViewUsers) {
            return redirect()->to("Dashboard")->with('warning', "You do not have rights to perform this operation.");
        }
        $role = strtolower($role);
        $loggedInUser = $this->auth->getUserRole();
        $users = null;
        switch ($role) {
            case "teacher":
                if (in_array($loggedInUser->Id, [ADMIN, SUPERADMIN, SEGRETARY])) {
                    $users = $this->userModel->where('RoleId', TEACHER)->findAll();
                }
                break;
            case "student":
                if (in_array($loggedInUser->Id, [ADMIN, SUPERADMIN, SEGRETARY, TEACHER])) {
                    $users = $this->userModel->where('RoleId', STUDENT)->findAll();
                }
                break;
            case "segretary":
                if (in_array($loggedInUser->Id, [ADMIN, SUPERADMIN])) {
                    $users = $this->userModel->where('RoleId', SEGRETARY)->findAll();
                }
                break;
            case "admin":
                if (in_array($loggedInUser->Id, [SUPERADMIN])) {
                    $users = $this->userModel->where('RoleId', ADMIN)->findAll();
                }
                break;
            case "superadmin":
                if (in_array($loggedInUser->Id, [SUPERADMIN])) {
                    $users = $this->userModel->where('RoleId', SUPERADMIN)->findAll();
                }
                break;
            default:
                $users = $this->getUsersAccessibleByRole($loggedInUser->Id);
                break;
        }
        // dd($users);
        return view(
            'User/index',
            [
                "RoleName" => $role,
                "users" => $users
            ]
        );
    }
    public function edit($id)
    {
        if (!$this->auth->getUserRole()->CanEditUsers) {
            return redirect()->to("Dashboard")->with('warning', "You do not have rights to perform this operation.");
        }
        if ($this->auth->getCurrentUser()->Id == $id) {
            return redirect()->back()->with('warning', "Sorry. You can't edit your account from here. If you want to update something. Please go to Profile section.");
        }
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('warning', "Sorry ! The user you are trying to edit does not exisits.");
        }
        if ($this->request->getMethod() == 'post') {
            $user = new \App\Entities\User($this->request->getPost());
            $userInDb = $this->userModel->find($id);
            if ($userInDb != null) {
                //map the fields to update
                $userInDb->Firstname = $user->Firstname;
                $userInDb->Lastname = $user->Lastname;
                $userInDb->PhoneNo = $user->PhoneNo;
                $userInDb->Email = $user->Email;
                $userInDb->Dob = $user->Dob;
                $userInDb->HighSchoolStatus = $user->HighSchoolStatus;
                $userInDb->RoleId = $user->RoleId;
                //update the user in db with new values
                if ($userInDb->hasChanged()) {
                    $result = $this->userModel->update($userInDb->Id, $userInDb);
                    if ($result) {
                        return redirect()->to("User")->with("success", "User record updated successfully.");
                    } else {
                        return redirect()->back()->with("errors", $this->userModel->errors())->with("warning", "Error: Please fix the errors.")->withInput();
                    }
                } else {
                    return redirect()->to(current_url())->with("success", "There's nothing to update.");
                }
            } else {
                return redirect()->back()->with('warning', "Unable to update the user. Invalid Request");
            }
        }
        $roles = $this->roleModle->findAll();
        return view("User/edit", [
            'user' => $user,
            'roles' => $roles
        ]);
    }
    public function delete($id)
    {
        if (!$this->auth->getUserRole()->CanDeleteUsers) {
            return redirect()->to("Dashboard")->with('warning', "You do not have rights to perform this operation.");
        }
        if ($this->auth->getCurrentUser()->Id == $id) {
            return redirect()->back()->with('warning', "Sorry. You can not delete your own account");
        }
        $user = $this->userModel->find($id);
        if ($user) {
            if ($this->userModel->delete($user->Id)) {
                return redirect()->to('User/index')->with('success', 'User deleted successfully.');
            }
        } else {
            return redirect()->back()->with('warning', "User you are trying to delete does not exists.");
        }
    }
    public function updatePassword($id)
    {
        $data = [];
        $loggedInUserRole = $this->auth->getUserRole();
        if ($loggedInUserRole->Id != SUPERADMIN) {
            return redirect()->back()->with('warning', "Sorry ! You are not authorized to perform this operation.");
        }
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Password' => [
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => 'Password is a required field.',
                        'min_length' => 'Password should be at least 8 characters long.'
                    ]
                ],
            ];
            if ($this->validate($rules)) {
                $password = $this->request->getVar('Password');
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                //update user password here
                $userModel = new UserModel();
                $result = $userModel->updatePassword($id, $password_hash);
                if ($result) {
                    return redirect()->to(current_url())->with("success", "Password updated successfully");
                } else {
                    session()->setFlashdata('error', 'Sorry. We are facing some issue . Please try again later');
                }
            } else {
                session()->setFlashdata('error', 'Please fix the below errors');
                $data['validation'] = $this->validator;
            }
        }
        return view("User/updatePassword", $data);
    }
    public function sessionInfoDetail($Id)
    {
        if (!$this->auth->getUserRole()->CanViewSessions) {
            return redirect()->to("Dashboard")->with('warning', "You do not have rights to perform this operation.");
        }
        $Sessions = $this->sessionModel->getSessionById($Id);
        if (!empty($Sessions)) {
        } else {
            return redirect()->back()->with('warning', "Session you are trying to view does not exists.");
        }
        $session_Score = $this->sessionModel->getScoresByStudentId($Sessions[0]->StudentId);
        $fields = $this->sessionFieldModel->findAll();
        $Scores = [];
        foreach ($fields as $key => $field) {
            $Scores[$key] = ["Id" => $field->Id, "Name" => $field->Name, "Score" => 0];
            foreach ($session_Score as $session) {
                if ($field->Id == $session["fieldId"]) {
                    $Scores[$key]['Score'] += $session['Score'];
                }
            }
        }
        $IndividualScore = $this->sessionModel->getIndividualScore($Id);
        return view("User/sessionInfoDetail", ["Session" => $Sessions, "student" => $this->userModel->find($Sessions[0]->StudentId), 'Scores' => $Scores, "IndividualScore" => $IndividualScore]);
    }
    private function getUsersAccessibleByRole($loggedInUserRoleId)
    {
        switch ($loggedInUserRoleId) {
            case SUPERADMIN:
                return $this->userModel->findAll();
            case ADMIN:
                return $this->userModel->where('RoleId > ', ADMIN)->findAll();
                break;
            case SEGRETARY:
                return $this->userModel->where('RoleId > ', SEGRETARY)->findAll();
                break;
            case TEACHER:
                return $this->userModel->where('RoleId > ', TEACHER)->findAll();
                break;
        }
    }
    public function studentInfo($StudentId)
    {
        $student = $this->userModel->find($StudentId);
        $Sessions = $this->sessionModel->getSessionByStudentId($StudentId);
        $session_Score = $this->sessionModel->getScoresByStudentId($StudentId);
        $courses = $this->courseModel->getCoursesByStudent($StudentId);
        $classes = $this->classModel->getClassesByStudent($StudentId);
        $fields = $this->sessionFieldModel->findAll();
        $Scores = [];
        foreach ($fields as $key => $field) {
            $Scores[$key] = ["Id" => $field->Id, "Name" => $field->Name, "Score" => 0];
            foreach ($session_Score as $session) {
                if ($field->Id == $session["fieldId"]) {
                    $Scores[$key]['Score'] += $session['Score'];
                }
            }
        }
        $student_form = $this->formModel->getStudentFormInformations($StudentId);
        $sorted_student_form_checks = [];
        if (count($student_form) > 0) {
            array_push($sorted_student_form_checks, [
                'title' => 'Orientamento',
                'checked' => $student_form[0]->orientamento
            ]);
            array_push($sorted_student_form_checks, [
                'title' => 'Metodo',
                'checked' => $student_form[0]->metodo
            ]);
            array_push($sorted_student_form_checks, [
                'title' => 'Organizzazione',
                'checked' => $student_form[0]->organizzazione
            ]);
            array_push($sorted_student_form_checks, [
                'title' => 'Logica',
                'checked' => $student_form[0]->logica
            ]);
            array_push($sorted_student_form_checks, [
                'title' => 'Matematica',
                'checked' => $student_form[0]->matematica
            ]);
            array_push($sorted_student_form_checks, [
                'title' => 'Atteggiamento',
                'checked' => $student_form[0]->atteggiamento
            ]);
            array_multisort(array_column($sorted_student_form_checks, 'checked'), SORT_DESC, $sorted_student_form_checks);
        }
        $lessons = $this->lessonModel->getLessonsInformationByStudentId($StudentId);
        return view(
            'User/studentInfo',
            [
                'student' => $student, 'StudentId' => $StudentId, 'notes' => $this->studentNoteModel->getAllNotes($StudentId), 'guardians' => $this->guardianModel->getAllGuardians($StudentId), 'tests' => $this->testModel->getTestStudentBasedOnStudent($StudentId), 'scores' => $Scores, 'sessions' => $Sessions, 'lessons' => $lessons, 'courses' => $courses, 'classes' => $classes, 'student_form' => $student_form, 'sorted_student_form_checks' => $sorted_student_form_checks
            ]
        );
    }
}
