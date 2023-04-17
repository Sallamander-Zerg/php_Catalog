<?php
    $mysqli = new mysqli("localhost", "root", "", "TZprojectBD"); 
    if ($mysqli->ping()) {
        printf ("Our connection is ok!\n"); 
      } else {
        printf ("Error: %s\n", $mysqli->error); 
      }
     
      function Tree($tree){
        echo '<ul>';
        foreach ($tree as $node) {
            echo '<li><a href="category.php?id=' . $node['id'] . '">' . $node['value'] ;
            if (isset($node['children'])) {
                echo '<ul>';
                  Tree($node['children']);
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
    }

      function buildTree($data, $parent_id) {
        $tree = array();
        foreach ($data as $node) {
            if ($node['parent_id'] == $parent_id) {
                $children = buildTree($data, $node['id']);
                if ($children) {
                    $node['children'] = $children;
                }
                $tree[] = $node;
            }
        }
        return $tree;
    }

      function Ophod($mysqli,$ID){
        $arr=array();
        $id=0;
        $arCategories = $mysqli->query("select NAME from catigoris where PARENT_ID = $ID");
        while ($row = mysqli_fetch_array($arCategories)) { 
             
            array_push($arr,array('id' => $id++, 'parent_id' => $ID, 'value' => $row['NAME']));
        }
        return  $arr;
      }

      function newFather($mysqli,$arChilds,$randParentID){
        $Parent="";
        if($arChilds==null){
          $zapName = mysqli_fetch_array($mysqli->query("select NAME from catigoris where ID = '$randParentID'"));
          $Name = strval($zapName["NAME"]);
          
          AddChild($mysqli,$Name,$randParentID);
        }else{
        $id = array_rand($arChilds);
        foreach($arChilds as $el){
         if($id == $el["id"]){
           $Parent = $el['value'];
         }
        }
          return $Parent;
      } 
    }
      function AddChild($mysqli,$Name,$ID){
        $zapIdParent = mysqli_fetch_array($mysqli->query("select ID from catigoris where NAME = '$Name'"));
        $zapNullParent = $mysqli->query("select ID, NAME from catigoris where PARENT_ID IS NULL");
        $zId = intval($zapIdParent["ID"]);
        $arr= array();
        while ($row =mysqli_fetch_array($zapNullParent)) { 
          array_push($arr,array('id' => $row['ID'],  'NAME' => $row['NAME']));
        }
        foreach($arr as $el){
          if($zId == $el["id"]){
            $ID = rand(1,5000); 
            return $mysqli->query("INSERT INTO `catigoris` (`ID`, `NAME`, `PARENT_ID`) VALUES ('$ID', '$Name - 1', '$zId')");
          }
        }
        if( $zapIdParent == null){
          return $mysqli->query("INSERT INTO `catigoris` (`ID`, `NAME`, `PARENT_ID`) VALUES ('$ID', 'каталог  $ID', NUll )");
        }
        else{
        $colFuther = mysqli_fetch_array($mysqli->query("SELECT count(*) FROM `catigoris` WHERE `PARENT_ID`= $zId"));
        $Numder = intval($colFuther["count(*)"]);
        $Numder+=1;
        $ID = rand(1,5000);
        return $mysqli->query("INSERT INTO `catigoris` (`ID`, `NAME`, `PARENT_ID`) VALUES ('$ID', '$Name - $Numder', '$zId')");
        }
      }
    for($i=1;$i<5000;$i++){
        $randParentID = rand($i,5000);
        $arChilds = ophod($mysqli,$randParentID);
        $parentName= newFather($mysqli,$arChilds,$randParentID); 
        AddChild($mysqli,$parentName,$randParentID);
    }
    $data = array(); 
      $arCategories = $mysqli->query("select * from catigoris");
        while ($row = mysqli_fetch_array($arCategories)) { 
            array_push($data,array('id' => $row['ID'], 'parent_id' => $row['PARENT_ID'], 'value' => $row['NAME']));
        } 
      $tree = buildTree($data,null);
      Tree($tree);
     ?>