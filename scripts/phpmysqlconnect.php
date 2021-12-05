<?php
header('Access-Control-Allow-Origin: *');
require_once 'dbconfig.php';

$conn = mysqli_connect($host , $username, $password, $dbname);
if(!$conn){
    echo'Connection Error:' . mysqli_connect_error();
}

//receiving the data sent over by the Javascript file
$clerk=$_GET["clerk"];
$constit=$_GET["constit"];
$pollID=$_GET["pollID"];
$pollSt=$_GET["pollSt"];
$cand1=$_GET["cand1"];
$cand2=$_GET["cand2"];
$rejected=$_GET["rejected"];
$total=$_GET["total"];


$numbers="/^[0-9]+$/";
$alpha="/^[A-Z0-9]+$/";

//tests if the data sent over matches the given criteria
if ($clerk=="" || !(preg_match($numbers,$clerk))){  
    echo "Invalid Clerk ID";
    return;
}
if ($constit=="" || !(preg_match($numbers,$constit))){
    echo "Invalid Constituency ID";
    return;
}
if ($pollID=="" || !(preg_match($numbers,$pollID))){
    echo "Invalid Poll ID";
    return;
}
if ($pollSt=="" || !(preg_match($alpha,$pollSt))){
    echo "Invalid Poll Station";
    return;
}
if ($cand1=="" || !(preg_match($numbers,$cand1))){
    echo "Invalid Number of Candidates";
    return;
}
if ($cand2=="" || !(preg_match($numbers,$cand2))){
    echo "Invalid Number of Candidates";
    return;
}
if ($rejected=="" || !(preg_match($numbers,$rejected))){
    echo "Invalid Number of Rejected Votes";
    return;
}

$sum=$cand1+$cand2+$rejected;
if ($total=="" || !(preg_match($numbers,$total)) || $total!=$sum){
    echo "Invalid Total";
    return;
}

$constit= mysqli_real_escape_string($conn, $constit);
$clerk= mysqli_real_escape_string($conn, $clerk);
$pollID= mysqli_real_escape_string($conn, $pollID);
$pollSt= mysqli_real_escape_string($conn, $pollSt);
$cand1= mysqli_real_escape_string($conn, $cand1);
$cand2= mysqli_real_escape_string($conn, $cand2);
$rejected= mysqli_real_escape_string($conn, $rejected);
$total= mysqli_real_escape_string($conn, $total);

//adding to the table stationvotes in the database
$stmt = "INSERT into StationVotes (constituency_id, clerk_id, poll_division_id, polling_station_code, candidate1Votes, candidate2Votes, rejectedVotes, totalVotes)
VALUES ('$constit','$clerk','$pollID','$pollSt','$cand1','$cand2','$rejected','$total')";
mysqli_query($conn, $stmt);

//printing everything from the stationvotes table in the database
$getall="SELECT * from StationVotes";
$results = mysqli_query($conn, $getall);
$final1=0;
$final2=0;
$final3=0;
$final4=0;
echo "<table id='TableB'>";

echo "<tr>";
echo "<th class='left'>Constituency</th>";
echo "<th class='left'>Polling Div.</th>";
echo "<th class='left'>Polling Stn</th>";
echo "<th class='right'>Candidate1</th>";
echo "<th class='right'>Candidate2</th>";
echo "<th class='right'>Rejected</th>";
echo "<th class='right'>Total</th>";
echo "</tr>";

foreach ($results as $row){
    echo "<tr> \n";
    echo "<td class='left'>" .$row['constituency_id']. "</td> \n";
    echo "<td class='left'>" .$row['poll_division_id']. "</td> \n";
    echo "<td class='left'>" .$row['polling_station_code']. "</td> \n";
    echo "<td class='right'>" .$row['candidate1Votes']. "</td> \n";
    echo "<td class='right'>" .$row['candidate2Votes']. "</td> \n";
    echo "<td class='right'>" .$row['rejectedVotes']. "</td> \n";
    echo "<td class='right'>" .$row['totalVotes']. "</td> \n";
    echo "</tr>";
    $final1=$final1+$row['candidate1Votes'];
    $final2=$final2+$row['candidate2Votes'];
    $final3=$final3+$row['rejectedVotes'];
    $final4=$final4+ $row['totalVotes'];
}
echo "<tr id='bordered'>";
echo "<th class='left'>Total</th>";
echo "<th class='left'></th>";
echo "<th class='left'></th>";
echo "<th class='right'>$final1</th>";
echo "<th class='right'>$final2</th>";
echo "<th class='right'>$final3</th>";
echo "<th class='right'>$final4</th>";
echo "</tr>";
echo "</table>";







