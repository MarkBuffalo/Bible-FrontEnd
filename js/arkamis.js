		var langVal;
		
		function hideFooter()
		{
			$(".footer").hide();
		}
		function showFooter()
		{
			$(".footer").show();			
		}
	
		$(document).ready(function()
		{
			var query = "";
			
			$(".loading").hide();
			hideFooter();
			
			// Did the user submit the form in another way? Invoke ajax. 
			$("form").submit(function (e) 
			{
				//prevent default form submission
				e.preventDefault(); 

				// Show the loading .gif
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

				// Make sure the input isn't null
				if ($("#searchQueryInput").val() != "") { query = $("#searchQueryInput").val(); }

				// It doesn't. Use the default query in the title based on the selected language to provide an example query.
				else { query = $("#searchQueryInput").attr("title"); }

				// Show loading .gif
				$(".loading").show();
				
				// Initiate Ajax Search to get our results
				searchQueryAjax(query);
			});
			
			// For when the user clicks the "Books" navbar item.
			$("#books").click(function (e)
			{
				// Request book data from PHP
				bookListQueryAjax(langVal);
			});
			
			
			// For when the user clicks the "Home"  navbar item.
			$("#home").click(function (e)
			{
				// Clear the results.
				$(searchResults).html("");
				// Hide the footer.
				hideFooter();
			});
			
			// For when the user clicks the site logo.
			$("#brand").click(function (e)
			{
				// Clear results.
				$(searchResults).html("");
				// Hide the footer.
				hideFooter();
			});			
			
			// Whenever a navbar menu is clicked...
			$('.close-menu').on('click', function()
			{ 
				// Is the navbar menu visible? Nope!
				if ($('.navbar-toggle').css('display') != 'none')
				{
					// Toggle the navbar menu without glitching.
					$(".navbar-toggle").trigger( "click" );
				}
			});


			// Clicked Simplified Chinese. Load Simplified Chinese text.
			$("#ChineseSimplified").click(function (e) { setChineseSimplified(); });

			// Clicked Traditional Chinese. Load Traditional Chinese text.
			$("#ChineseTraditional").click(function (e) { setChineseTraditional(); });

			// Clicked English. Load English text.
			$("#English").click(function (e) { setEnglish(); });

			
			// When the user clicks the book list...
			$(document).on('click', ".list-group-item", function() 
			{
				// Set the value of the input box to the book name...
				$("#searchQueryInput").val($(this).text());
				// And submit/click the form.
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
					showFooter();
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
					showFooter();
				},
				cache: false
			});	
			return false;
		}
		
		function setEnglish()
		{
			langVal = 0;
			
			setLanguage("language", "#English", 30);
			$("#searchQueryInput").attr("placeholder", "Example: Genesis 1:1-3");
			$("#searchQueryInput").attr("title", "Genesis 1:1-3");
			$("#searchQueryInput").val("");
			$("#books").text("Books");
			$("#home").text("Home");
			//$("#about").text("About");
			$("#searchButton").text("Search");
			$("#search_header").text("Search the Bible");
		}
		
		function setChineseTraditional()
		{
			langVal = 2;
			
			setLanguage("language", "#ChineseTraditional", 30);
			$("#searchQueryInput").attr("placeholder", "例： 創世記 1:1-3");
			$("#searchQueryInput").attr("title", "創世記 1:1-3");
			$("#searchQueryInput").val("");
			$("#books").text("聖經目錄");
			$("#home").text("首頁");
			//$("#about").text("關於");
			$("#searchButton").text("搜索");
			$("#search_header").text("搜索聖經");
		}
		
		function setChineseSimplified()
		{
			langVal = 1;
			setLanguage("language", "#ChineseSimplified", 30);
			$("#searchQueryInput").attr("placeholder", "例： 创世记 1:1-3");
			$("#searchQueryInput").attr("title", "创世记 1:1-3");
			$("#searchQueryInput").val("");
			$("#books").text("圣经目录");
			$("#home").text("首页");
			//$("#about").text("关于");
			$("#searchButton").text("搜索");
			$("#search_header").text("搜索圣经");
		}
		
	
		// example from w3schools; too lazy to write it by hand ;-b 
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
				if (lang == "#English") { setEnglish(); }
				else if (lang == "#ChineseSimplified") { setChineseSimplified(); }
				else if (lang == "#ChineseTraditional") { setChineseTraditional(); }
			} 
			else 
			{
			   lang = "#English";
			   if (lang != "" && lang != null) 
			   {
				   setLanguage("language", lang, 30);
				   setEnglish();
			   }
			}
		}