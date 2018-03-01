<!-- http://radhika-paryekar-com.stackstaging.com/content/weather-scraper/index.php -->

<?php
$weather="";
$error="";
  if(isset($_GET['city']))
  {  
    $city=$_GET['city'];
    $url_contents=file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".urlencode($city)."&appid=73e3d2fd5a82e488d9fa61691d75630b");
    $weather_array=json_decode($url_contents,true); //true converts objects to associative array 
    if($weather_array["cod"]==200)
    {
      $weather="The weather in ".$city." is currently ".$weather_array['weather'][0]['description'].".";
      $temp=intval($weather_array['main']['temp']-273);
      $wind=$weather_array["wind"]["speed"];
      $weather.=" The temperature is ".$temp."&deg;C. and the wind speed is ".$wind." m/s.";
    }
    else
    {
      $error="Could not find city. Please try again";
    }
   
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    

    <title>Weather Scraper</title>

    <style>
      html,body
      {
        background:url("background.jpg") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
       
      }

 
      .container
      {
        text-align: center;
        margin-top: 100px;
        width:50%;
      }
      
      input#city.form-control
      {
        width: 50%;
      margin: 0 auto;
      }
      
      #weather
      {
        margin:0 auto;
        padding:10px 0px;
        width:35%;
        text-align:center;
      }
    

    </style>
  </head>


  <body>
    <div class="container">
      <h1>Whats The Weather?</h1>
    

      <form>
          <fieldset class="form-group">
            <label for="city">Enter the name of a city</label>
            <input type="text" class="form-control" id="city" placeholder="Eg. London, Tokyo, New York" name="city" value="<?php if (isset($_GET['city'])){echo $_GET['city'];}?>">
          </fieldset>

          <button type="submit" class="btn btn-primary">Submit</button>
      </form>

  </div>
    
   <div id="weather">
     <?php
      if($weather)
        {
          echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
        }
      else if($error)
      {
          echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
      }
     ?>
    </div>
   

    

       <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>