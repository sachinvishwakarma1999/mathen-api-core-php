<?php 
include('config.php'); 
include('api.php');
$conn->set_charset('utf8');
///header("Access-Control-Allow-Origin");
$conn->set_charset('utf8');
    $userid=0;
    isset($_GET['userid']) ?
    $userid = $_GET['userid'] : "";
    
    isset($_GET['pid']) ?
    $pid = $_GET['pid'] : "";
    if($userid!="" || $userid!=0)
    {
       $sqlchk=$conn->query("SELECT * FROM `whole_recentview` where  `userid`='$userid' AND `productid`='$pid'"); 

       if($sqlchk->num_rows>0)
       {
        $update=$conn->query("UPDATE `whole_recentview` SET  `date_time`=now() WHERE `userid`='$userid' AND `productid`='$pid'");
       }
       else
       {
            $sqlQ= "INSERT INTO `whole_recentview`(`userid`, `productid`, `date_time`) VALUES('$userid','$pid',now())";
            $rslt = $conn->query($sqlQ);    
        }
    }  

    $baseUrl = 'https://www.manthanonline.in/productimage/';
    $sql= "select *,if(wp.qty>5, 5,qty) as quantity,wp.id,ceil(((costprice-discountcodes)/costprice)*100) as disPercent,concat('".$baseUrl."',wip.productimage) as product_img, (SELECT avg(`rating`) FROM `whole_rating` WHERE `product_id`=wp.id ) as rating,(SELECT count(`rating_id`) FROM `whole_rating` WHERE `product_id`=wp.id group by  `product_id`) as ratingcount,wp.productname as productname,if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid') IS NULL,0,1) as FavStatus,
        if((SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1) IS NULL,0,(SELECT `wid` FROM `whole_whishlist` where `productid`=wp.id AND `userid`='$userid' limit 1)) as wishid from whole_product as wp JOIN whole_imageupload as wip ON wp.id=wip.pid  where wp.id='$pid'";
    $result=$conn->query($sql);
    $records=[];
    $productDetail =$result->fetch_assoc();
    unset($productDetail->product_img);
    $images = [];
    while($row=$result->fetch_object())
    {
     $images[]=$row->product_img;

    }
    $varient=[];
    $varCate= $productDetail['variant_category'];
    $colorvarient= $productDetail['variant'];
    $arr=explode(',',$varCate);
    $colorarr=explode(',',$colorvarient);
    for($i=0;$i<count($arr);$i++)
    {
        $sql_variant_name="SELECT * FROM `whole_variant_category` where `id`='".$arr[$i]."'  AND `status`='1'";
        $vari_name=$conn->query($sql_variant_name);
        $varientName=$vari_name->fetch_assoc();
        // $varientId=$varientName->id;
        // $varient[$varientName->name]=[];
        $varientId=$varientName['id'];
        $varient[$varientName['name']]=[];
        for($j=0;$j<count($colorarr);$j++)
        {
            $sql="SELECT var.id,name,concat('https://www.manthanonline.in/productimage/',img.productimage)  as prodImg FROM `whole_variant` as var join whole_imageupload as img on img.varpid=var.id where `variant_category`='$varientId' AND var.`id`='".$colorarr[$j]."' AND pid='$pid'";
            $result=$conn->query($sql);
            $rowcount= $result->num_rows;
            if($rowcount!=0)
            {
                while($row=$result->fetch_object())
                {
                    // $varient[$varientName['name']][]=$row;
                    $varient['Color'][$row->name][]=$row;
                }
                
            }
            else
            {
                $sql="SELECT id,name FROM `whole_variant` where `variant_category`='$varientId' AND `id`='".$colorarr[$j]."'";
                $result=$conn->query($sql);
                while($row=$result->fetch_object())
                {
                    $varient[$varientName['name']][]=$row;
                }
            }
            
            
        }
    }
    $sqlQ="SELECT DISTINCT(`name`)as name FROM `whole_variant_category` ORDER BY `name`  DESC";
    $otherCat=$conn->query($sqlQ);
    
    while($row=$otherCat->fetch_object())
    {
        if (array_key_exists($row->name,$varient))
        {
        }
        else
        {
            $varient[$row->name]=[];
        }
        
    }
    $selectRel="SELECT `relatedproducts` FROM `whole_product` WHERE `id`='$pid'";
    $selectRelresult=$conn->query($selectRel);
    $related = [];
    $relatedProd = [];
    $prodIds=$selectRelresult->fetch_assoc();
    if($prodIds['relatedproducts']!=null)
    {
        
        $sqlrel= "select id as ProdID,productname,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,wp.costprice,wp.discountcodes,wp.qty  from whole_product as wp where wp.displayflag='1' AND relatedproducts IN (".$prodIds['relatedproducts'].")";
        $relresult=$conn->query($sqlrel);
        $prod=$relresult->fetch_object();
        $rowcount= $relresult->num_rows;
        while($row = $relresult->fetch_assoc())
        {
            $related[] = $row;
        }
        for($i=0;$i<count($related);$i++)
        {
            $sqlimg1="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$related[$i]['ProdID']."'";
            $resultimg1=$conn->query($sqlimg1);
            $data2[$i] = $resultimg1->fetch_assoc();
        }
        foreach($related as $key=>$val){ // Loop though one array
            $val2 = $data2[$key]; // Get the values from the other array
            $relatedProd[$key] = $val + $val2; // combine 'em
        }
    }

    $sqllatest="select id as ProdID,productname,if(wp.discountcodes='0.00',0,ceil(((wp.costprice-wp.discountcodes)/wp.costprice)*100))as disPercent,wp.discountcodes,wp.costprice from whole_product as wp where wp.displayflag='1' and wp.dealoffer='' ORDER BY wp.id DESC LIMIT 9";
    $resultlatest=$conn->query($sqllatest);
    while($row = $resultlatest->fetch_assoc()){
        $result3[]=$row;
    }
    for($i=0;$i<count($result3);$i++)
    {
        $sqlimg2="SELECT concat('https://www.manthanonline.in/productimage/',`productimage`) as product_image FROM `whole_imageupload` where `pid`='".$result3[$i]['ProdID']."'";
        $resultimg2=$conn->query($sqlimg2);
        $data3[$i] = $resultimg2->fetch_assoc();
    }
    $latestArr= [];
    foreach($result3 as $key=>$val){ // Loop though one array
        $val2 = $data3[$key]; // Get the values from the other array
        $latestArr[$key] = $val + $val2; // combine 'em
    }
    $sqlreview= "SELECT * FROM `whole_rating` where `product_id`='$pid'";
    $resReview=$conn->query($sqlreview);
    $review=[];
    while($row=$resReview->fetch_object())
    {
     $review[]=$row;

    }
    
    $productDetail['images'] = $images;
    $productDetail['relatedProd'] = $relatedProd;
    $productDetail['latestProd'] = $latestArr;
    $productDetail['review']= $review;
    $productDetail['varient'] = $varient;
    $message = "product details";
    $result = $productDetail;
    $data = array("message"=>$message,"result"=>$productDetail);
    responseSuccess($data);

 ?>

