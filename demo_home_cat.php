<?php
$sqlproduct=$query->sqlquery("select stripname,striptitle,imagelink1,imagelink2,imagelink3,uploadimage1,uploadimage2,uploadimage3,striplink,id,stripback from ".$sufix."itemstrips `b` where b.displayflag='1'")
or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$num=$query->num($sqlproduct); 
if($num > 0){ $c=1; $y=1;
while($rowstrip=$query->fetchassoc($sqlproduct)){?>       
<section class="products-section section-shadow bg-white">
<div class="container-fluid">
<div class="row">
<div class="col-6">
<div class="title">
<h4><?php echo $rowstrip['stripname']; ?></h4>
</div>
</div>
<div class="col-6">
<div class="viewall">
<a class="strptitle" href="<?php echo $rowstrip['striplink']; ?>"><?php echo $rowstrip['striptitle']; ?></a>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<?php
$sqlproduct5= mysqli_query($GLOBALS["___mysqli_ston"], "select id,discountcodes, stripid,productid,productname,sellingprice,offername,mrp,product_pagename,stockavailability,shortdescription from ".$sufix."product `a`, ".$sufix."product_strip `b` where a.displayflag='1' and b.stripflag='1' and a.id=b.productid and a.productname=b.sproductname and a.itemstrips= '".$rowstrip['id']."' Limit 10 ");
$s1=1;
$numproduct=mysqli_num_rows($sqlproduct5);
if($numproduct>0)
{
?>
<div class="products-slider4 products-style-2 nav-style-2 owl-carousel owl-theme" data-margin="30" data-dots="false" data-autoplay="false" data-nav="true" data-loop="false">
<?php
while($rows1=$query->fetchassoc($sqlproduct5))
{			
$sqlrating="select rating from  whole_rating where product_id='".$rows1['id']."'";
$Resultrating=mysqli_query($GLOBALS["___mysqli_ston"], $sqlrating) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$totalreview=mysqli_num_rows($Resultrating);
$totalrat = 0;
while($rowsrating=mysqli_fetch_array($Resultrating))
{
$totalrat=$totalrat+$rowsrating['rating'] ;  
}
@$ratings=round($totalrat/$totalreview);
$ratingsww=5-$ratings;
?> 

<div class="item">
<div class="product-box common-cart-box">
<div class="product-img common-cart-img">
<a href="<?php echo URL; ?>/<?php echo $rows1['product_pagename']; ?>"><img src="<?php echo URL; ?>/productimage/thumb/<?php $product->productimage($sufix,$rows1['id']) ; ?>" alt="<?php echo $rows1['productname']; ?>"></a>
<div class="hover-option">
<ul class="hover-icon">
<li><a href="<?php echo URL; ?>/<?php echo $rows1['product_pagename']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
<div id="quick-view-<?php echo $rows1['id'];?>" class="white-popup quickview-popup mfp-hide">
<button type="button" class="mfp-close" data-dismiss="modal" aria-label="Close" onclick="javascript:window.close()">
<span aria-hidden="true"><i class="ion-close-round"></i></span>
</button>
<div class="row">
<div class="col-md-5">
<div>
<?php 
$sql4="select * from ".$sufix."imageupload where displayflag='1' and pid='".$rows1['id']."' order by mainimage desc";
$sqlimage=$query->sqlquery($sql4); 
while($rowimage=$query->fetchassoc($sqlimage))
{
$largimage=URL."/productimage/".$rowimage['productimage'];
}
?>
<img id="product_img" src="<?php echo $largimage; ?>"  />
</div>
</div>
<div class="col-md-7">
<div class="quickview-product-detail">
<h2 class="box-title"><?php echo $rows1['productname']; ?></h2>
<?php
if($rows1['discountcodes']==0)
{
$sellprice=$rows1['sellingprice'];

?><h3 class="box-price">₹ <?php echo $rows1['sellingprice']; ?></h3>
<?php
} else {
$mrp=$rows1['sellingprice'];
$discountcodes=$rows1['discountcodes'];
$discountprice=$mrp-$discountcodes;
$percentageprice=ceil($discountprice*100/$mrp);

?>
<h3 class="box-price"><del>₹ <?php echo $rows1['sellingprice']; ?></del><br/>₹ <?php echo $discountcodes ?> 
<span style="color:#F00;">(<?php echo $percentageprice ?>% off) </span> <span>You&nbsp;Save&nbsp;₹ <?php echo $discountprice; ?></span></h3>
<?php }?>
<div class="rating ">
<?php for($y=0;$y < $ratings; $y++) { ?>
<img src="<?php echo URL; ?>/image/star-yellow.jpg" >
<?php  }?>
<?php for($y=0;$y<$ratingsww;$y++) { ?>
<img src="<?php echo URL; ?>/image/star-white.jpg">
<?php  }?>
</div>
<p class="stock">Availability: <span><?php echo $rows1['stockavailability']; ?></span></p>
<p><?php echo substr($rows1['shortdescription'],0,150); ?></p>
<div class="quantity-box">
<div class="quickview-cart-btn">
<a href="<?php echo URL; ?>/<?php echo $rows1['product_pagename']; ?>" class="btn btn-primary">View Product</a>
</div>
</div>

</div>
</div>
</div>
</div>
<li><a href="#quick-view-<?php echo $rows1['id'];?>" class="quickview-popup-link"><i class="fa fa-eye"></i></a></li>
<form action="<?php echo URL; ?>/wishlist_process.php" method="post">
<input name="pid" type="hidden" value="<?php echo $rows1['id']; ?>" />
<input name="pname" type="hidden" value="<?php if($productname2!='') { echo $productname2; } else { echo $productname; } ?>" />
<li><a href=""><button type="submit" value="" style="background-color: transparent; border: none;" ><i class="fa fa-heart" style="font-size: 14px; color:#fff;"></i></button></a></li>
</form>
</ul>
<ul class="product-color">
<li><a href="#" class="black-dot"></a></li>
<li><a href="#" class="pink-dot"></a></li>
<li><a href="#" class="orange-dot"></a></li>
</ul>
<ul class="product-color">
<li><a href="#" class="black-dot"></a></li>
<li><a href="#" class="pink-dot"></a></li>
<li><a href="#" class="orange-dot"></a></li>
</ul>
</div>
</div>
<div class="product-info common-cart-info">
<a href="<?php echo URL; ?>/<?php echo $rows1['product_pagename']; ?>" class="cart-name"><?php echo substr($rows1['productname'],0,15); ?>...</a>
<div class="rating rateit"> 
<?php for($y=0;$y<$ratings;$y++) { ?>
<img src="<?php echo URL; ?>/image/star-yellow.jpg" style="width:18px; height:16px; float:left;" >
<?php }?>
<?php for($y=0;$y<$ratingsww;$y++) { ?>
<img src="<?php echo URL; ?>/image/star-white.jpg" style="width:18px; height:16px; float:left;" >
<?php } ?>
</div>
<?php 
if($rows1['discountcodes']<=0)    
{
$sellprice=$rowproduct['sellingprice'];

?> 	
<p class="cart-price" style="font-size:16px; color:#000;">₹<?php echo $rows1['sellingprice']; ?></p>
<?php } else { 
$mrp=$rows1['sellingprice'];
$discountcodes=$rows1['discountcodes'];
$discountprice=$mrp-$discountcodes;
$percentageprice=ceil($discountprice*100/$mrp);

?>

<p class="cart-price"><strong>₹<?php echo $rows1['discountcodes']; ?></strong></p>
<del>₹<?php echo $rows1['sellingprice']; ?></del> &nbsp; <span style="color:#F00;"> 
(<?php echo $percentageprice ?>% off)</span>
<?php } ?>
</div>
</div>
</div>
<?php } ?>
</div>
<section class="offer-section shop-hover-style-2 section-shadow bg-white" style="
margin: 15px 0px 0px 0px;
padding: 15px 0px 0px 0px;
box-shadow: none;">
<div class="container-fluid" style="
margin: 15px 0px 0px 0px;
padding: 0px;">
<div class="row">
<?php if($rowstrip['uploadimage1'])
{ ?>
<div class="col-md-4">
<a href="<?php echo $rowstrip['imagelink1']; ?>" class="offer-banner shop-hover">
<img src="<?php echo URL; ?>/bannerimages/<?php echo $rowstrip['uploadimage1']; ?>"></a>
</div>
<?php }  else { ?>
<?php }?>
<?php if($rowstrip['uploadimage2'])
{ ?>
<div class="col-md-4">
<a href="<?php echo $rowstrip['imagelink2']; ?>" class="offer-banner shop-hover">
<img src="<?php echo URL; ?>/bannerimages/<?php echo $rowstrip['uploadimage2']; ?>"></a>
</div>
<?php }  else { ?>
<?php }?>
<?php if($rowstrip['uploadimage3'])
{ ?>
<div class="col-md-4">
<a href="<?php echo $rowstrip['imagelink3']; ?>" class="offer-banner shop-hover">
<img src="<?php echo URL; ?>/bannerimages/<?php echo $rowstrip['uploadimage3']; ?>"></a>
</div>
<?php }  else { ?>
<?php }?>
</div>
</div>
</section>
<?php } ?>
</div>
</div>
</div>
</section>
<!-- End Popular Products Section -->