<?php

 $R = 6 3 7 8 1 3 7;//Radius o f Ear th ( me ters )
 $v = 2. 9 9 7 9 2 4 5 8 e8 ; //(m/s ) a b s olu te v el o ci t y o f l i g h t
 //Known r e f e r e n c e nodes l o c a ti o n s
 $Ax = 0 ; //x−xoord o f poin t A
 $Ay = 0 ; //y−xoord o f poin t A
 $Bx = 1 2 0 0 ;
 $By = 0 ;
 $Cx = 6 0 0 ;
 $Cy = 1 2 0 0 ;

 //change t h i s t o r e a l i s t i c ones because +/−2 degree can cause +/− 5Km
e r r o r
 $Al a t = 4 3 . 5 6 3 5 3 3 ; //L a ti tude o f poin t A
 $Along = 1 . 4 6 5 5 9 3 ; //Longitude o f poin t A
 $Cl a t = 4 3 . 5 6 1 2 2 9 ;
 $Clong = 1 . 4 5 6 3 3 5 ;
 $Cl a t = 4 3 . 5 8 5 0 0 2 ;
 $Clong = 1 . 8 0 6 2 5 7 ;

 //We a re c o n side ri n g Uplink nodes
 $ t o s = 1 5 6 1 2 7 1 3 7 7 6 0 5 0 8 3 4 5 1; //Time ( nanoseconds ) o f sending r adio si g n al s
 $Atoa = 1 5 6 1 2 7 1 4 2 1 4 3 1 7 4 2 8 8 6;//time o f si g n al a r r i v a l a t A
 $B toa = 1 5 6 1 2 7 1 6 4 4 4 0 2 3 8 3 5 2 3;
 $Ctoa = 1 5 6 1 2 7 1 5 6 9 2 2 6 4 2 6 7 5 5;
 //Radius o f c i r c l e s would be d=v∗( toa−t o s )
 $Ar = $v ∗( $Atoa−$ t o s ) ;
 $Br = $v ∗( $Btoa−$ t o s ) ;
 $Cr = $v ∗( $Ctoa−$ t o s ) ;
 //I have simula ted t h i s f oll owin g di s t a n c e in www. math10 . com geometry
s ol v e r
 $Ar = 1 4 6 0 . 1 9 ;
 $Br = 8 8 9 . 9 4 ;
 $Cr = 6 3 9 . 1 8 ;
 // T r i l a t e r a t i o n
 echo "<h2>T r i l a t e r a t i o n </h2>" ;
 l i s t ( $Lx , $Ly ) = T r i l a t e r a t i o n ( $Ax , $Ay , $Bx , $By , $Cx , $Cy , $Ar , $Br , $Cr
, $Ala t , $Cla t , $Along , $Clong , $R ) ;

 f u n c ti o n T r i l a t e r a t i o n ( $Ax , $Ay , $Bx , $By , $Cx , $Cy , $Ar , $Br , $Cr , $Ala t ,
$Cla t , $Along , $Clong , $R ) {

 l i s t ( $Px1 , $Py1 , $Qx1 , $Qy1 ) = g e t C i r c l e I n t e r e c t i o n P o i n t s ( $Ax , $Ay , $Bx ,
$By , $Ar , $Br ) ;
 l i s t ( $Px2 , $Py2 , $Qx2 , $Qy2 ) = g e t C i r c l e I n t e r e c t i o n P o i n t s ( $Bx , $By , $Cx ,
$Cy , $Br , $Cr ) ;
 l i s t ( $Px3 , $Py3 , $Qx3 , $Qy3 ) = g e t C i r c l e I n t e r e c t i o n P o i n t s ( $Cx , $Cy , $Ax ,
$Ay , $Cr , $Ar ) ;

 $c12dPx = $Px2 − $Px1 ;
 $c12dPy = $Py2 − $Py1 ;
 $c12dQx = $Qx2 − $Qx1 ;
 $c12dQy = $Qy2 − $Qy1 ;
 $c23dPx = $Px2 − $Px3 ;
 $c23dPy = $Py2 − $Py3 ;
 $c23dQx = $Qx2 − $Qx3 ;
 $c23dQy = $Qy2 − $Qy3 ;
 $c12Pd= s q r t (pow ( $c12dPx , 2 ) +pow ( $c12dPy , 2 ) ) ;
 $c12Qd= s q r t (pow ( $c12dQx , 2 ) +pow ( $c12dQy , 2 ) ) ;
 $c23Pd= s q r t (pow ( $c23dPx , 2 ) +pow ( $c23dPy , 2 ) ) ;
 $c23Qd= s q r t (pow ( $c23dQx , 2 ) +pow ( $c23dQy , 2 ) ) ;
 // i f P i s more common between t h r e e c i r c l e i n t e r s e c t i o n than Q
 i f ( $c12Pd<$c12Qd ) {
 //t ake c e n t r oi d o f i n t e r s e c t i o n a re a end p oi n t s
 $Lx = ( $Px1+$Px2+$Px3 ) / 3;
 $Ly = ( $Py1+$Py2+$Py3 ) / 3;
 } el s e {
 $Lx = ( $Qx1+$Qx2+$Qx3 ) / 3;
 $Ly = ( $Qy1+$Qy2+$Qy3 ) / 3;
 }

 echo " Loc a tion found a t <br />" ;
 echo "Lx : " . $Lx . "<br />" ;
 echo "Ly : " . $Ly . "<br />" ;

 $ALx = $Lx − $Ax ;
 $ALy = $Ly − $Ay ;
 $ALdis t= s q r t (pow ( $ALx , 2 ) +pow ( $ALy , 2 ) ) ;
 //L a ti tude i s Y−a xi s and Longitude i s X−a xi s
 //t h e t a = tan i n v e r s e o f y2−y1/x2−x1
 $ACtoX_Angle = 0 ;//with l o c a l coords
 $ALtoX_Angle = acos ( $Lx/$ALdis t ) ;
 $AtoC_geoOrigin = a tan ( ( $Cla t−$Al a t ) / ( $Clong−$Along ) ) ; //Angle with
gl o b al c o o rdi n a t e s l a t , lng o ri gi n ( 0 , 0 )
 $ALtoX_geoOrigin = $AtoC_geoOrigin+$ALtoX_Angle ; //Bearing Angle
 $be a ring = rad2deg ( $ALtoX_geoOrigin ) ;

 //Method 1
 $long= $Along + ( $ALdis t /1000 ) ∗ si n ( $be a ring ) ;
 $ l a t = $Al a t + ( $ALdis t /1000 ) ∗ cos ( $be a ring ) ; //conve r t i n t o km by dividing
by 1000
 //Method 2
 $tmp = $ALdis t/$R ;
 $ l a t 2 = $Al a t+ a si n ( si n ( $Al a t ) ∗ cos ( $tmp ) +cos ( $Al a t ) ∗ si n ( $tmp ) ∗ cos (
$be a ring ) ) ;
 $long2 = $Along + a tan ( si n ( $be a ring ) ∗ si n ( $tmp ) ∗ cos ( $Al a t ) ∗ cos ( $tmp )−si n (
$Al a t ) ∗ si n ( $ l a t ) ) ;

 //echo " ALdist : " . $ALdis t . " < br / > ";
 //echo "ALtoX_Angle : " . rad2deg ( $ALtoX_Angle ) . " < br / > ";
 //echo "ACtoX_Angle : " . rad2deg ( $ACtoX_Angle ) . " < br / > ";
 //echo " AtoC_geoOrigin : " . rad2deg ( $AtoC_geoOrigin ) . " < br / > ";
 //echo " ALtoX_geoOrigin : " . rad2deg ( $ALtoX_geoOrigin ) . " < br / > ";
 echo "Method 1 o f be a ring and Dis tance <br />" ;
 echo " La t : " . $ l a t . "<br />" ;
 echo "Long : " . $long . "<br />" ;
 $ u rl = " h t t p s ://www. l a tl o n g . ne t/c/? l a t =" . $ l a t . "&long=" . $long ;
 echo "<a h r e f = $u rl >Cli c k here to see on map</a><br />" ;
 echo "Method 2 o f be a ring and Dis tance <br />" ;
 echo " La t : " . $ l a t 2 . "<br />" ;
 echo "Long : " . $long2 . "<br />" ;
 $ u rl = " h t t p s ://www. l a tl o n g . ne t/c/? l a t =" . $ l a t 2 . "&long=" . $long2 ;
 echo "<a h r e f = $u rl >Cli c k here to see on map</a>" ;

 re tu r n a r r ay ( $Lx , $Ly ) ;
 }








 //Two c i r c l e i n t e r s e c t i o n p oi n t s
 f u n c ti o n g e t C i r c l e I n t e r e c t i o n P o i n t s ( $Ax , $Ay , $Bx , $By , $Ar , $Br ) {
 $del t aX = $Bx − $Ax ;
 $del t aY = $By − $Ay ;
 //d el t a ^2 = del t aX^2+del t aY^2 ///Euclidean Di s t ance
 $ d el t a = s q r t (pow ( $del taX , 2 ) +pow ( $del taY , 2 ) ) ;
 //echo " Del t a : " . $ d el t a . " < br / > ";

 i f ( $del t a > ( $Br+$Ar ) ) {
 echo " There i s no i n t e r s e c t i o n " ;
 e x i t ;
 } el s e i f ( $del t a < ( $Br−$Ar ) ) {
 echo "One c i r c l e i s i n si d e o the r " ;
 e x i t ;
 }
 //R(Rx , Ry) Pe rpendicul a r on AB from P&Q
 //AC = s , BC = t , PR = QR = u
 //s^2 + u^2 = Ar^2
 //t ^2 + u^2 = Br^2
 //S u b t r a c t
 //s^2 − t ^2 = Ar^2 − Br^2
 //( s−t ) ( s+t ) = Ar^2−Br^2
 //sin ce , s+t=d el t a so , t=del t a−s
 //( s−(d−s ) )d = Ar^2−Br^2
 $s = (pow ( $del t a , 2 ) +pow ( $Ar , 2 )−pow ( $Br , 2 ) ) / (2∗ $ d el t a ) ;
 $Rx = $Ax + ( $del t aX ∗ $s ) / $ d el t a ;
 $Ry = $Ay + ( $del t aY ∗ $s ) / $ d el t a ;
 $u = s q r t (pow ( $Ar , 2 )−pow ( $s , 2 ) ) ;

 $Px = $Rx − ( $del t aY∗$u ) / $ d el t a ;
 $Py = $Ry + ( $del t aX∗$u ) / $ d el t a ;
 $Qx = $Rx + ( $del t aY∗$u ) / $ d el t a ;
 $Qy = $Ry − ( $del t aX∗$u ) / $ d el t a ;
 /∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗
 echo "Px : " . $Px . " < br / > ";
 echo "Py : " . $Py . " < br / > ";
 echo "Qx : " . $Qx. " < br / > ";
 echo "Qx : " . $Qy. " < br / > ";
 ∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗∗/
 re tu r n a r r ay ( $Px , $Py , $Qx , $Qy ) ;
 }
