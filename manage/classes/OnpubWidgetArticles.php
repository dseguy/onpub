<?php

/**
 * @author {@link mailto:corey@onpub.com Corey H.M. Taylor}
 * @copyright Onpub (TM). Copyright 2010, Onpub.com.
 * {@link http://onpub.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * Version 2
 * @package onpubgui
 */
class OnpubWidgetArticles
{
  private $pdo;
  private $osection;

  function __construct(PDO $pdo, $osection)
  {
    $this->pdo = $pdo;
    $this->osection = $osection;
  }

  function display()
  {
    $osamaps = new OnpubSAMaps($this->pdo);
    $oarticles = new OnpubArticles($this->pdo);
    $articles = array();

    en('<strong>Articles</strong>', 1, 1);
    en('<small>Use the buttons below to edit/re-order the articles displayed in this section</small>', 1, 1);

    en('<select name="articleIDs[]" size="10" multiple="multiple" id="articles">');

    $queryOptions = new OnpubQueryOptions();
    $queryOptions->orderBy = "ID";
    $queryOptions->order = "ASC";
    $samaps = $osamaps->select($queryOptions, $this->osection->ID);

    if (sizeof($samaps)) {
      for ($i = 0; $i < sizeof($samaps); $i++) {
        $article = $oarticles->get($samaps[$i]->articleID);
        en('<option value="' . $article->ID . '">' . strip_tags($article->title) . '</option>');
        $articles[] = $article;
      }
    }
    else {
      en('<option value="">None</option>');
    }

    en('</select>', 1, 2);

    en('<input type="button" value="Move Up" id="moveUp"> <input type="button" value="Move Down" id="moveDown"> <input type="button" value="Sort By Date" id="sortByDate"> <input type="button" value="Remove" id="remove">', 1, 2);

    // Output articles as JS objects to enable sorting articles list.
    en('<script type="text/javascript">');
    en('var onpub_articles = [');

    for ($i = 0; $i < sizeof($articles); $i++) {
      $created = $articles[$i]->getCreated();
      en('{ID: ' . $articles[$i]->ID . ', title: "' . $articles[$i]->title . '", created: new Date(' . $created->format("Y") . ', ' . ($created->format("n") - 1) . ', ' . $created->format("j") . ', ' . $created->format("G") . ', ' . $created->format("i") . ', ' . $created->format("s") . ')}', 0);
      if ($i + 1 < sizeof($articles)) {
        en(',');
      }
    }

    en('];');

    en('</script>');
  }
}
?>