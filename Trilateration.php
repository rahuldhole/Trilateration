<?php

$R = 6378137;//Radius of Earth (meters)
$v = 2.99792458e8;//(m/s) absolute velocity of light
//Known reference nodes locations
$Ax = 0; //x-xoord of point A
$Ay = 0; //y-xoord of point A
$Bx = 1200; 
$By = 0; 
$Cx = 600; 
$Cy = 1200; 

//change this to realistic ones because +/-2 degree can cause +/- 5Km error
$Alat = 43.563533; //Latitude of point A
$Along = 1.465593; //Longitude of point A
$Clat = 43.561229; 
$Clong = 1.456335;
$Clat = 43.585002; 
$Clong = 1.806257;

//We are considering Uplink nodes
$tos = 1561271377605083451; //Time(nanoseconds) of sending radio signals
$Atoa = 1561271421431742886;//time of signal arrival at A
$Btoa = 1561271644402383523;
$Ctoa = 1561271569226426755;

//Radius of circles would be d=v*(toa-tos)
$Ar = $v*($Atoa-$tos);
$Br = $v*($Btoa-$tos);
$Cr = $v*($Ctoa-$tos);
//I have simulated this following distance in www.math10.com geometry solver
$Ar = 1460.19;
$Br = 889.94;
$Cr = 639.18;
//Trilateration
echo "<h2>Trilateration</h2>";
list($Lx, $Ly) = Trilateration($Ax, $Ay, $Bx, $By, $Cx, $Cy, $Ar, $Br, $Cr, $Alat, $Clat, $Along, $Clong, $R);

function Trilateration($Ax, $Ay, $Bx, $By, $Cx, $Cy, $Ar, $Br, $Cr, $Alat, $Clat, $Along, $Clong, $R){

	list($Px1, $Py1, $Qx1, $Qy1) = getCircleInterectionPoints($Ax, $Ay, $Bx, $By, $Ar, $Br);
	list($Px2, $Py2, $Qx2, $Qy2) = getCircleInterectionPoints($Bx, $By, $Cx, $Cy, $Br, $Cr);
	list($Px3, $Py3, $Qx3, $Qy3) = getCircleInterectionPoints($Cx, $Cy, $Ax, $Ay, $Cr, $Ar);

	$c12dPx = $Px2 - $Px1;
	$c12dPy = $Py2 - $Py1;
	$c12dQx = $Qx2 - $Qx1;
	$c12dQy = $Qy2 - $Qy1;
	$c23dPx = $Px2 - $Px3;
	$c23dPy = $Py2 - $Py3;
	$c23dQx = $Qx2 - $Qx3;
	$c23dQy = $Qy2 - $Qy3;
	$c12Pd=sqrt(pow($c12dPx,2)+pow($c12dPy,2));
	$c12Qd=sqrt(pow($c12dQx,2)+pow($c12dQy,2));
	$c23Pd=sqrt(pow($c23dPx,2)+pow($c23dPy,2));
	$c23Qd=sqrt(pow($c23dQx,2)+pow($c23dQy,2));
	//if P is more common between three circle intersection than Q
	if($c12Pd<$c12Qd){
		//take centroid of intersection area end points
		$Lx = ($Px1+$Px2+$Px3)/3;
		$Ly = ($Py1+$Py2+$Py3)/3;
	} else{
		$Lx = ($Qx1+$Qx2+$Qx3)/3;
		$Ly = ($Qy1+$Qy2+$Qy3)/3;
	}

	echo "Location found at<br />";
	echo "Lx: ".$Lx."<br />";
	echo "Ly: ".$Ly."<br />";

	$ALx = $Lx - $Ax;
	$ALy = $Ly - $Ay;
	$ALdist=sqrt(pow($ALx,2)+pow($ALy,2));
	//Latitude is Y-axis and Longitude is X-axis
	//theta = tan inverse of y2-y1/x2-x1
	$ACtoX_Angle = 0;//with local coords
	$ALtoX_Angle = acos($Lx/$ALdist);
	$AtoC_geoOrigin = atan(($Clat-$Alat)/($Clong-$Along));//Angle with global coordinates lat,lng origin(0,0)
	$ALtoX_geoOrigin = $AtoC_geoOrigin+$ALtoX_Angle;//Bearing Angle
	$bearing = rad2deg($ALtoX_geoOrigin);

	//Method 1
	$long= $Along +($ALdist/1000)*sin($bearing);
	$lat = $Alat +($ALdist/1000)*cos($bearing);//convert into km by dividing by 1000
	//Method 2
	$tmp = $ALdist/$R;
	$lat2 = $Alat+asin(sin($Alat)*cos($tmp)+cos($Alat)*sin($tmp)*cos($bearing));
	$long2 = $Along + atan(sin($bearing)*sin($tmp)*cos($Alat)*cos($tmp)-sin($Alat)*sin($lat));

	//echo "ALdist: ".$ALdist."<br />";
	//echo "ALtoX_Angle: ".rad2deg($ALtoX_Angle)."<br />";
	//echo "ACtoX_Angle: ".rad2deg($ACtoX_Angle)."<br />";
	//echo "AtoC_geoOrigin: ".rad2deg($AtoC_geoOrigin)."<br />";
	//echo "ALtoX_geoOrigin: ".rad2deg($ALtoX_geoOrigin)."<br />";
	echo "Method 1 of bearing and Distance<br />";
	echo "Lat: ".$lat."<br />";
	echo "Long: ".$long."<br />";
	$url = "https://www.latlong.net/c/?lat=".$lat."&long=".$long;
	echo "<a href = $url>Click here to see on map</a><br />";
	echo "Method 2 of bearing and Distance<br />";
	echo "Lat: ".$lat2."<br />";
	echo "Long: ".$long2."<br />";
	$url = "https://www.latlong.net/c/?lat=".$lat2."&long=".$long2;
	echo "<a href = $url>Click here to see on map</a>";

	return array($Lx, $Ly);
}








//Two circle intersection points
function getCircleInterectionPoints($Ax, $Ay, $Bx, $By, $Ar, $Br){
	$deltaX = $Bx - $Ax;
	$deltaY = $By - $Ay;
	//delta^2 = deltaX^2+deltaY^2 ///Euclidean Distance
	$delta = sqrt(pow($deltaX,2)+pow($deltaY,2));
	//echo "Delta: ".$delta."<br />";

	if($delta>($Br+$Ar)){
		echo "There is no intersection";
		exit;
	} else if($delta<($Br-$Ar)){
		echo "One circle is inside other";
		exit;
	}
	//R(Rx, Ry) Perpendicular on AB from P&Q
	//AC = s, BC = t, PR = QR = u
	//s^2 + u^2 = Ar^2
	//t^2 + u^2 = Br^2
	//Subtract
	//s^2 - t^2 = Ar^2 - Br^2
	//(s-t)(s+t) = Ar^2-Br^2
	//since, s+t=delta so, t=delta-s
	//(s-(d-s))d = Ar^2-Br^2
	$s = (pow($delta,2)+pow($Ar,2)-pow($Br,2))/(2*$delta);
	$Rx = $Ax + ($deltaX * $s)/$delta;
	$Ry = $Ay + ($deltaY * $s)/$delta;

	$u = sqrt(pow($Ar,2)-pow($s,2));

	$Px = $Rx - ($deltaY*$u)/$delta;
	$Py = $Ry + ($deltaX*$u)/$delta;
	$Qx = $Rx + ($deltaY*$u)/$delta;
	$Qy = $Ry - ($deltaX*$u)/$delta;
	/*************************
	echo "Px: ".$Px."<br />";
	echo "Py: ".$Py."<br />";
	echo "Qx: ".$Qx."<br />";
	echo "Qx: ".$Qy."<br />";
	**************************/
	return array($Px, $Py, $Qx, $Qy);
}
