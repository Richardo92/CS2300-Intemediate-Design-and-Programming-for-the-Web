<!doctype html> 
<html> 
<?php
	define( 'URL_COMMON', 'https://info2300.coecis.cornell.edu/users/_demosp16/www/hw1_common/' );
?>
<head> 
	<meta charset="UTF-8">
	<title>Homework 1 JavaScript</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php echo URL_COMMON ?>css/style.css">
</head>
<body>
<div class="row">
	<div class="banner">
		<img src="<?php echo URL_COMMON ?>img/2000px-Star_Wars_Logo.svg.png" alt="logo">
	</div>
</div>

<div class="container"> 
    <div id="control-panel">
        <p> Control Panel </p> 
        <button id="border">Border</button><br>
        <button id="toggle">Toggle</button><br>
        <button id="addClass">Add Class</button><br>
        <button id="quotes">Load Quote</button><br>
        <button id="convert">Convert</button>
        <div>
            <h3>Test Rewrite</h3>
            Select a Movie: 
            <select id="rewrite_select">
                <option selected disabled>Choose here</option>
                <option value="0">I The Phantom Menace</option>
                <option value="1">II Attack of The Clones</option>
                <option value="2">III Revenge of The Sith</option>
                <option value="3">IV A New Hope</option>
                <option value="4">V The Empire Strikes Back</option>
                <option value="5">VI Return of The Jedi</option>
            </select>
            New Text: <input id="rewrite_text" type="text" />
            <button class="small_button" id="test_rewrite">Test</button>
        </div>
        <div>
            <h3>Search [Already Implemented] </h3>
            <input id="search" type="text" name="search"/>
        </div>
        <div>
            <h3>Replace</h3>
             Original: <input id="original" type="text" />
             New Text: <input id="newtext" type="text" />
            <button class="small_button" id="replace">Replace</button>
            
        </div>
    </div>
    <div id="input-panel">
    </div>


    <div id="movies-container"> 
	        <div class="movies"> 
               <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode1.jpg" alt="Episode 1">
                <ul>
                    <li>Title: Star Wars Episode I The Phantom Menace</li> 
                    <li>Release Date: May 19, 1999</li>
                    <li>Running Time: 133 minutes</li>
                </ul>
		        <a href="#" class="alert download btn">Free Movie Download</a>      
            </div> 
            <div class="movies"> 
               <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode2.jpg" alt="Episode 2">
                <ul>
                    <li>Title: Star Wars Episode II Attack of The Clones </li> 
                    <li>Release Date: May 16, 2002</li>
			        <li>Running Time: 142 minutes</li>
                </ul>
		        <a href="#" class="alert download btn">Free Movie Download</a>      
            </div> 
            <div class="movies"> 
               <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode3.jpg" alt="Episode 3">
                <ul>
                    <li>Title: Star Wars Episode III Revenge of The Sith</li> 
                    <li>Release Date: May 19, 2005</li>
                    <li>Running Time: 140 minutes</li>      
                </ul>
		        <a href="#" class="alert download btn">Free Movie Download</a>      
            </div> 
            <div class="movies"> 
               <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode4.jpg" alt="Episode 4">
                <ul>
                    <li>Title: Star Wars Episode IV A New Hope</li> 
                    <li>Release Date: May 25, 1977</li>
                    <li>Running Time: 125 minutes</li>    
                </ul>
		        <a href="#" class="alert download btn">Free Movie Download</a>      
            </div> 
           <div class="movies"> 
                <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode5.jpg" alt="Episode 5">
                <ul>
                    <li>Title: Star Wars Episode V The Empire Strikes Back</li> 
                    <li>Release Date: May 21, 1980</li>
                    <li>Running Time: 126 minutes</li>
                </ul>
                <a href="#" class="alert download btn">Free Movie Download</a>      

        </div> 
            <div class="movies"> 
                <img class="movie-poster" src="<?php echo URL_COMMON ?>img/episode6.jpg" alt="Episode 6">
                <ul>
                    <li>Title: Star Wars Episode VI Return of The Jedi</li> 
                    <li>Release Date: May 25, 1983</li>
                    <li>Running Time: 134 minutes</li>
                </ul>
                <a href="#" class="alert download btn">Free Movie Download</a>      
            </div>      
</div>
 <h1>Favorite Quotes</h1>
<div class="quotes"></div>    
             
 </div> 

<div id="footer"> 
		<p> Banner image is from <a href="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Star_Wars_Logo.svg/2000px-Star_Wars_Logo.svg.png"> Wikimedia </a> </p>
      <p class="source"> All Movie Posters were taken from <a href="http://coverwhiz.com">CoverWhiz.com.</a></p>   
</div> 

    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>