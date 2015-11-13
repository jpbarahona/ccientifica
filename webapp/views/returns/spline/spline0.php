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

var_dump($xdata);

// Get the interpolated values by creating
// a new Spline object.
$spline = new Spline($xdata,$ydata);

// For the new data set we want 40 points to
// get a smooth curve.
list($newx,$newy) = $spline->Get0();

$linex = array();
$liney = array();
/*
foreach($xdata as $pos => $evaluacion){
	if(isset($xdata[$pos+1])){
		for($i=$evaluacion; $i<$xdata[$pos+1]; $i+=0.1){
			$newy[$i] = $ydata[$pos];
			$newx[$i] = $xdata[$pos];
		}
	}
}
*/
foreach($newx as $key => $nn){
	//echo $newx[$key].' - '. $newy[$key] .'<br>';	
}

//list($newx, $newy) = list($linex,$liney);

/*
for($i=0;$i<count($newx); $i++) {
	//$newx[$i] = $i;
	$newx[$i] = $newy[$i] ;
	//echo $newx[$i]. ' - ' .$newy[$i].'<br>';
}
*/

// Create the graph
$g = new Graph(800,600);
$g->SetMargin(30,20,40,30);
$g->title->Set("SPline grado 0");
//$g->title->SetFont(FF_ARIAL,FS_NORMAL,12);
$g->subtitle->Set('(Puntos ingresados en rojo)');
$g->subtitle->SetColor('darkred');
$g->SetMarginColor('lightblue');

//$g->img->SetAntiAliasing();

// We need a linlin scale since we provide both
// x and y coordinates for the data points.
$g->SetScale('int');

// We want 1 decimal for the X-label
$g->xaxis->SetLabelFormat('%1.0f');

// We use a scatterplot to illustrate the original
// contro points.


$splot = new ScatterPlot($ydata,$xdata);
$splot->mark->SetFillColor('red@0.3');
$splot->mark->SetColor('red@0.5');

foreach($xdata as $key => $x) {
	if(isset($xdata[$key+1])){
		echo 'S<sub>'.$key.'</sub> = '.$ydata[$key] .' <span class="intervalo">['.$xdata[$key].','.$xdata[$key+1].'[</span><br>';
		$lplot[$key] = new LinePlot(array($ydata[$key],$ydata[$key]),array($xdata[$key],$xdata[$key+1]));
		$lplot[$key]->SetColor('#0000FF');
		$g->Add($lplot[$key] ); // lineas
	}
}

// Add the plots to the graph and stroke

$g->Add($splot); // puntos
$name = implode($xdata).'-'.implode($ydata).'-'.time().'sp0.png';
if(!file_exists($name))
	$g->Stroke($name);

$ruta = 'http://matjazz.ddns.net:8080/ccientifica/webapp/views/returns/spline/';
echo '<img src="'.$ruta.$name.'" />';

?>

