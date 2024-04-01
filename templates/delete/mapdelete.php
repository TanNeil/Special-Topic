<?php
$file_path = 'C:\Users\88693\Desktop\meow\object_classes.json';
$file_path_two = 'C:\Users\88693\Desktop\meow\object_classes_two.json'; // 你的 object_classes.json 檔案路徑

// 清空檔案內容
file_put_contents($file_path, '[]');
file_put_contents($file_path_two, '[]');

echo "<script>
            setTimeout(function(){
                window.location.href = 'http://localhost:3000/templates/map.php'; 
            }, 1000);
            
          </script>";
?>
