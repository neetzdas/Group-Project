<?php

  class StudentModules extends Controller{

    public function index($var = ""){
      $studentClass = new DatabaseTable('students');
      $moduleClass = new DatabaseTable('modules');

      if (session_status() == PHP_SESSION_NONE) {
      	session_start();
      }
      $student = $studentClass->find('suid', $_SESSION['loggedin']['uid'])->fetch();
      $modules = findStudentModules($student['cid'], $student['slvid']);

      $template = '../app/views/students/studentModules.php';
      $content = loadTemplate($template, ['modules'=>$modules, 'var'=>$var]);

      $title = "Student - Modules";
      $selected = "Modules";
      require_once "../app/controllers/studentLoadView.php";
    }

    public function moduleTerm($val = ""){
      if (session_status() == PHP_SESSION_NONE) {
      	session_start();
      }

      $termClass = new DatabaseTable("terms");
      $moduleClass = new DatabaseTable("modules");
      $assignmentstudentsClass = new DatabaseTable("assignment_students");

      $term = $termClass->find('tid', $val);
      $term = $term->fetch();

      if($val==""){
        header("Location: ../StudentModules");
      }

      //Call the function to set term's status before displaying
      $term = setTermStatus($term);

      $module = $moduleClass->find('mid', $term['tmid']);
      $module = $module->fetch();

      $template = '../app/views/students/moduleTerm.php';
      $content = loadTemplate($template, ['module'=>$module, 'term'=>$term]);
      $selected='Modules';
      $title = "Student - Term";

      require_once "../app/controllers/studentLoadView.php";


    }

    public function submitWork($val=""){
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }


      if($val==""){
        header("Location: ../StudentModules");
      }

      $assignmentstudentsClass = new DatabaseTable("assignment_students");
      $assignmentClass = new DatabaseTable("assignments");
      $termClass = new DatabaseTable("terms");
      $moduleClass = new DatabaseTable("modules");


      $assignment = $assignmentClass->find('aid', $val)->fetch();
      $term = $termClass->find('tid', $assignment['atid'])->fetch();
      $module = $moduleClass->find('mid', $term['tmid'])->fetch();

      if(isset($_POST['submitAssignment'])){
        print_r($_POST);

        $target_dir = "resources/submissions/";
        $target_file = $target_dir.microtime(true).'-'.basename($_FILES["submissionFile"]["name"]);
        $target_file = str_replace(' ', '_', $target_file);

        move_uploaded_file($_FILES["submissionFile"]["tmp_name"], $target_file);
        $_POST['submission']['asfiles']=$target_file;

        $assignmentstudentsClass->save($_POST['submission']);
        header("Location:/GroupProject/public/StudentModules/index/addsuccess");
      }

      $template = '../app/views/students/submitWork.php';
      $content = loadTemplate($template, ['assignment'=>$assignment, 'term'=>$term, 'module'=>$module]);
      $selected='Modules';
      $title = "Student - Submit Your Work";
      require_once "../app/controllers/studentLoadView.php";

    }


  }

?>
