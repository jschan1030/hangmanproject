<?php
    $lives = 4;
    include('header.php');
    // In this file, the game can be displayed here, with different links to dynamically change the site as well as the
    // game board. This will be a complicated file with lots of php scripts inside html.
?>
<h2>Hangman! Guess a letter or try to guess the word/phrase!</h2>
<div class = 'hangmangame'>
    
    <?php
        include 'databaseadaptor.php';
        $gamevar = new DatabaseAdaptor();
        $answer = $gamevar->getWordPhrase();
        $guessarr = array();
        echo 'Hint: ' . $answer['hint'] . '<br>';
        echo 'Difficulty level: ' . $answer['level'] . '<br>';
        $blanks = str_split($answer['wordphrase']);
        echo 'A ' . count($blanks) . ' letter ' . $answer['type'] . '<br>';
        
        
    ?>
    <p id='blankspace'>
        <?php
            foreach ($blanks as $letter) {
                echo '___  ';
            }
        ?>
    </p>
    
</div>
<form method='post'>
    <input type='text' name='letterguess' placeholder="Try to guess the letter!">
    <br>
    <input type='text' name='answerguess' placeholder="Know the answer?">
    <input type='submit' value='submit'>
</form>
<?php
    $letterguess = $_POST['letterguess'];
    if(!empty($letterguess)){
        echo $letterguess;   
    }
    if (!strpos($answer['wordphrase'],$letterguess)){
        echo "<h2>Lives: " . $lives . "</h2>";
    }
    else {
        array_push($guessarr,$letterguess);
        echo(implode($guessarr));
    }

    $answerguess = $_POST['answerguess'];
    if(!empty($answerguess)) {
        if ($answerguess == $answer['wordphrase']) {
            echo '<h1>YOU WIN!</h1>';   
        }
    }

?>
<?php
    include('footer.php');
?>