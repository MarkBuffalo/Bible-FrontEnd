<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<meta name="description" content="Free Bible Search">
	<meta name="keywords" content="Bible,Search Bible,搜索聖經,搜索圣经">
	<meta name="author" content="Mark Buffalo (Alias)">
	
    <title>Free Bible Search Engine</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/arkamis.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="img/Holy_Bible.png">

	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type="text/javascript" src="js/arkamis.js"></script>


	</head>
  <body onload="checkLanguage()">
  
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img alt="Brand" id="brand" src="img/arkamis_logo.png" width="35" height="24"/></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a class="close-menu" href="#" id="home">Home</a></li>
					<li><a class="close-menu" href="#" id="books">Books</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span>&nbsp;Language （语言） <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="close-menu" id="English">English (KJV)</a></li>
								<li><a href="#" class="close-menu" id="ChineseSimplified">简体中文</a></li>
								<li><a href="#" class="close-menu" id="ChineseTraditional">繁體中文</a></li>
							</ul>
					</li>
					<li role="presentation" class="dropdown close-menu"><a href="#" id="about">About</a></li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="https://github.com/MarkBuffalo/Bible-FrontEnd" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>&nbsp;GitHub</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
		</div>
    </nav>
  
  
    <div class="container-fluid">
      <!-- Main component for a primary marketing message or call to action -->
		<div class="col-lg-12 text-center v-center">
			<img src="img/Holy_Bible.png" width="128" height="128" alt="Holy Bible" title="A light green, 2D picture of the Bible"/>
			<h1 id="search_header">Search the Bible</h1>
			
			<form>
				<div class="input-group input-group-lg col-sm-offset-4 col-sm-4">
					<input type="text" class="center-block form-control input-lg" id="searchQueryInput" title="Example: Genesis 1:1-3" placeholder="Example: Genesis 1:1-3"/>
					<span class="input-group-btn"><button class="btn btn-lg btn-primary" type="button" id="searchButton">Search</button></span>
				</div>
			</form>
		</div>
    </div>
	<div class="wrap-no-background">
          <div class="col-lg-12 text-center v-center" id="">
			  <div class="loading" style="text-align: center;"><img src="img/loading.gif" alt="Loading..." title="Blue spinning logo to indicate that the page is loading" width="46" height="46"/></div>
			  <div class="col-sm-12" id="searchResults" style="text-align: left"></div>
        </div>
	</div>



    <script src="jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>