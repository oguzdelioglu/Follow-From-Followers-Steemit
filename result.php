<?php
ini_set("max_execution_time", 0);
$username = $_GET["username"];
$YourFollowers  = YourFollowers($username);
$FollowersOfYou = FollowersOfYou($username);
$diff = array_diff($FollowersOfYou, $YourFollowers);

echo '<style>
a {
  text-decoration:none;
}
a:visited {
    color: darkgreen;
}
</style>';

echo '<body link="darkgreen">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
echo '<center><a href="index.php">
<img border="0" alt="Steemit" src="logo.png" width="200" height="48">
</a></center>';

echo '<div class="w3-container">';
echo '<table align="center" border="1">';
foreach($diff as $user => $value)
{
	echo "<tr>";
	echo '<td align="center"><a target="_BLANK" href="https://www.steemit.com/@'.$value.'"/>'.$value.'</td>';
	echo "</tr>";
	wait(0.1);
}
echo '<center>People I have not followed<br>Total:'.sizeof($diff).'</center>';
echo '</table>';
echo '</div>';
echo '<center>Finish</center>';
echo '</body>';

function wait($time)
{
	usleep(1000000*$time);
	ob_flush();
	flush();
}

function YourFollowers($username) {
	$total=0;
	$allusers=array();
	foreach(range('a', 'z') as $char) {
		//echo "<center>Alpabeth:[<font color=\"red\">".$char."</font>]</center><br/>";
		$json = file_get_contents('https://api.steemjs.com/get_following?follower='.$username.'&followType=blog&startFollowing='.$char.'&limit=100');
		$data = json_decode($json,true);
		foreach ($data as $key => $value){
			if (!(in_array($value["following"], $allusers))) {
				array_push($allusers,$value["following"]);
				//echo "<center>".$value["following"]."</center><br>";
				$total++;
			}
		}
	}
	echo "<center>Following:".$total."</center>";
	return $allusers;
}

function FollowersOfYou($username) {
	$total=0;
	$allusers=array();
	foreach(range('a', 'z') as $char) {
		//echo "<center>Alpabeth:[<font color=\"red\">".$char."</font>]</center><br/>";
		$json = file_get_contents('https://api.steemjs.com/get_followers?following='.$username.'&followType=blog&startFollower='.$char.'&limit=100');
		$data = json_decode($json,true);
		foreach ($data as $key => $value){
			if (!(in_array($value["follower"], $allusers))) {
				array_push($allusers,$value["follower"]);
				//echo "<center>".$value["follower"]."</center><br>";
				$total++;
			}
		}
	}
	echo "<center>Followers:".$total."</center>";
	return $allusers;
}
?>