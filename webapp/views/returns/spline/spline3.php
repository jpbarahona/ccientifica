<?php // content="text/plain; charset=utf-8"
require_once ('../../../../src/model/jpgraph/jpgraph.php');
require_once ('../../../../src/model/jpgraph/jpgraph_line.php');
require_once ('../../../../src/model/jpgraph/jpgraph_scatter.php');
require_once ('../../../../src/model/jpgraph/jpgraph_regstat.php');


$valx = $_GET['valx'];
$valy = $_GET['valy']; 

$xdata = array();
$ydata = array();

foreach($valx as $key1=>$vx){
	if($vx != '')
		array_push($xdata, $vx);
}
foreach($valy as $vy){
	if($vy != '')
		array_push($ydata, $vy);
}
array_multisort($xdata,$ydata);

//* CALCULO DE COEFICIENTES */
$h = array();
$b = array(); 
$u = array();
$v = array(); 
$z = array();
$a = array();
$bm = array();
$c = array();

for($i = 0; $i < count($ydata); $i++) {
	$z[$i] = 0;
}


for($i = 0; $i < count($ydata)-1; $i++) {
	$h[$i] = $xdata[$i+1] - $xdata[$i];	
	$b[$i] = 6*($ydata[$i+1] - $ydata[$i]) / $h[$i];
}
$u[1] = 2*($h[0] + $h[1]);
$v[1] = $b[1] - $b[0];

for($i=2; $i < count($ydata)-1; $i++) {
	$u[$i] = 2 * ($h[$i] + $h[$i-1]) - (pow($h[$i-1],2)/$u[$i-1]);
	$v[$i] = ($b[$i] - $b[$i-1]) - $h[$i-1]*$v[$i-1]/$u[$i-1];		
}

for($i=count($ydata)-2; $i>=1; $i--) {
	$z[$i] = ($v[$i]-$h[$i]*$z[$i+1])/$u[$i];	
//	echo $z[$i] .'<br>';
}

for($i = 0; $i < count($ydata)-1; $i++) {
	$a[$i] = ($z[$i+1] - $z[$i])/(6*$h[$i]);
	$bm[$i] = $z[$i] / 2;
	$c[$i] = (-1*$h[$i]*$z[$i+1]/6) - ($h[$i]*$z[$i]/3) + (($ydata[$i+1] - $ydata[$i])/$h[$i]);
	
//	echo $a[$i] .' | '. $b[$i] . ' | '. $c[$i] .'<br>';
}

for($i = 0; $i < count($ydata)-1; $i++) {
	echo 'S<sub>'.$i.'</sub> = '.$ydata[$i] .
	' + (x - '.$xdata[$i].')*'.
	'['.round($c[$i],4).' + (x - '.$xdata[$i].')*['.round($bm[$i],4).' + (x - '.$xdata[$i].')* '.round($a[$i],4).']]'.
	' <span class="intervalo">['.$xdata[$i].','.$xdata[$i+1].'[</span><br>'; 
}



// Get the interpolated values by creating
// a new Spline object.
$spline = new Spline($xdata,$ydata);

// For the new data set we want 40 points to
// get a smooth curve.
list($newx,$newy) = $spline->Get(50);

// Create the graph
$g = new Graph(800,600);
$g->SetMargin(30,20,40,30);
$g->title->Set("SPLine cúbico");
//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
$g->subtitle->Set('(Puntos ingresados en rojo)');

$g->subtitle->SetColor('darkred');
$g->SetMarginColor('lightblue');

//$g->img->SetAntiAliasing();

// We need a linlin scale since we provide both
// x and y coordinates for the data points.
$g->SetScale('int');

// We want 1 decimal for the X-label
$g->xaxis->SetLabelFormat('%1.1f');

// We use a scatterplot to illustrate the original
// contro points.
$splot = new ScatterPlot($ydata,$xdata);

// 
$splot->mark->SetFillColor('red@0.3');
$splot->mark->SetColor('red@0.5');

// And a line plot to stroke the smooth curve we got
// from the original control points
$lplot = new LinePlot($newy,$newx);
$lplot->SetColor('navy');

// Add the plots to the graph and stroke
$g->Add($lplot);
$g->Add($splot);
$name = implode($xdata).'-'.implode($ydata).'-'.time().'sp3.png';
if(!file_exists($name))
	$g->Stroke($name);

$ruta = 'http://matjazz.ddns.net:8080/ccientifica/webapp/views/returns/spline/';

echo '<img src="'.$ruta.$name.'" />';


?>

