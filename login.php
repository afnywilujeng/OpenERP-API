<?php

$sql="SELECT * from laporan";
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result)){
$data = $rows['tim'];
foreach ($data as $baca)
{
echo $baca."<br>";
}
}
?>