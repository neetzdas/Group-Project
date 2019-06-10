  <table id = "studentsTable">
    <tr>
      <th>S.N.</th>
      <th>Login ID</th>
      <th>Full Name</th>
      <th>Gender</th>
      <th>Birthdate</th>
      <th>Level</th>
      <th>Course</th>
      <th>Email</th>
      <th>Manage</th>
      <th>Status</th>
    </tr>
    <?php

    $count = 0;
      while($user = $users->fetch()){
        $student=getStudentById($user['uid'])->fetch();
        $enCourse = getCourseById($student['cid'])->fetch();
        $enLevel = getLevelById($student['slvid'])->fetch();

        $viewIcon = '<a href = "/GroupProject/public/ManageStudents/browse/'.$user['uid'].'">
                          <img class = "tableIcon" src = "/GroupProject/public/resources/images/view.svg">
                        </a>';

        $archiveIcon = '<a href = "/GroupProject/public/ManageStudents/archive/'.$user['uid'].'">
                          <img class = "tableIcon" src = "/GroupProject/public/resources/images/archive.svg">
                        </a>';
        $statusText = $student['rstatus']=="Live" ? '<font color = "green">Live</font>':
                                                           '<font color = "red">Dormant</font>';

        $count++;
        echo '<tr>
                <td>'.$count.'</td>
                <td>'.$user['uid'].'</td>
                <td>'.$user['fname'].' '.$user['mname'].' '.$user['lname'].'</td>
                <td>'.$user['gender'].'</td>
                <td>'.$user['birthdate'].'</td>
                <td>'.$enLevel['lvtitle'].'</td>
                <td>'.$enCourse['ctitle'].'</td>
                <td><a href = "mailto:'.$user['uemail'].'">'.$user['uemail'].'</a></td>
                <td>'.$viewIcon.' &nbsp;'.$archiveIcon.'</td>
                <td>'.$statusText.'</td>';
      }
    ?>
  </table>
