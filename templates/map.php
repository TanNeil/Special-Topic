<?php
    // connect database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shoppingmull3";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed" . $conn->connect_error);
    }
    // get data from database
    $sql = "SELECT area.id, area.name, area.number, info.name AS info_name, info.message AS info_message, info.id AS info_id
    FROM area
    INNER JOIN info ON area.id = info.a_id";

    $result = $conn->query($sql);
    $data = array();
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $area = array(
                  'id' => $row["id"],
                  'name' => $row["name"],
                  'number' => $row["number"],
                  'info_name' => $row["info_name"],
                  'info_message' => $row["info_message"],
                  'info_id' => $row["info_id"],
                  
                );
               
                $all_area_item[] = $area;
            }
        } else {
            echo "找不到商品: " . $objectClass . "<br>";
        }
    } 
    $conn->close();
    
    $area_list = ["生活用品區", "零食區", "麵包區", "酒區", "飲料區"];
    $coord_map = [
        "生活用品區" => 
            "158,317,400,194,702,357,467,478,467,578,160,425",
        "零食區" =>
            "918,257,1075,178,1529,410,1532,518,1179,693,1178,594,824,420,920,371",
        "麵包區" => 
            "941,483,1168,599,1172,699,938,815,708,701,709,597", 
        "酒區" =>
            "468,481,704,364,926,477,700,593,700,698,472,585",
        "飲料區" =>
            "400,194,748,19,1053,171,907,248,907,366,818,411"];    
            


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="jQuery Image Maps">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://davidlynch.org/projects/maphilight/jquery.maphilight.min.js"></script>
    <script type="text/javascript" src="https://mattstow.com/experiment/responsive-image-maps/jquery.rwdImageMaps.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>


    
    
    <link rel="stylesheet" href="map.css">
    
    <!-- <script src="map.js"></script> -->
    <script type="text/javascript">
        $(document).ready(function(e) {
            $('.map').rwdImageMaps();
            $('.map').maphilight();

        });
    
    
    </script>
    
</head>
<body>
<div class="hero-anime">
  <div class="navigation-wrap bg-light start-header start-style" >
		<div class="container">
			<div class="row">
				<div class="col-12">
					<nav class="navbar navbar-expand-md navbar-light">
					
                    <a class="nav-link" href = "javascript:history.back()" style="font-size:xx-large; margin-left:-20px;" id='yee'>＜　</a>
						<a class="navbar-brand" id='yee' style="font-size:14pt; margin-left:-21px;"href="http://localhost:3000/templates/home/index.html"><img src="https://memeprod.sgp1.digitaloceanspaces.com/user-resource/76a8ae090dcc5ebe91be5c80efd9cc9a.png">PI CAR</a>	
						
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						
						<div class="collapse navbar-collapse" id="navbarSupportedContent"style="height:90px ;font-size:13pt; ">
							<ul class="navbar-nav ml-auto py-4 py-md-0">
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="home\index.html">首頁</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="http://127.0.0.1:5000">辨識商品</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="poop\index.php">排行/熱銷組合</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 ">
									<a class="nav-link" href="task.html">每日任務</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
									<a class="nav-link" href="manufacture.html">辨識紀錄</a>
								</li>
								<li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
									<a class="nav-link" >商品查詢/地圖</a>
								</li>

                                <form action="delete/mapdelete.php" method="post" onsubmit="return confirmDelete()">
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


<div class="task-manager">
<div class="page-content">
    

<div class="header">商品查詢/地圖
    
<input type="text" id="search" placeholder="搜尋商品...">
<button id="searchButton">搜尋</button>
</div>




<div class="content-categories"></div>
<lottie-player src="https://lottie.host/ae8dba98-36b7-49f2-b7cd-64189caee8c5/LrR5DhBAwW.json"  
style="position: relative; width:70px; height: 70px; top:-115px;left: 160px;" loop autoplay> </lottie-player>

<div class="map_holder">
        
        <img class="map" src="map.jpg" usemap="#map" width="1658" height="988"/>
        <map name="map">
            <?php foreach ($area_list as $key => $value) { ?>
<area id=<?=$key; ?> alt="<?= $value ?>" title="<?= $value ?>" href="#" shape="poly" coords="<?= $coord_map[$value]; ?>" style="outline:none;" data-maphilight='{"strokeColor":"5d98dc","strokeWidth":5,"fillColor":"5d98dc","fillOpacity":0.5}'/>
            <?php } ?>

        </map>
    </div>
    
    
    

</div>




<div class="right-bar">
    <div id="info" style="overflow-y: scroll;">
    <div class="content">
        <table border="1" align="center" style="font-size:20px;  width:100%;" class="bordered" >
            <thead>
                <tr>
                <th style="font-size: 16px; width: 25%;">商品</th>
                <th style="font-size: 16px; width: 12%;">區域</th>
                <th style="font-size: 16px; width: 12%;">貨號</th>
                <th style="font-size: 16px;">商品資訊</th>
                </tr>
            </thead>
            
            <tbody>
        
    </tbody>
        </table>
        </div>
    </div>
</div>

<script>
    var data = <?php echo json_encode($all_area_item); ?>;
    $(document).ready(function(){
        // 隱藏表格標題
        $('thead').hide();


        $('area').click(function(e){
            e.preventDefault();
            var title = $(this).attr('title');
            // remove all rows
            $('#info tbody tr').remove();
            // add rows
            data.forEach(function(item){
                if (item.name == title) {
                    // Create the hyperlink
                    var link = '<a href="poop/product.php?id=' + item.info_id + '">' + item.info_name + '</a>';
                    
                    // Append the row to the table
                    $('#info tbody').append('<tr><td>' + link + '</td><td>' + item.name + '</td><td>' + item.number + '</td><td>' + item.info_message + '</td></tr>');
                }
            });
            
            // 顯示表格標題
            $('thead').show();
        });
    });

    document.getElementById("searchButton").addEventListener("click", function() {
        var searchTerm = document.getElementById("search").value;
        // 在這裡執行您的搜尋邏輯，使用 searchTerm 來進行搜尋
        // 這可以是 JavaScript 或其他程式語言的搜尋邏輯
        // 當搜尋完成後，您可以更新結果或顯示適當的訊息
    });

    $('#searchButton').click(function() {
    var searchTerm = $('#search').val();
    // 清除之前的資訊
    $('#info tbody tr').remove();
    
    // 尋找符合搜尋詞的商品資訊並顯示
    data.forEach(function(item) {
        if (item.info_name == searchTerm) {
            var link = '<a href="poop/product.php?id=' + item.info_id + '">' + item.info_name + '</a>';
            $('#info tbody').append('<tr><td>' + link + '</td><td>' + item.name + '</td><td>' + item.number + '</td><td>' + item.info_message + '</td></tr>');
                }
    });

    
    // 顯示表格標題
    $('thead').show();
    
});

</script>
    
</body>
<script src='https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js'></script>
    <script src='https://unpkg.com/@lottiefiles/lottie-interactivity@latest/dist/lottie-interactivity.min.js'></script>
    <script src="manufacture.js"></script> <!-- 引入 JavaScript 檔案 -->
</html>