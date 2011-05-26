<?

//
// init
//

$_AS['db']='articlesystem';

include_once $_AS['basedir'] . 'inc/class.articlesystem.php'; //Basisklasse
include_once $_AS['basedir'] . 'inc/class.lang.php'; //Sprachobjekt

//AdoDB initialtisieren
$adodb =& $GLOBALS['sf_factory']->getObject('DATABASE', 'Ado');
//Articlesystem initializieren
$_AS['artsys_obj'] = new Articlesystem;

//Collectionklasse laden
include_once $_AS['basedir'] . 'inc/class.articlecollection.php';
include_once $_AS['basedir'] . 'inc/class.elementcollection.php';



// 
// collection
//

$_AS['collection'] = new ArticleCollection();
$_AS['elements'] = new ArticleElements;

#$_AS['collection']->setSearchString($idcatside,'custom1'));

#$_AS['collection']->countitems();

$_AS['collection']->generate();

for($iter = $_AS['collection']->get(); $iter->valid(); $iter->next() ) {

	$_AS['item'] =& $iter->current();	
// zweiter wert von getDataByKey() - true = htmlentities utf8	ausgabe	
	echo $_AS['item']->getDataByKey('idarticle').' - '.$_AS['item']->getDataByKey('title',true).'<br/>';

}

$id=$_AS['item']->getDataByKey('idarticle');

// 
// single view
//

//intialisieren
$_AS['item'] = new SingleArticle;
$_AS['elements'] = new ArticleElements;

//laden
$_AS['item']->loadById($id);
#$_AS['item_elements']=$_AS['elements']->loadById(9);

echo $_AS['item']->getDataByKey('idarticle').' - '.$_AS['item']->getDataByKey('title',true).'<br/>';


unset($adodb,$_AS);

?>
