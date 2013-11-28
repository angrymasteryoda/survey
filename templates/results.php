<?php
include_once '../config/global.php';
checkLogin();
$collection = loadDB('results');
$surveyColl = loadDB('surveys');
if ( isset($_POST['name']) ) {
    $data = $collection->findOne(array('hash' => $_POST['name']));
    $foundSurvey = $surveyColl->findOne( array('hash' => $_POST['name']) );
    setcookie('name', $_POST['name']);
    setcookie('title', $data['title']);
}
if ( !isset( $data ) && !isset( $foundSurvey ) ) {
    goToError(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include '../assets/inc/meta.php';
    ?>
</head>
<body>
<div id="wrapper">
    <?php
    include APP_URL .'assets/inc/header.php';
    ?>

    <div class="content">
        <div class="resultsPage">
            <p class="pageTitle font14pt">
                <?php echo $data['title'];?>
            </p>
            <hr>
            <?php

            $i = 1;
            foreach ( $foundSurvey[ 'questions' ] as $question ) {
                echo '
                <div class="margin15_bottom slightBorder_bottom">
                    <div class="margin10_bottom ">
                        <p>
                            Question '. $i .'
                        </p>
                        <p class="margin5_left">
                            '.$question['question'].'
                        </p>
                    </div>
                    <div class="margin20_left">
                        Answers:<br>
                    ';
                foreach ( array_count_values( $data['answers'][$i] ) as $answer => $times ) {
                    echo $answer.'<span class="times floatright clearfix">Times: '.$times.'</span><br>';
                }

                echo '
                    </div>
                </div>
                ';
                $i++;
            }

            ?>
        </div>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
</body>
</html>