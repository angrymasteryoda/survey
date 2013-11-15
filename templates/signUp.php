<?php
include_once '../config/global.php';
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
            include APP_URL . 'assets/inc/header.php'
            ?>

			<div class="content">
				<form class="signUpForm mainForm">
					<h1>Sign Up</h1>
					<p id="errors">

					</p>
					<p>
						<label>Username
						    <input type="text" name="username" id="username" class="" placeholder="Username" value="michael" data-type="username"/>
                        </label>
					</p>
					<p>
						<label>Password
						    <input type="password" name="password" id="password" class="" placeholder="Password" value="123456" data-type="password"/>
                        </label>
					</p>
					<p>
						<label>Confirm Password
						    <input type="password" name="confirmPassword" id="confirmPassword" class="" placeholder="Confirm Password" value="123456" data-type="confPassword"/>
                        </label>
					</p>
					<p>
						<label>Email
						    <input type="text" name="email" id="email" class="" placeholder="Email" value="r@r.r" data-type="email"/>
                        </label>
					</p>
					<p>
						<label>Confirm Email
						    <input type="text" name="confirmEmail" id="confirmEmail" class="" placeholder="Confirm Email" value="r@r.r" data-type="confEmail"/>
                        </label>
					</p>
					<p>
						<input type="button" class="submit" name="submit" value="Sign Up" data-type="submit"/>
					</p>
				</form>
			</div>
		</div>
        <?php
        Core::loadJavascript();
        ?>
	</body>
</html>