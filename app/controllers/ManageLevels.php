<?php

  class ManageLevels extends Controller{

    public function index($val = ""){
      $levelClass = new DatabaseTable('levels');
      $levels = $levelClass->findAll();

      $manage = "levels";
      $template = '../app/views/administrators/userNote.php';
      $note = loadTemplate($template, ['val'=>$val, 'manage'=>$manage]);


      $template = '../app/views/administrators/manageLevels.php';
      $content = loadTemplate($template, ['levels'=>$levels, 'val'=>$val, 'note'=>$note]);
      $selected = "Levels";
      $title = "Admin - Levels";

      require_once "../app/controllers/adminLoadView.php";

    }

    public function add(){
      $levelClass = new DatabaseTable('levels');

      if(isset($_POST['submit'])){
        $levelClass->save($_POST['level']);
        header("Location:../ManageLevels/index/addsuccess");
      }

      $template = '../app/views/administrators/addLevel.php';
      $content = loadTemplate($template, []);
      $selected = "Levels";
      $title = "Admin - Add new Level";

      require_once "../app/controllers/adminLoadView.php";
    }

    public function browse($val = ""){
      $levelClass = new DatabaseTable('levels');
      $level = $levelClass->find('lvid',$val);

      if($level->rowCount()>0){
        if(isset($_POST['submit'])){
          $_POST['level']['lvid']=$val;
          $levelClass->save($_POST['level'], 'lvid');
          header("Location:../index/editsuccess");
        }

        if(findStudentInLevel($val)>0 || findModulesInLevel($val)>0)
          $link = false;
        else
          $link = '/GroupProject/public/ManageLevels/delete/'.$val;

        $template = '../app/views/administrators/modal.php';
        $modal = loadTemplate($template, ['type'=>'Level', 'link'=>$link]);

        $template = '../app/views/administrators/addLevel.php';
        $content = loadTemplate($template, ['level'=>$level, 'modal'=>$modal]);
        $selected = "Levels";
        $title = "Admin - Browse Level";
        require_once "../app/controllers/adminLoadView.php";
      }

      else{
        header("Location:../index/nosuchrecord");
      }

    }

    public function delete($val = ""){
      $levelClass = new DatabaseTable('levels');
      $level = $levelClass->find('lvid',$val);

      if($level->rowCount()>0){
        $levelClass->delete('lvid', $val);
        header("Location:../index/deletesuccess");
      }
      else{
        header("Location:../index/nosuchrecord");
      }

    }



  }

?>
