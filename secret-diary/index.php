<?php
 session_start();
 $error="";

	if (array_key_exists("logout", $_GET)) 
    {     
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";   
        session_destroy();
      	session_start();
    }
	else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) 
    {    
       header("Location:home.php");     
    }

	if(array_key_exists("submit",$_POST)) //returns true if the given key is set in the array
    {     
      include("connection.php");
      if(!isset($_POST['email']))
      {
        $error.="An email is required<br />";
      }
      if(!isset($_POST["password"]))
      {
        $error.="A password is required<br />";
      }
      
      if($error!="")
      {
        $error="<p>There were errors in your form: </p>".$error;
      }
      else
      {
        if (isset($_POST["signUp"]) AND $_POST['signUp'] == '1') 
        {         
          $query="SELECT id from users where email='".mysqli_real_escape_string($link,$_POST['email'])."' LIMIT 1";
          $results=mysqli_query($link,$query);
          if(mysqli_num_rows($results)>0)
          {
            $error= "That address is taken";
          }
          else
          {
            $query="INSERT into users (email,password) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";         
            if(!mysqli_query($link,$query))
            {
              $error="<p>Could not sign up - Please try again later.</p>";
            }
            else
            {
              //mysqli_insert_id returns id of latest query
              $query="UPDATE users SET password='".md5(md5(mysqli_insert_id($link)).$_POST["password"])."' WHERE id='".mysqli_insert_id($link)."' LIMIT 1";
              mysqli_query($link,$query);
              $_SESSION['id']=mysqli_insert_id($link); 
              if(isset($_POST['stay-logged-in']))
              {
                setcookie("id",mysqli_insert_id($link),time()+60*60*24*365);
              }
             header("Location:home.php");
            }
          }
      	}
        else
        {
          
           $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) 
                    {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) 
                        {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if (isset($_POST['stay-logged-in']) AND $_POST['stay-logged-in'] == '1') 
                            {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: home.php");
                                
                        } 
                      else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } 
          		else {
                        
                        $error = "Email doesn't exist in database.";
                        
                    }
                             
        }
      }
    }
?>



<?php include("header.php");?>  
    
    <div class="container" id="loginPageContainer">
      <h1>Secret Diary</h1>
      <p><strong>Store your thoughts permanently and securely.</strong></p>
       <div id="error"><?php if($error!="") echo "<div class=\"alert alert-danger\" role=\"alert\">".$error."</div>";?></div>
      
        <form method="POST" id="signup-form">  
          <p>Interested? Sign up now!</p>
          <fieldset class="form-group">
          	<input class="form-control" id="signup-email" type="email" name="email" placeholder="Your Email" required>
          </fieldset>
          <fieldset class="form-group">
          	<input class="form-control" id="signup-password" type="password" name="password" placeholder="Password" required>
          </fieldset>
          <fieldset class="form-check">          
            <input class="form-check-input" id="stayLogged" type="checkbox" name="stay-logged-in" value="1"> 
            <label for ="stayLogged">Stay Logged In</label>
          </fieldset>
          <fieldset class="form-group">
            <input type="hidden" name="signUp" value="1">
            <input class="btn btn-success" type="submit" value="Sign Up" name="submit">
          </fieldset>
          <p><a class="toggleForms">Log In</a></p>
        </form>
      
        <form method="POST" id="login-form">
          <p>Login using your username and password</p>
          <fieldset class="form-group">
          <input class="form-control" id="signup-email" type="email" name="email" placeholder="Your Email" required>
          </fieldset>
          <fieldset class="form-group">
          		<input class="form-control" class="form-control" id="signup-password" type="password" name="password" placeholder="Password" required>
          </fieldset>
          <fieldset class="form-check">
            <input class="form-check-input" id="stayLogged" type="checkbox" name="stay-logged-in" value="1"> 
            <label for ="stayLogged">Stay Logged In</label>
          </fieldset>
          <fieldset class="form-group">
            <input type="hidden" name="signUp" value="0">
            <input class="btn btn-success" type="submit" value="Log In" name="submit">
          </fieldset>
          <p><a class="toggleForms">Sign Up</a></p>
        </form>
      	
    </div>
    
    
<?php include("footer.php");?>


