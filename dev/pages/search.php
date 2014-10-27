<?php
## Start HTML output
#require 'layout_top.html';
echo "search";
$db = new database_prepared('local');
$encoding = new \ForceUTF8\Encoding();

$q = $_GET["srch-term"];

$sokeordArr = explode(" ", $q);
$sokeordArr = array_diff($sokeordArr, array(" ", ""));
$Sokeord = implode(" ", $sokeordArr);
if (empty($Sokeord)) {
    echo '<h3>Ingen treff... </h3>';
    goto end;
}
foreach ($sokeordArr as $enkeltOrd) {
    if (strlen($enkeltOrd) > 2) {
        $getFieldsArr = array('FK_ItemID', array("LOWER(TitleWord)", "TitleWord"));
        $queryEnd = "FORCE INDEX ( soundex_index ) WHERE Title_soundex =  SOUNDEX(?)";
        $SoundexArr = array($enkeltOrd);
        $res = $db->get("Search_title", $getFieldsArr, $queryEnd, $SoundexArr);
        $resultArr[] = $res;
    }
}
$items = "";
if (!empty($resultArr)) {
    foreach ($resultArr[0] as $res) {
        $items .= $res["FK_ItemID"] . ",";
    }
    $items = substr($items, 0, -1);
}
if (empty($items)) {
    echo '<h3>Ingen treff... </h3>';
    goto end;

}
$titles = $db->get("Kategorier", array("Tittel", "Kortbeskrivelse", "Lager"), "WHERE FK_ItemID IN (" . $items . ") AND VareAktiv = ?", array(1));

echo '<h5>Søk på

"' . $q . '"

ga ' . count($titles) . ' treff:</h5>';

foreach ($titles as $item) {
    echo '<div class="col-md-4 col-sm-6 col-lg-2">';
    echo '<h4>';
    echo $encoding->fixUTF8($item["Tittel"]);
    echo '</h4>';
    echo $encoding->fixUTF8(strip_tags($item["Kortbeskrivelse"]));
    echo '</div>';
}

end: {
 #   require 'layout_bottom.html';
}