<?php include('config.php'); 
include('api.php');
$conn->set_charset('utf8');

isset($_GET['cat_id']) ?
$cat_id = $_GET['cat_id'] : "";

isset($_GET['subcat_id']) ?
$subcat_id = $_GET['subcat_id'] : "";

$checkCat=$conn->query("SELECT  `cat_id`, `parent`, `cat_type` FROM `whole_category`  where (`parent`='$cat_id'  AND `cat_id`='$subcat_id')OR (`cat_id`='$cat_id' AND parent='$subcat_id')");
if($checkCat->num_rows>0)
{
    $row=$checkCat->fetch_assoc();
    if($row['cat_type']=="category")
    {
         $sqlWhere = "WHERE wp.cat_id=".$row['cat_id'];
    }
    else if($row['cat_type']=="subcategory")
    {
        $sqlWhere = "WHERE wp.cat_id=".$row['parent']." AND wp.subcat_id=".$row['cat_id'];
    }
    else if($row['cat_type']=="sub-subcategory")
    {
        $sqlWhere = "WHERE wp.subcat_id=".$row['parent']." AND wp.subsubcat_id=".$row['cat_id'];
    }


    
    $sql="SELECT DISTINCT `cat_id`,`subcat_id`,`subsubcat_id`,
            GROUP_CONCAT(DISTINCT(`variant_category`)) as varCat,if(min(`discountcodes`)=0,min(ceil(`costprice`)),min(ceil(`discountcodes`))) as mindis,if(max(`discountcodes`)=0,max(ceil(`costprice`)),max(ceil(`discountcodes`))) as maxdis FROM  whole_product as wp $sqlWhere group by `cat_id`";
    $result=$conn->query($sql);
    $row=$result->fetch_assoc();
    $varientCat= $row["varCat"];
    $arrVarient=explode(',',$varientCat);
    $newVarient=array_values(array_unique($arrVarient));
    $MaxValue=$row['maxdis'];
    $MaxValue=round($MaxValue);
    $MaxValue = $MaxValue - ($MaxValue % 1000 - 1000);
    $GreterThen=$MaxValue*30/100;
    $Interval=$MaxValue*10/100;
    $DivideValue=$MaxValue-$GreterThen;
    $totalInterval=$DivideValue/$Interval; 

    $part_size = round($row["maxdis"]/6);
    $limit = $row["maxdis"] ;
    for($ii=0;$ii<$totalInterval;$ii++) {
        if($ii==0) 
        {
            $pricestrt[$ii]="0"."--".$Interval;
        }
        else {
                
            $minV=$Interval*$ii;
            $maxV=$minV+$Interval;
            $pricestrt[$ii]=$minV."--".$maxV; 
        }
    } 
    $x=$ii+1;
    $pricestrt[$x]=$DivideValue."--".$MaxValue;
    $data['price']=$pricestrt;
    $m=1;
    $Varient[0]='Price';
    for($i=0;$i<count($newVarient);$i++)
    {
        $selName="SELECT Distinct(name) FROM `whole_variant_category` where `id`='$newVarient[$i]' AND `status`='1'";
        $resName=$conn->query($selName);
        $name=$resName->fetch_assoc();
        $Varient[$m]=$name['name'];
        $uniqueVar=array_unique($Varient);
        $sqlSel="SELECT id,variant_category,name FROM `whole_variant` where `variant_category`='$newVarient[$i]' ";
        $resSel=$conn->query($sqlSel);
        while($row=$resSel->fetch_assoc())
        {
            $data[$name['name']][]=$row;
        }
        $m+=1;
    }
    $data['filterName']=array_values(array_filter($uniqueVar, 'strlen'));
    $message = "Filter List";
    $result = $data;
    $data = array("message"=>$message,"result"=>$result);
    responseSuccess($data);
}
else
{
    $message = "Nothing to show";
    $result = [];
    $data = array("message"=>$message,"result"=>$result);
    responseError($data);
}


?>