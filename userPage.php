
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="navbar.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="mystyle.css" rel="stylesheet">
    

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <script type="text/javascript" language="javascript" src="jquery-2.2.3.js">
  </script>

<!--  
   <link rel="stylesheet" type="text/css" href="jquery.dataTables.min.css">
    <script type="text/javascript" language="javascript" href="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js">
  </script> -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
  <script type="text/javascript" language="javascript" href="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js">
  </script>
 



    <link rel="icon" href="favicon.ico" />
</head>
<title> League Of Legends 151 </title>

<!--<body> --> 
<body background="leagueWallpaper2.jpeg" style= "background-attachment: fixed; background-repeat: no-repeat;" >

<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a role="button" class="navbar-brand" onClick="userPage.php"><img src="icon-game-lol.png" alt="..."></a>
            </div>
             <ul class="nav navbar-nav">
              <li><a href="http://gameinfo.na.leagueoflegends.com/en/game-info/" role="button" aria-haspopup="true" aria-expanded="false">Game Info</a></li>
             </ul>
             <ul class="nav navbar-nav">
              <li><a href="http://na.leagueoflegends.com/en/news/" role="button" aria-haspopup="true" aria-expanded="false">News</a></li>
             </ul>
             <ul class="nav navbar-nav">
              <li><a href="http://www.lolesports.com/en_US" role="button" aria-haspopup="true" aria-expanded="false">Esports</a></li>
             </ul>
             <ul class="nav navbar-nav">
              <li><a href="https://www.twitch.tv/riotgames" role="button" aria-haspopup="true" aria-expanded="false">Twitch Stream</a></li>
             </ul>  
            <ul class="nav navbar-nav">
              <li><a href="https://www.youtube.com/user/RiotGamesInc" role="button" aria-haspopup="true" aria-expanded="false">YouTube Channel</a></li>
             </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                   <?php
                   session_start();
                  if(isset($_SESSION["username"]))
                  {
                echo "<p class='navbar-text' > Welcome, " ;
                   
          
                  echo $_SESSION["username"];
          
 
               echo   "</p> ";
                 }
                 else
                 {
                  echo "<p class='navbar-text' > Welcome, " ;
                  echo "Guest!";
                  echo "</p> ";
                 }

                   ?> 
                 
                </li>
              
               
            </ul>
            
        </div>

    </nav>
    <br>
       <nav class="navbar navbar-fixed-left navbar-minimal animate" role="navigation">
    <div class="navbar-toggler animate">
      <span class="menu-icon"></span>
    </div>
    <ul class="navbar-menu animate">
      <li>
        <a href="index.html" class="animate">
          <span class="desc animate"> Login Page </span>
          <span class="glyphicon glyphicon-home"></span>
        </a>
      </li>
      <li>
        <a href="userPage.php" class="animate">
          <span class="desc animate"> Champion Page </span>
          <span class="glyphicon glyphicon-th-list"></span>
        </a>
      </li>
      <li>
        <a data-toggle="modal" data-target="#myModal" class="animate">
          <span class="desc animate" > Add a Champion </span>
          <span class="glyphicon glyphicon-plus"></span>
        </a>
      </li>
      <li>
        <a data-toggle="modal" data-target="#deleteModal" class="animate">
          <span class="desc animate" > Delete a Champion </span>
          <span class="glyphicon glyphicon-minus"></span>
        </a>
      </li>
      <li>
        <a  data-toggle="modal" data-target="#editting" class="animate">
          <span class="desc animate" > Edit a Champion </span>
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
      </li>
   
      <li>
        <a  href = "logout.php" class="animate">
          <span class="desc animate" > Log Out </span>
          <span class="glyphicon glyphicon-off"></span>
        </a>
      </li>
    </ul>
  </nav>

   <div id = "userContainer">
   <div class = "userTable"> 
   
    <div class="form-group">
   <h1 style="padding: 0.5cm color:white;">Champion List</h1> 
   </div>
   <br>
   <br>
<?php
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
  }

 
  $stid = oci_parse($conn, 'SELECT c.ID, c.champName as Champion, s.RP as RP, s.IP as IP, t.champType as Role 
                            FROM champions c, champCost s, champtype t
                            WHERE c.champCost = s.id AND c.champType = t.id
                            ORDER BY CHAMPNAME');
oci_execute($stid);

  //prepare
 
  if(!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }

// logic
  $r = oci_execute($stid);
  if(!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }
// fetch 
  
  echo "<table id = 'championTable' class='table table-bordered' >\n";
  $ncols = oci_num_fields($stid);
  
echo "<thead>\n";
  for ($i=1;$i <=$ncols; $i++ )
  {
    $colname = oci_field_name($stid, $i);
  echo " <th><b>".htmlentities($colname, ENT_QUOTES)."</b></a>";
 // echo "<form method = 'post' action='updateUser.php'><button name = '$colname' type='submit'> <span class='glyphicon glyphicon-chevron-down'> </span></button></form>";
  echo " </th>\n";

  }
  echo "</thead>\n";
  while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
   // echo "<form method='POST' action='deleteChampion.php' accept-charset='UTF-8' id='userDelete'>\n";
    echo "<tr>\n";
    foreach ($row as $item) {
      echo "   <td >". ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") ."</td>\n";
    }
    echo "</tr>\n";
//  echo "</form>\n";

  }
  echo "</table>\n";
  oci_free_statement($stid);
  oci_close($conn);
  ?>
  
    </div>


    <!-- <form class="form" role="form" method="post" action="updateChampions.php" accept-charset="UTF-8" id="userUpdate">

          <div class="form-group">
           <label for="ChampionName">Champion Name</label>
            <input type="text" class="form-control" id="championName" name="champName" placeholder="Champion">
           </div>

           <div class="form-group">
            <label for="rp">RP Cost</label>
    <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT ID, RP 
                              FROM CHAMPCOST');
     
    oci_execute($stid);
  echo "<select class='form-control' name='RPcost'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['RP']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
         </div>
      
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
      <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT * 
                              FROM CHAMPTYPE');
     
    oci_execute($stid);
  echo "<select class = 'form-control'  name='chosenType'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['CHAMPTYPE']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
  </div>

           <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
         </div>
        </form> -->

  <!--  <div class="addChamp" style=""> 
    <!-- Button trigger modal
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Add a Champion
</button>
</div> -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add a Champion</h4>
      </div>
      <div class="modal-body">
         <form class="form" role="form"  method="post" action="updateChampions.php" accept-charset="UTF-8" id="userUpdate">

          <div class="form-group">
           <label for="ChampionName">Champion Name</label>
            <input type="text" class="form-control" id="championName" name="champName" placeholder="Champion">
           </div>

           <div class="form-group">
            <label for="rp">RP Cost</label>
          <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT ID, RP 
                              FROM CHAMPCOST');
     
    oci_execute($stid);
  echo "<select class='form-control' name='RPcost'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['RP']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
         </div>
      
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
      <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT * 
                              FROM CHAMPTYPE');
     
    oci_execute($stid);
  echo "<select class = 'form-control'  name='chosenType'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['CHAMPTYPE']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
  </div>

         <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
         </div>
        </form>
      </div>
      <div class="modal-footer">
      <div class ="form-group">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <div class="form-group">
        </div>
      </div> 
    </div>
  </div>
</div>

    <!-- <div class="addChamp"> <form action="deleteChampion.php"> <span class ="pull-right"><button type="submit"class="btn btn-primary pull-right ">Delete a Champion</button> </span></form></div> -->
    <!--  <div class="addChamp">  <span class ="pull-right"><button id ="deleteAChamp" type="button"class="btn btn-primary pull-right ">Delete a Champion</button> </span> -->
 


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Which Champion?</h4>
      </div>
      <div class="modal-body">
       <form class="form" role="form"  method="post" action="deleteChampion.php" accept-charset="UTF-8" id="userDelete">
         <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT ID, CHAMPNAME 
                              FROM CHAMPIONS ORDER BY CHAMPNAME');
     
    oci_execute($stid);

  echo "<select class = 'form-control'  name='champToDelete'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['CHAMPNAME']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";

?>
<br>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
         </div>
      </div>
        </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit a Champion</h4>
      </div>
      <div class="modal-body">
         <form class="form" role="form"  method="post" action="editChampions.php" accept-charset="UTF-8" id="userUpdate">
         <div class = "form-group">
         <label for="CHAMPION"> Champion </label>
<?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT ID, CHAMPNAME 
                              FROM CHAMPIONS ORDER BY CHAMPNAME');
     
    oci_execute($stid);

  echo "<select class = 'form-control'  name='champToEdit'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['CHAMPNAME']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";

?>
</div>
 <div class="form-group">
            <label for="rp">RP Cost</label>
          <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT ID, RP 
                              FROM CHAMPCOST');
     
    oci_execute($stid);
  echo "<select class='form-control' name='rpEdit'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['RP']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
         </div>
      
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
      <?php
  

        
  $conn = oci_connect('dilinilams', 'V00610105', 'localhost:20037/xe');
  if(!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}
    $stid = oci_parse($conn, 'SELECT * 
                              FROM CHAMPTYPE');
     
    oci_execute($stid);
  echo "<select class = 'form-control'  name='typeEdit'>\n ";

   while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

                echo "<option value='".$row['ID']."'>".$row['CHAMPTYPE']."</option>";
                var_dump($row);
                }

                oci_free_statement($stid);
                oci_close($conn);
          
    

echo "</select>\n";


?>
  </div>
         <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
         </div>
        </form>
      </div>
      <div class="modal-footer">
      <div class ="form-group">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <div class="form-group">
        </div>
      </div> 
    </div>
  </div>
</div>



</div>

</body>
<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
</script>
<script src="js/bootstrap.min.js"></script>
 <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
/*
  So I know that the jquery from bootstrap is sufficient enough for this website so far
*/
 $('td:nth-child(1),th:nth-child(1)').hide();
 $('#championTable').dataTable();
$(document).ready(function() {

 
 /* $('#deleteAChamp').click(function() {
      
      $(this).hide();
      $('#removeDelete').removeClass('hidden').addClass('show');
      $('#championTable').find('tr').each(function()
      {
        $(this).find('td').eq(4).after('<td> <button class="btn deleteButton" type="submit" value="submit"> <span class="glyphicon glyphicon-remove"></span> </button></td>');
      })
      });
   

 
  $('#removeDelete').click(function() {
      
      $('#removeDelete').removeClass('show').addClass('hidden');
      $('#deleteAChamp').show();
      $('#championTable').find('tr').each(function() {
          $(this).find('td:eq(5)').remove();
      })
      });
  */
  });
//.attr would be the attribute i'm looking for 
 $('#championTable').find('tr').each(function() 
 {
  //  $(this).attr("name", "ID");
    $(this).find('td:eq(0)').attr("name", "ID");
 
 });

$(function () {
    
    
    $('.navbar-toggler').on('click', function(event) {
    event.preventDefault();
    $(this).closest('.navbar-minimal').toggleClass('open');
  })
});


</script>

</html>

