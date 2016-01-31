<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Search the Bible</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="img/Holy_Bible.png">

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
				
			$(".loading").hide();
				
			$("#search").submit(function (e) {
				$(".loading").show();
				e.preventDefault(); //prevent default form submit
				
				$.ajax({
					url: 'classes/SearchResults.php',
					type: 'get',
					data: { s: $("#searchQueryInput").val() },
					success: function (data) {
						$(".loading").hide();
						$("#searchResults").html(data);
					},
					cache: false
				});	
			});
			$("#searchButton").click(function (e) {
				$(".loading").show();
				e.preventDefault(); //prevent default 
				
				$.ajax({
					url: 'classes/SearchResults.php',
					type: 'get',
					data: { s: $("#searchQueryInput").val() },
					success: function (data) {
						$(".loading").hide();
						$("#searchResults").html(data);
					},
					cache: false
				});	
			});
		});
		</script>


	</head>
  <body>
	<div class="wrap">
		<div class="row">
			<div class="col-lg-12 text-center v-center">
				<img src="img/Holy_Bible.png" width="128" height="128" alt="Holy Bible" title="A light green, 2D picture of the Bible"/>
				<h1>Search the Bible</h1>

				<br/>
				<form class="col-lg-12">
					<div class="input-group input-group-lg col-sm-offset-4 col-sm-4">
						<input type="text" class="center-block form-control input-lg" id="searchQueryInput" title="Example: Genesis 1:1-3" placeholder="Example: Genesis 1:1-3">
						<span class="input-group-btn"><button class="btn btn-lg btn-primary" type="button" id="searchButton">Search</button></span>
					</div>
				</form>
			</div>
		</div> 
	</div> 
	<div class="wrap-no-background">
          <div class="col-lg-12 text-center v-center" id="">
			  <div class="loading"></div>
			  <form id="search">
				<div class="col-sm-12" id="searchResults" style="text-align: left">

				</div>
			  </form>
        </div>
	</div>



    <script src="jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>