/* 


//вывод элементов
$id = $_GET['id'];

while($id!= 1){


    $arParent = $mysqli->query("select * from catigoris where ID=".$id);
    if($row = mysqli_fetch_array($arCategories)){
        $arIds = $row['PARENT_ID'];
        $id = $row['PARENT_ID'];
    }

}
for
*/

//array($id ,8,7,6,5,4,3,2,1) Категория 1-2-3-4-5-6-7-8-9-$id