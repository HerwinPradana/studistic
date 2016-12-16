<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Studistic</title>
		<script src="js/backbone.marionette/jquery.js"></script>
		<script src="js/backbone.marionette/json2.js"></script>
		<script src="js/backbone.marionette/underscore.js"></script>
		<script src="js/backbone.marionette/backbone.js"></script>
		<script src="js/backbone.marionette/backbone.radio.js"></script>
		<script src="js/backbone.marionette/backbone.marionette.js"></script>
		<script src="js/studistic.js"></script>
		
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
    </head>
    <body>
		<div id="content">
		</div>

		<script type="text/template" id="angry_cats-template">
		  <thead>
		    <tr class='header'>
		      <th>Rank</th>
		      <th>Votes</th>
		      <th>Name</th>
		      <th>Image</th>
		      <th></th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		  </tbody>
		</script>

		<script type="text/template" id="angry_cat-template">
		  <td><%= rank %></td>
		  <td><%= votes %></td>
		  <td><%= name %></td>
		  <td><img class='angry_cat_pic' src='<%= image_path %>' /></td>
		  <td>
		    <div class='rank_up'><img src='assets/images/up.gif' /></div>
		    <div class='rank_down'><img src='assets/images/down.gif' /></div>
		  </td>
		  <td><a href="#" class="disqualify">Disqualify</a></td>
		</script>
    		<!--
		<script src="js/require.js"></script>
		<script>
		require(['scripts/config'], function() {
			// Configuration loaded now, safe to do other require calls
			// that depend on that config.
			require(['foo'], function(foo) {

			});
		});
		</script>
		-->
    </body>
</html>
