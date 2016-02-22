<!DOCTYPE html>
<html>
    <!-- 
    
    OVERVIEW
    In this activity, the poll from last week's activity has been updated with
    a more complex form. Your task is to add form validation using JavaScript
    to ensure user input is properly formatted. Then, you'll add another feature
    that enables you to change the color of a candidate's endorsements, also
    using JavaScript.
    
    INSTRUCTIONS
    1. Add appropriate tags to include the validate.js file.
    2. Navigate to poll.php in a browser and use the inspector to look at
    sources to see if validate.js loaded correctly. 
    3. Complete the functions in form.js so that the form is properly validated.
    4. Remember to refresh your browser after updating your js file.
    5. Add appropriate tags to include the colors.js file.
    6. Complete the function in that file.
    
    -->
    <head>
        <meta charset="UTF-8">
        <title>INFO / CS 2300 Section 4</title>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href='css/style.css' rel='stylesheet' type='text/css'>
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

        <!-- Add a link to the JavaScript file "validate.js" and "colors.js" -->
        
		
    </head>
<body>

<?php
    $delimiter = '|'; //set this in one place, don't hardcode it everywhere!

    if(isset($_POST['submit'])){

        $file = fopen("votes.txt", "a+");      

        if (!$file) {
            die("There was a problem opening the votes.txt file");
        }


        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $candidate = filter_input(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!is_string($name) || !is_string($candidate)) {
            die("Invalid username or candidate!");
        }
        if (strlen($name) === 0 || strlen($candidate) === 0) {
            die("Invalid username or candidate!");
        }
        fputs($file, "$name$delimiter$candidate\n");

        fclose($file);
    }
  
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Voting Poll</title>
    </head>
</html>
 
<body>
    <img src = "http://bit.ly/1nYuQtp" alt="Donkey and Elephant" width="200px" style="float:right"> 
    <h1>Info 2300: Presidential Poll</h1>
  
    <h3>Cast your vote!</h3>
    <p>* indicates required field</p>
  
    <form onsubmit="return validateForm(this);" action="poll.php" method="post" name="poll">
        What is your name?* <br> <input type="text" name="name" id="name" /> <br>
        
        What is your age?* <br> <input type="text" name="age" /> <br>
        
        What is your ethnicity?* (Select as many as applies) <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="White">White <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="Hispanic or Latino">Hispanic or Latino <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="Black or African American">Black or African American <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="Native American or American Indian">Native American or American Indian <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="Asian/Pacific Islander">Asian / Pacific Islander <br>
        <input type="checkbox" name="ethnicity" class="ethnicity" value="Other">Other <br>
        
        Please enter your zipcode:* <br> <input type="text" name="zip" /> <br>
        
        Select a candidate!* <br>
        <select name="candidate">
        <?php
        $candidates = $array = array(
            "Hillary Clinton" => "Democrat",
            "Bernie Sanders" => "Democrat",
            "Jeb Bush" => "Republican",
            "Ben Carson" => "Republican",
            "Chris Christie" => "Republican",
            "Ted Cruz" => "Republican",
            "Carly Fiorina" => "Republican",
            "Jim Gilmore" => "Republican",
            "John Kasich" => "Republican",
            "Marco Rubio" => "Republican",
            "Donald J. Trump" => "Republican",
        );
        foreach($candidates as $candidate => $party) {
            echo "<option value = \"$candidate\">$candidate</option>";
        }
        ?>
        </select><br><br>
        
        Enter your email to join the mailing list <br> <input type="text" name="email" /> <br>
        <br>
        <input type="submit" name="submit" value="Save" />
    </form>
  
    <h3>Polling Results</h3>
  
    <ol>
    <?php
        $voters = file("votes.txt");
        foreach($voters as $voter){
            $info = explode($delimiter, trim($voter));

            if ($info[1] == 'Hillary Clinton' || $info[1] == "Bernie Sanders") {
                print "<li class = 'democrat'>$info[0] supports $info[1]</li>";
            } else {
                print "<li class = 'republican'>$info[0] supports $info[1]</li>";
            }
        }
    ?>
    </ol>
    
     

</body>
 
</html>
