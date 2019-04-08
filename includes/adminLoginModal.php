<?php
require_once "database.php";
require_once "queries.php";
require_once "suli.php";



echo "<div class='modal-wrapper'>";
echo "<div class='login-wrapper'>";
echo "<div class='close-button'>X</div>";
echo "<h2>Admin Login</h2>";
echo "<form action='' method='post'>";
echo "<label>Email:</label>";
echo "<input id='loginEM' name='loginEmail' type='email' placeholder='Email'>";
echo "<label>Password:</label>";
echo "<input id='loginPASS' name='loginPassword' type='password' placeholder='Password'>";
echo "<input id='loginSubmit' type='submit' value='Login'>";
echo "</form>";
echo "</div>";
echo "</div>";
