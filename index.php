<?php

/*
	$weather ="";
	$error ="";

	if ($_GET['city']) {
		$urlContents = file_get_contents("http://samples.openweathermap.org/data/2.5/weather?id=".urlencode($_GET['city']).",uk&appid=b26147d35142a428f2f73c1157c3de0a");
		
		$weatherArray = json_decode($urlContents, true);
		
		if($weatherArray) {
			
			$weather = "The weather in ".$_GET['city']." is currently ".$weatherArray['weather'][0]['description'].". ";
			$tempinCelcius = intval($weatherArray['main']['temp']-273);			
			$weather .= " The temperature is ".$tempinCelcius."&deg;C and the windspeed is ".$weatherArray['wind']['speed']."m/s.";
		 } else {
            
            $error = "Could not find city - please try again.";
            
        }
    }
*/

	
?>
<?php
	$userInput=ucwords($_GET["city"]);
	$error="The city could not be found.<br>Please try again!";
	if($_GET['city']){
		$key ='9775419d35d04bb1acf130335170208';
		$cityName = str_replace(' ', '-', $_GET['city']);
		$url="http://api.apixu.com/v1/current.json?key=$key&q=$cityName";

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$json_output=curl_exec($ch);
		$weather = json_decode($json_output);
		
			$city = $weather->location->name;
			$country = $weather->location->country;
			$condition = "<img src='" . $weather->current->condition->icon ."'>" . $weather->current->condition->text;

			$temp = "Temperature : ". $weather->current->temp_c." (&deg;C)";
			$tempFeelsLike = "Feels like : ". $weather->current->feelslike_c." (&deg;C)";   	


			$wind = round((($weather->current->wind_kph)*0.28),1)." m/s <br>";

			$update = "Updated On: ".$weather->current->last_updated;
			$locationResult = $city.", ".$country."";
			$temperatureResult = $temp."<br>".$tempFeelsLike;
	}
	
 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
	  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <title>Weather scraper</title>
	  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	  <style>
	
			html { 
		  background: url(background.jpg) no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}	
		  .alert-success{background-color: rgba(245, 245, 245, 0.4);}
		  .alert{
			  text-align: center;
		  }
		  body{
			  background:none;
		  }
		  
		  #search{
			  text-align: center;
			  margin-top:200px;
			  color:white;			 
		  }
		  input{
			  margin:20px 0px;
		  }
		  #weather{
			  margin-top:15px;
		  }
		  @media (min-width: 576px) {  }
	</style>
  </head>
	
  <body>
  
	  <div class="container" id="search">
		  <div class="row">
			  <div class="col-md-4 col-xs-12"></div>
			  <div class="col-md-4 col-xs-12">
				  <h1>Current Weather</h1>	  

				  <form>
					  <div class="form-group">
						<label for="city">Enter the name of the city</label>
						<input type="text" class="form-control"  name="city" aria-describedby="emailHelp" placeholder="Eg. Helsinki, Turku" value="<?php echo $_GET['city'];?>">
					  </div>

					<button type="submit" class="btn btn-primary">Search</button>
				  </form>
		  </div>
		<div class="col-md-4 col-xs-12"></div>

		  </div>
	</div>
	  <div class="container">

		  <div class="row">
			  <div class="col-md-4 col-xs-12">
				 <div id="weather"><?php 
					  if($city==$userInput){
						  if($locationResult){
							  echo '<div class="alert alert-success" role="alert">'."<h2>Location</h2>".$locationResult."<br>".$condition.'</div>';
						  }
					  
						 else {
							 echo '<div></div>';
						 }
					 }
					 
					?>
				</div>
			  </div>
			  <div class="col-md-4 col-xs-12">
				 <div id="weather"><?php
					 if($city==$userInput){
						  if($temperatureResult){
							  echo '<div class="alert alert-success" role="alert">'."<h2>Temprature</h2>".$temperatureResult.'</div>';
						  }
						  else {
							 echo '<div></div>';
						 }
					 }
					 else if(!$_GET['city']){
						 echo '<div></div>';
						 
					 }
					 else { 
						 echo '<div class="alert alert-warning" role="alert">'.$error.'</div>';
						 }
					 ?>
				</div>
			  </div>
			  <div class="col-md-4 col-xs-12">
				 <div id="weather"><?php 
					  if($city==$userInput){
						  if($wind){
							  echo '<div class="alert alert-success" role="alert">'."<h2>Wind</h2>".$wind.'</div>';
						  }
						  else {
							 echo '<div></div>';
						 }
					  }
					 ?>
				</div>
			  </div>
		  </div>
	  </div>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>