<!doctype html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

      <title>Find my PostCode!</title>
    	<style>
           html 
            { 
			  background: linear-gradient(to right, rgba(0,90,100,0), rgba(255,120,200,0.5));
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
              height:100%;
              width:100%;

            }
          body
          {
            background:none;
            font-weight:bold;
            height:100%;
            width:100%;
          }
          .container
          {
            text-align:center;
            width:400px;
          }
          #mainContainer
          {
            margin-top:100px;
          }
    	</style>
  </head>
  <body>
    
   
    <div class="container" id="mainContainer">
       <h1>Find My Postcode ! </h1>
       <div id="message"></div>
        <p>Enter a partial address to get the postcode</p>
        <form>
            <div class="form-group">
              <input class="form-control" id="partialAddress" aria-describedby="enter partial address" placeholder="Enter partial address">
            </div>

            <button class="btn btn-primary" id="getPostCodeButton">Submit</button>
          </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
      $("#getPostCodeButton").click(function(e)
      {
        e.preventDefault();
        $.ajax({
          url:"https://maps.googleapis.com/maps/api/geocode/json?address="+encodeURIComponent($("#partialAddress").val())+"&key=AIzaSyAJWSZZxU_qTH5YBLKA_Q5cnxBEAOe1paY",
          type:"GET",
          success:function(data)
          {
            
            if(data["status"]!="OK")
            {
               $("#message").html('<div class="alert alert-warning" role="alert">Postcode Not Found!</div>');
            }
            else
            {
              
              $.each(data["results"][0]["address_components"],function(key,value)
                       {
                             if(value["types"]["0"]=="postal_code")
                            {
                              $("#message").html('<div class="alert alert-success" role="alert">Postcode Found! The Postcode is : '+value["long_name"]+'</div>');
                            }
                        });    
              }
          }
        });
      });
        
    </script>
  </body>
</html>