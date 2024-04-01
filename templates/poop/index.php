<?php
require_once 'include/index_conn.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>排行榜</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

  </head>
  <body>
 
<div class="hero-anime">
  <div class="navigation-wrap bg-light start-header start-style">
		<div class="container" style="  overflow-y: hidden; height:85px; vertical-align:middle; font-size:large;">
			<div class="row">
				<div class="col-12">
					<nav class="navbar navbar-expand-md navbar-light">
					
          <a class="nav-link" href = "javascript:history.back()" style="font-size:xx-large; margin-left:-40px;" id='yee'>＜　</a>
						<a class="navbar-brand" id='yee' style="margin-left:-18px;"href="http://localhost:3000/templates/home/index.html"><img src="https://memeprod.sgp1.digitaloceanspaces.com/user-resource/76a8ae090dcc5ebe91be5c80efd9cc9a.png">PI CAR</a>	
						
						
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						
						<div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left:140px;">
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
               
                <form action="delete.php" method="post" onsubmit="return confirmDelete()">
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

    <div class="task-manager" style="flex: 5;"> <!-- left bar starts -->
      <div class="upper-part">
          <div class="actions"></div>
        </div>
      <div class="page-content"> <!-- 左邊 -->
        <link rel="stylesheet" href="css/table.css">
        <div class="header">排行榜：</div>
        <div class="container"> <!-- 拉軸 -->
                <div class="content"> <!-- 表格區 -->
                    <table border="1" align="center" style="font-size:20px;  width:100%;" class="bordered">
                    <tr align="center" style="font-weight:bold">
                        <th width="100"> TOP </th>
                        <th width="200"> 商品圖片 </th>
                        <th width="500"> 商品名稱 </th>
                        <th width="200"> 促銷價 </th>
                    </tr>
                    <?php foreach($rs as $item){ ?>
                        <tr align="center">
                            <td><?php echo $item['rank']?></td>
                            <td><a href="product.php?id=<?php echo $item['id']?>"><img src="<?php echo $item['image']?>" width="160" /></td> 
                            <td><a href="product.php?id=<?php echo $item['id']?>" class ="link-style"><?php echo $item['name']?></a></td>   
                            <td style="color: red; font-weight: bold;"><?php echo $item['sale']?>元</td>   
                        </tr>
                    <?php }   ?>
                </table>
                </div>      
        </div>
      </div>
      <div class="right-bar" style="flex: 1;"> <!-- 右邊 -->
            <div class="top-part"></div>
            <div class="header">組合推薦：</div>
            <br>
            <div class="container"> <!-- 拉軸 -->
            <div class="card">
                <div class="card-body">
                <?php
                require_once 'include/index_card.php';
                ?>
                </div>
            </div>
            </div>
      </div>

    </div>
  </body>
</html>
