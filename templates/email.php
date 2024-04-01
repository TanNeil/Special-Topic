<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 取得POST資料
    $email = $_POST["email"];
    $option = $_POST['option'];

   
    // 設定收件人和郵件主題
    $to = $email;
    $subject = "Finished!!!";
    
    // 郵件內容
    $message = "如需使用優惠券請出示以此兌換~";
    $message = "
            <html>
            <body>
                <p>如需使用優惠券請出示以此兌換~</p>
                <img src='https://cdn-icons-png.flaticon.com/128/3932/3932102.png'>
            </body>
            </html>";
   
    

    // 使用 PHPMailer 來寄送郵件
    $mail = new PHPMailer(true);
    try {
        //設定SMTP伺服器
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // 設定為 DEBUG_SERVER 可以查看詳細的偵錯訊息
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // 你的SMTP伺服器
        $mail->SMTPAuth = true;
        $mail->Username = 'u10912021@ms.ttu.edu.tw'; // 你的郵箱
        $mail->Password = 'F3594111'; // 你的郵箱密碼
        $mail->SMTPSecure = 'ssl'; // 使用 STARTTLS
        $mail->Port = 465; // 一般是587
        

        // 設定郵件相關資訊
        $mail->setFrom('u10912021@ms.ttu.edu.tw'); // 寄件者的信箱和姓名
        $mail->addAddress($to); // 收件者的信箱

        // 設定郵件主題和內容
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->isHTML(true);

        $mail->send();
        echo "寄送成功，兩秒後倒回上一頁刷新資料";
        
        // 清空 object_classes.json 檔案中的物件陣列
        if ($option === 'sendCoupon') {
            $filePath = 'C:\Users\88693\Desktop\meow\object_classes_two.json';
            file_put_contents($filePath, '[]');

            echo "<script>
            setTimeout(function(){
                window.location.href = 'task.html'; 
            }, 2000);
           
          </script>";
        }
        
        elseif ($option === 'checkout') {
            $filePath = 'C:\Users\88693\Desktop\meow\object_classes_two.json';
            $filePathtwo = 'C:\Users\88693\Desktop\meow\object_classes.json';
            file_put_contents( $filePath, '[]');
            file_put_contents( $filePathtwo, '[]');

            echo "<script>
            setTimeout(function(){
                window.location.href = 'home/index.html'; 
            }, 2000);
           
          </script>";
        }

        
    
    } 
    
    catch (Exception $e) {
        echo "寄送郵件時發生錯誤：{$mail->ErrorInfo}";
    }
} 

else {
    echo "請使用表單提交資料。";
}
?>
