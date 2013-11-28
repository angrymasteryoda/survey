<?php
include_once '../config/global.php';
checkLogin()
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
        <div>
            <form class="createSurveyForm">
                <span class="spanTitle">Create Survey</span>
                <hr />
                <table class="createSurveyTable" id="createSurveyTable">
                    <br/>
                    <div id="errors"> </div>
                    <tr>
                        <td>
                            <label>Enter the title.<br />
                                <input type="text" name="title" placeholder="Survey Title" value="" data-type="words"/>
                            </label>
                        </td>
                    </tr>

                    <tr data-question="1">
                        <td>
                            <div class="question" data-question="1">
                                <label>Enter question <span class="questionNumber">1</span>.<br>
                                    <textarea name="question[1]" placeholder="Question 1" data-type="words"></textarea></label><br>
                                Answer Type:
                                <select name="ansType[1]" class="answerType">
                                    <option value="single" title="Single answer is given to survey taker">Single Answer</option>
                                    <option value="multi" title="Multiple choice are given to survey taker">Multi Answer</option>
                                    <option value="write" title="A short answer is given to survey taker">Write In</option>
                                    <option value="t/f" title="A true false option is given to survey taker">True/False</option>
                                </select>
                                <div class="answer none"></div>
                                <hr>
                            </div>
                        </td>
                    </tr>

                    <tr class='addButton'>
                        <td>
                            <input type="button" class="addQuestion" value="New question"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" class="createSurveyButton" value="Done. Create It." />
                        </td>
                    </tr>
                </table>
                <div id="waiting" class="none">
                    Creating your survey<br><br>
                    <img width="70" height="70" src="<?php echo APP_URL?>assets/img/loading.gif" alt="Working"/>
                    <br>
                </div>
            </form>

        </div>
    </div>
</div>
<?php
include '../assets/inc/footer.php';
?>
<script>deleteCookie('qnum');</script>
</body>
</html>