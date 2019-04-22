<?php
$keywords = array();

function returnKeywords ($keywords_array) {
    $list_keywords = "";
    $last_key = key(array_slice($keywords_array, -1, 1, TRUE));
    foreach($keywords_array as $section => $section_array) {

        $list_keywords .= $section . ', ' . ucfirst($section) . ', ' . strtoupper($section) . ', ';

        foreach ($section_array as $data_array => $data){
            if ( $last_key == $section && $data_array == sizeof($section_array)-1) {
                $list_keywords .= $data . ', ' . ucfirst($data) . ', ' . strtoupper($data);
            }
            else {
                $list_keywords .= $data . ', ' . ucfirst($data) . ', ' . strtoupper($data) . ', ';
            }
        }

    }
    return $list_keywords;
}
?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="icon" href="img/ud-icon/ud-favicon.png" type="image/png">