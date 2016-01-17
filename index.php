<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Search the KJV Bible</title>
        <meta name="description" content="">

        <link rel="stylesheet" href="css/main.css">
        <link href='https://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'/>


		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
		<script type="text/javascript" src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("form").submit(function (e) {
					e.preventDefault(); //prevent default form submit
					$.ajax({
						url: 'classes/SearchResults.php',
						type: 'get',
						data: { s: $("#searchQueryInput").val() },
						success: function (data) {
							$("#searchResults").html(data);
						},
						cache: false
					});
				});
			});
		</script>

	</head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<?php

        ?>


        <div id="wrap">
            <section id="logo-holder">
                <p>
                    <br/><br/>
                    <img src="img/Holy_Bible.png" width="256" height="256" alt="Holy Bible" title="A light green, 2D picture of the Bible"/>
                    <br/><br/><br/><br/><br/>
                </p>
            </section>
            <section id="searchBox">
                <form>
                    <label for="searchBox" name="intro">Search the Bible</label>
                    <input type="text" id="searchQueryInput"/>
                    <input type="submit" value="Search"/>
                </form>
                <p><br/></p>
            </section>
			<section id="searchResults">
				<p>
					
				</p>
			</section>

            <!--<div id="mainContent">
                <h1>OR CHOOSE A BOOK</h1>
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>-->
        </div>
		<script src="jquery-1.12.0.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	</body>
</html>
