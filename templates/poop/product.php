<?php
require_once 'include/product_conn.php';
// 取得商品資訊
while ($row = mysqli_fetch_assoc($result)){
  $productImage = $row['image'];
  $productName = $row['name'];
  $productPrice = $row['price'];
  $productSale = $row['sale'];
  $productDescription = $row['message'];
  $cId = $row['c_id'];
}
while ($nnRow = mysqli_fetch_assoc($nnR)) {
  $combineContent = $nnRow['name'];
  $combinePrice = $nnRow['price'];
}
while ($RR = mysqli_fetch_assoc($newResult)) {
  $areaName = $RR['name'];
  $areaNum = $RR['number'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo "$productName";?></title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

  </head>

  <style>
  </style>

  <body>
 
<div class="hero-anime">
  <div class="navigation-wrap bg-light start-header start-style">
		<div class="container" style="height:85px ;vertical-align:middle; font-size:large;">
			<div class="row">
				<div class="col-12">
					<nav class="navbar navbar-expand-md navbar-light">
					
          <a class="nav-link" href = "javascript:history.back()" style="font-size:xx-large; margin-left:-30pt;">＜　</a>
						<a class="navbar-brand" style="margin-left:-18px;" href="http://localhost:3000/templates/home/index.html"><img src="https://memeprod.sgp1.digitaloceanspaces.com/user-resource/76a8ae090dcc5ebe91be5c80efd9cc9a.png">PI CAR</a>	
						
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto py-4 py-md-0">
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/home/index.html">首頁</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://127.0.0.1:5000">辨識商品</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
									<a class="nav-link" >排行/熱銷組合</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 ">
									<a class="nav-link" href="http://localhost:3000/templates/task.html">每日任務</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/manufacture.html">辨識紀錄</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/map.php">商品地圖</a>
								</li>
                
                <form action="productdelete.php" method="post" onsubmit="return confirmDelete()">
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                <button  style="outline: none; border: none; background: none; cursor: pointer; color:brown; margin-top: 3px;">【清除紀錄】</button>
                                </li>
                </form>

                <script>
                          function confirmDelete() {
                          var confirmDelete = confirm("確定刪除全部紀錄嗎?");
                          return confirmDelete;
                                    }
                </script>

							</ul>
						</div>
						
					</nav>		
				</div>
			</div>
		</div>
	</div>

</div>

    <div class="task-manager" style="  margin-top: 80px;">
      <!-- left bar starts -->
        <div class="upper-part">
          <div class="actions"></div>
        </div>
      <div class="page-content" > <!-- 商品資訊 -->
        
        <div class="header">商品資訊：</div>
        <div class="content-categories"></div>
        
        <?php // 顯示商品資訊
          echo "<div style=\"display: flex; align-items: center; overflow-x: hidden; padding:25px;\">
                  <img src=\"$productImage\" width=\"265\" />
                  <div style=\"margin-left: 15px; font-size:16px;\">
                    <h1 style=\"font-size:32px;\"><b>$productName</h1>
                    <h2 style=\"color: red; font-size:24px;\">促銷價: $productSale</b></h2>
                    <p><del>原價: $productPrice</del>　</p>
                    <p>商品資訊: $productDescription</p>
                  </div>
                </div>";

      
        ?>
        <div class="table-container-p"> <!-- 卡 -->
          <table>
          <tr><td>
          <?php
          $otherProductsQuery = "SELECT * FROM info WHERE c_id = $cId AND id != $productId";
          $otherProductsResult = mysqli_query($connection, $otherProductsQuery);

          echo '<div style="display: inline-block;">';
          while ($otherRow = mysqli_fetch_assoc($otherProductsResult)) {
            $otherImage = $otherRow['image'];
            $cId = $otherRow['c_id'];
            echo "<a href=\"map_combine.php?id=$cId\"><img src=\"$otherImage\" width=\"100\"/>";
          }
          echo '</div>';
          ?></td>
          <td><?php
          echo "<a href=\"map_combine.php?id=$cId\" style=\"text-decoration: none;\">
                <p style=\"text-decoration: none;color: #000;font-size:20px;white-space: nowrap;\">
                　　$combineContent<br>
                　　$combinePrice</p>";?></td>
          </tr>
          </table>
          </div>

      </div>
      <div class="right-bar"> <!-- 商品推薦 -->
          <div class="top-part"></div>
          <div class="header">商品地圖：</div>
          <div class="top-part"></div>
          <?php 
            echo "<img src='area/{$areaName}.jpg' id='pui'/><br><br>";
            echo '<span style="font-size: 20px; margin-left: 30px; margin-top: -60px; ">' . $areaName ."：". $areaNum . '</span>';
           ?>
           
          <!-- <link rel="stylesheet" type="text/css" href="css/prod.css">
          <div class="img-container">
          <?php // 取得新資料表的資訊
            // while ($newRow = mysqli_fetch_assoc($newResult)) {
            //   $image = $newRow['image'];
            //   $productLink = "product.php?id=" . $newRow['id'];
            //   //$newColumn2 = $newRow['column2'];
            //   echo "<a href=\"$productLink\"><img src=\"$image\" width=\"130\" />";
            // }
           ?>
           </div> -->
 
      </div>
      
    </div>
  </body>
</html>

<?php
  // 關閉資料庫連結
  mysqli_close($connection);
?>
