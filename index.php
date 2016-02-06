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

	<script type="text/javascript">
	
		$(document).ready(function()
		{
	
			var query = "";
			var langVal;
			
			$(".loading").hide();
			
			
			
			// Did the user submit the form in another way? Invoke ajax. 
			$("form").submit(function (e) 
			{
				//prevent default form submission
				e.preventDefault(); 

				$(".loading").show();

				
				// Does our search query contain a string? 
				if ($("#searchQueryInput").val() != "") { query = $("#searchQueryInput").val(); }
				// It doesn't. Use the default query in the title based on the selected language to provide an example query.
				else { query = $("#searchQueryInput").attr("title"); }
				
				// Initiate Ajax Search to get our results
				searchQueryAjax(query);
			});
			
			// Did the user click the "Search" button? Invoke Ajax.
			$("#searchButton").click(function (e) 
			{
				//prevent default page reloading annoyance
				e.preventDefault(); 

				if ($("#searchQueryInput").val() != "") { query = $("#searchQueryInput").val(); }
				else { query = $("#searchQueryInput").attr("title"); }

				$(".loading").show();
				
				// Initiate Ajax Search to get our results
				searchQueryAjax(query);
			});
			
			$("#books").click(function (e)
			{				
				bookListQueryAjax(langVal);
			});
			
			$("#home").click(function (e)
			{
				$(searchResults).html("");
			});			
			$("#brand").click(function (e)
			{
				$(searchResults).html("");
			});			

			
			$("#ChineseSimplified").click(function (e) 
			{
				langVal = 1;
				setLanguage("language", "#ChineseSimplified", 30);
				$("#searchQueryInput").attr("placeholder", "例： 创世记 1:1-3");
				$("#searchQueryInput").attr("title", "创世记 1:1-3");
				$("#searchQueryInput").val("");
				$("#books").text("圣经目录");
				$("#home").text("首页");
				$("#about").text("关于");
				$("#searchButton").text("搜索");
				$("#search_header").text("搜索圣经");
			});
			
			$("#ChineseTraditional").click(function (e) 
			{
				langVal = 2;
				setLanguage("language", "#ChineseTraditional", 30);
				$("#searchQueryInput").attr("placeholder", "例： 創世記 1:1-3");
				$("#searchQueryInput").attr("title", "創世記 1:1-3");
				$("#searchQueryInput").val("");
				$("#books").text("聖經目錄");
				$("#home").text("首頁");
				$("#about").text("關於");
				$("#searchButton").text("搜索");
				$("#search_header").text("搜索聖經");
			});
			$("#English").click(function (e) 
			{
				langVal = 0;
				setLanguage("language", "#English", 30);
				$("#searchQueryInput").attr("placeholder", "Example: Genesis 1:1-3");
				$("#searchQueryInput").attr("title", "Genesis 1:1-3");
				$("#searchQueryInput").val("");
				$("#books").text("Books");
				$("#home").text("Home");
				$("#about").text("About");
				$("#searchButton").text("Search");
				$("#search_header").text("Search the Bible");
			});

			
			$(document).on('click', ".list-group-item", function() 
			{
				$("#searchQueryInput").val($(this).text());
				$("#searchButton").click();
			});
			
		});
		
		
		// Will replace redundant code later.
		function bookListQueryAjax(parameterValue)
		{
			$(".loading").show();
				
			$.ajax(
			{
				url: "classes/BookList.php",
				type: 'GET',
				data: { lang: parameterValue },
				success: function (data) 
				{
					$(".loading").hide();
					$("#searchResults").html(data);
				},
				cache: false
			});	
			return false;
		}
		
		
		function searchQueryAjax(parameterValue)
		{
			$(".loading").show();
				
			$.ajax(
			{
				url: "classes/SearchResults.php",
				type: 'GET',
				data: { s: parameterValue },
				success: function (data) 
				{
					$(".loading").hide();
					$("#searchResults").html(data);
				},
				cache: false
			});	
			return false;
		}
		
		
		
		
		<!-- example from w3schools; too lazy to write it by hand ;-b  -->
		function setLanguage(cname, cvalue, exdays) 
		{
			var d = new Date();
			d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			var expires = "expires=" + d.toGMTString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		}

		function getLanguage(cname) 
		{
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) 
			{
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1);
				
				if (c.indexOf(name) == 0) 
				{
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}

		function checkLanguage() 
		{
			var lang = getLanguage("language");
			if (lang != "") 
			{
				$(lang).click();
			} 
			else 
			{
			   lang = "#English";
			   if (lang != "" && lang != null) 
			   {
				   setLanguage("language", lang, 30);
			   }
			}
		}

		
		</script>


	</head>
  <body onload="checkLanguage()">
	<div class="wrap">
		<nav class="navbar navbar-default navbar-static-top" style="background-color: #3162a2; margin: 0 auto;">
			<div class="container">
				 <div class="navbar-header">
					<a class="navbar-brand" href="#"><img alt="Brand" id="brand" src="img/arkamis_logo.png" width="35" height="24"/></a>
					
					<ul class="nav navbar-nav navbar-pills">
						<li role="presentation"><a href="#" id="home">Home</a></li>
						<li role="presentation" class="dropdown"><a href="#" id="books">Books</a></li>
						<li role="presentation" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" id="languages"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span>&nbsp;Language （语言） <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" id="English">English (KJV)</a></li>
								<li><a href="#" id="ChineseSimplified">简体中文</a></li>
								<li><a href="#" id="ChineseTraditional">繁體中文</a></li>
							</ul>
						</li>
						<li role="presentation" class="dropdown"><a href="#" id="about">About</a></li>
					</ul>
				</div>
			</div>
		</nav>
	
		<div class="row">
			<div class="col-lg-12 text-center v-center">
				<img src="img/Holy_Bible.png" width="128" height="128" alt="Holy Bible" title="A light green, 2D picture of the Bible"/>
				<h1 id="search_header">Search the Bible</h1>

				<br/>
				<form class="col-lg-12">
					<div class="input-group input-group-lg col-sm-offset-4 col-sm-4">
						<input type="text" class="center-block form-control input-lg" id="searchQueryInput" title="Example: Genesis 1:1-3" placeholder="Example: Genesis 1:1-3"/>
						<span class="input-group-btn"><button class="btn btn-lg btn-primary" type="button" id="searchButton">Search</button></span>
					</div>
				</form>
			</div>
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