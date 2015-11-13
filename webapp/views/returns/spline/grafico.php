<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_scatter.php');
require_once ('jpgraph/src/jpgraph_regstat.php');

$error = 0.0001;
$xinicio = 1.5;
$xfin = 20.2;

function f($x) {
	return $x * log($x/3) - $x;	
}


$xdata = array();
$ydata = array();
$val = 0;

for($i = $xinicio; $i <= $xfin; $i+=0.1){
	$xdata[$val] = $i;
	$ydata[$val] = f($i);	
	$val++;
}


// Create the graph
$g = new Graph(800,600);
$g->SetMargin(30,20,40,30);
$g->title->Set("Grafico de F(x)");

$g->subtitle->Set('(Puntos de intervalo en azul)');
$g->subtitle->SetColor('darkred');
$g->SetMarginColor('lightblue');

$g->SetScale('int');

// We want 1 decimal for the X-label
$g->xaxis->SetLabelFormat('%1.0f');

// We use a scatterplot to illustrate the original
// contro points.


$lplot = new LinePlot($ydata, $xdata);
$pplot = new ScatterPlot(array(f($xinicio), f($xfin)), array($xinicio,$xfin));
$pplot->SetImpuls();
// Add the plots to the graph and stroke
$g->Add($lplot);
$g->Add($pplot);

$name = time().'test22gr.png';
//if(!file_exists($name))
	$g->Stroke($name);

echo '<img src="'.$name.'" />';

?>

