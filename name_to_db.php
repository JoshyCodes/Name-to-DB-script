<?php
/**
 * User: Joshua Fischer
 * Date: 3/3/19
 * Time: 9:56 PM
 * Version: 1.0
 *
 * Simple script to prompt user for name, then inserts name
 * into local database. CLI Based PHP script.
 */


//************************************************************
// Config Settings for SQL DB
//************************************************************
$servername = "127.0.0.1";
$username = "php_script";
$password = "beSecure";
$dbname = "test";

// display text for prompt
echo "What is your name? ";

// record input from CLI
$handle = fopen ("php://stdin","r");

// set input to var after trimming beginning/ending whitespace
$name = trim(fgets($handle));

// close input file recorder
fclose($handle);


// verify input is not empty/null
if ( empty($name) ){

    echo "You did not enter a name!\n";

    // exit if empty/null
    exit;
}

// use try/catch with PDO SQL connection in case of error
try {
    // create new connection to database - uses config vars from above
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // set SQL insert query with input sanatization for security
    $sql = "INSERT INTO names (name) VALUES ('".filter_var ( $name, FILTER_SANITIZE_STRING)."')";

    // use exec() because no results are returned
    $conn->exec($sql);

    // echo successful message
    echo "\n";
    echo "Your name has been added to the database.\n";
}
    // catch error or exception
    catch(PDOException $e)
{
    // display error or exception
    echo $sql . "<br>" . $e->getMessage();
}

// close database connection
$conn = null;

// display customized thank you message
echo "Thank you, {$name}...\n";

?>