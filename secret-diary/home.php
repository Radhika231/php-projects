<?php
  session_start();
  $diary_content="";
  if(array_key_exists("id",$_COOKIE))
  {
    $SESSION['id']=$_COOKIE['id'];
  }
  if(array_key_exists("id",$_SESSION))
  {
   
    include("connection.php");
    $query="SELECT diary from `users` where id='".mysqli_real_escape_string($link,$_SESSION["id"])."' LIMIT 1";
    $row=mysqli_fetch_array(mysqli_query($link,$query));
    $diary_content=$row["diary"];
  }
  else
  {

     header("Location:index.php");
  }

	include("header.php");
	echo"<nav class=\"navbar navbar-light bg-light navbar-fixed-top\">
          <a class=\"navbar-brand\" href=\"#\">Secret Diary</a>

            <div class=\"float-right\">
              <a href=\"index.php?logout=1\"><button class=\"btn btn-outline-success\" type=\"submit\">Logout</button></a>
            </div>
          </div>
        </nav>
          <div id=\"diaryContainer\" class=\"container-fluid\">
          <textarea id=\"diary\" class=\"form-control\" cols=\"100\">".$diary_content."</textarea>
          </div>";

	include("footer.php");
?>