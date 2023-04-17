<?php
function getCategoryPath($category_id) {
    $mysqli = new mysqli("localhost", "root", "", "TZprojectBD");
    $path = [];
    while ($category_id) {
        $stmt = $mysqli->query("SELECT * FROM `catigoris` WHERE ID = $category_id");
        $row = mysqli_fetch_array($stmt);
        $path[] = strval($row['NAME']);
        $category_id = intval($row['PARENT_ID']);
    }
    return implode(' > ', array_reverse($path));
}

$category_id = $_GET['id'];
$category_path = getCategoryPath($category_id);
echo $category_path;
?>