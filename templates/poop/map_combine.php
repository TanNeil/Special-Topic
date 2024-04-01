<?php
require_once 'include/map_conn.php';
// 取得商品資訊
while ($row = mysqli_fetch_assoc($result)){
  $CombineId = $row['id'];
}
while ($RR = mysqli_fetch_assoc($newResult)) {
    $areaName = $RR['name'];
  }
while ($nnRow = mysqli_fetch_assoc($nnR)) {
  $combineContent = $nnRow['name'];
  $combinePrice = $nnRow['price'];
}
?>
<style>
  #ppui{
    background-color: #f2f8ff;
  }  
  #pui:hover{
    background-color: #ddeeff;
  }
</style>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo "$combineContent";?></title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

  </head>
    <style>
    </style>
  <body>
  
<div class="hero-anime">
  <div class="navigation-wrap bg-light start-header start-style">
		<div class="container" style="  overflow-y: hidden; height:85px; vertical-align:middle; font-size:large;">
			<div class="row">
				<div class="col-12">
					<nav class="navbar navbar-expand-md navbar-light">
					
          <a class="nav-link" href = "javascript:history.back()" style="font-size:xx-large;">＜　</a>
						<a class="navbar-brand" href="http://localhost:3000/templates/home/index.html"><img src="https://memeprod.sgp1.digitaloceanspaces.com/user-resource/76a8ae090dcc5ebe91be5c80efd9cc9a.png">PI CAR</a>	
						
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto py-4 py-md-0">
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/home/index.html">首頁</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://127.0.0.1:5000">掃描商品</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
									<a class="nav-link" >排行/熱銷組合</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 ">
									<a class="nav-link" href="http://localhost:3000/templates/task.html">每日任務</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/manufacture.html">掃描紀錄</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://localhost:3000/templates/map.php">商品地圖</a>
								</li>
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
      <div class="page-content"> <!-- 商品地圖 -->
        <div class="header">商品地圖：</div>
        <div class="content-categories"></div>
        <?php echo "<img src='area/{$CombineId}.jpg' width=\"680\" id=\"pui\"/><br><br>";
        ?>  
        
      </div>
      <div class="right-bar" id='ppui'> <!-- 商品資訊 -->
          <div class="top-part"></div> <!-- 卡 -->
          <table style="border:1px #ddd solid; padding: 15px;margin: 30px;background-color:#fff;">
          <tr>
          <td style="width: 200px;padding:10px;"><?php
          echo "<p style=\"font-size:20px;\">　　$combineContent</p>
                <p  style=\"font-size:20px; color: red;font-weight: bold;\">　　$combinePrice</p>";?></td>
          </tr>
          </table>
        
          <?php
          $ProductsQuery = "SELECT * FROM info WHERE c_id = $CombineId";
          $ProductsResult = mysqli_query($connection, $ProductsQuery);
          while ($RRow = mysqli_fetch_assoc($ProductsResult) 
                AND $RRz = mysqli_fetch_assoc($zzR)) {
            $combineImage = $RRow['image'];
            $combineProduct = $RRow['name'];
            $combineSale = $RRow['sale'];
            $area = $RRz['name'];
            $nub = $RRz['number'];
            $prodId = $RRow['id'];
            echo "<a href=\"product.php?id=$prodId\" style=\"text-decoration: none;\" id='pui'>
            <div style=\"display: flex; align-items: center;padding:10px;\">            
            　　　
            <img src=\"$combineImage\" width=\"135\"/>
            <div style=\"margin-left: 15px; font-size:16px;color:#000\">
            <p style=\"font-size:20px;\"><b>$combineProduct</b><p>
            <p>促銷價: $combineSale</p>
            <p>$area ： $nub</p>
          </div>
          </div>";
          }
          ?>

      </div>
      
    </div>
  </body>
</html>

<?php
  // 關閉資料庫連結
  mysqli_close($connection);
?>
