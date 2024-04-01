

const productCardsContainer = document.getElementById('product-cards');
const openDialogButton = document.getElementById('openmissionbutton');
const dialog = document.getElementById('missiondialog');
const closeDialogButton = document.getElementById('closeDialogButton');

closeDialogButton.addEventListener('click', () => {
  dialog.style.opacity = '0'; // 透明度设置为0，触发过渡效果
  setTimeout(() => {
    dialog.style.display = 'none'; // 在过渡完成后隐藏对话框
  }, 300); // 和过渡时间保持一致
});

openDialogButton.addEventListener('click', () => {
  dialog.style.display = 'block';
  setTimeout(() => {
    dialog.style.opacity = '1'; // 透明度设置为1，触发过渡效果
  }, 0); // 这里使用一个很小的延迟以避免过渡被提前触发
});



// 等待頁面載入完成

document.addEventListener("DOMContentLoaded", function () {
  // 獲取標籤導覽元素
  var listGroup = document.getElementById("list-tab");
  var lottieplayer = document.getElementById("lottie-player")
  // 綁定點擊事件處理函式
  listGroup.addEventListener("click", function (event) {
    event.preventDefault(); // 防止點擊後跳轉到其他頁面
    var targetTab = event.target.getAttribute("href"); // 獲取目標標籤的 ID

    // 切換標籤和內容的顯示
    var tabs = listGroup.getElementsByClassName("list-group-item");
    for (var i = 0; i < tabs.length; i++) {
      tabs[i].classList.remove("active", "bg-dark");
    }
    event.target.classList.add("active", "bg-dark");

    var tabContents = document.getElementsByClassName("tab-pane");
    for (var i = 0; i < tabContents.length; i++) {
      tabContents[i].classList.remove("show", "active", "bg-dark");
    }
    document.querySelector(targetTab).classList.add("show", "active");
  });
});

$(document).ready(function () {
  // 检查用户是否已经收到了优惠券通知

});

var successicon1=document.getElementById('successicon1');

var successicon2=document.getElementById('successicon2');
var successicon3=document.getElementById('successicon3');

var icon1=document.createElement("div");
icon1.innerHTML= `
<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ysrp5qfw.json"
style="width:50px; height: 50px;"  autoplay class="lottie-player"> </lottie-player>
`;
var icon3=document.createElement("div");
icon3.innerHTML= `
<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ysrp5qfw.json"
style="width:50px; height: 50px;"  autoplay class="lottie-player"> </lottie-player>
`;
var icon2=document.createElement("div");
icon2.innerHTML= `
<lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ysrp5qfw.json"
style="width:50px; height: 50px;"  autoplay class="lottie-player"> </lottie-player>
`;


$(document).ready(function () {
  $.ajax({
    url: '/object_classes_two.json',
    dataType: 'json',
    success: function (data) {
      var hasToast = data.includes('toast'); // 檢查陣列中是否包含 'toast'
      var hasCoke = data.includes('coke');
      var hasmilk = data.includes('chocolatemilk');

      var progressbarItems = $('.progressbar li'); // 使用 jQuery 選取元素

      var task1Item = $('.progressbar li:nth-child(1)');

      var task2Item = $('.progressbar li:nth-child(2)');
      var task3Item = $('.progressbar li:nth-child(3)');

      if (hasmilk) {
        task1Item.addClass('active'); 
       
        successicon1.appendChild(icon1);
      }

      if (hasToast) {
        task2Item.addClass('active'); // 如果有 'toast'，則讓任務2變為亮
       
        successicon2.appendChild(icon2);

      }

      if (hasCoke) {
        task3Item.addClass('active');
        successicon3.appendChild(icon3);

      }


      if (!hasToast || !hasCoke || !hasmilk) {
        $('.havecoupon').append('<div id="taskcoupon-text" class="todaycoupon-text">再加把勁，快要拿到優惠券拉~~</div>');
        $('.havecoupon').append('<lottie-player src="https://lottie.host/f3d009c5-fd84-46b4-91c9-545dee13f065/B2Jn28vb36.json" style="position: relative; top: -10px; l" loop autoplay></lottie-player>');
      }

      if (hasToast && hasCoke && hasmilk) {
        var couponbuttoncontent=document.getElementById("couponbuttoncontent");
        couponbuttoncontent.innerHTML+=`
        <button class="couponbutton"id="couponbutton" style=" width: 120px; height: 50px;   margin-top: 1px; " >取得優惠卷</button>
        `;

        let cardGenerated = false; // 初始状态为未生成卡片

        couponbutton.addEventListener('click', () => {
          if( cardGenerated ===false ){

            var endingbuttoncontent=document.getElementById("endingbuttoncontent");
            endingbuttoncontent.innerHTML+=`
            <button class="endingbutton"id="endingbutton" style=" width: 120px; height: 50px;   margin-top: 174px; " >傳送優惠卷</button>
            `;


            var modal = document.getElementById('myModal');
            var btn = document.getElementById("endingbutton");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }



            
            const breakfastsale = document.getElementById('breakfastsale');

            breakfastsale.innerHTML = `<div class="card border-secondary mb-3" style="width: 18rem; height:18rem; margin-top:-100px;">
            <div class="card-body">
            <div class="card-hader" style="display: flex;">
            <img src="coupon.png" style="width: 55px; height: 55px;  ">
    
            <h5 class="card-title" style="display: flex;   align-items: center;">恭喜獲得購物優惠卷</h5>
            
            </div>
            
              <h6 class="card-subtitle mb-2 text-body-secondary"  align="right">$折抵10元</h6>
              <p class="card-text">消費時出示此優惠卷可折抵十元</p>
              <h6 class="card-subtitle mb-2 text-body-secondary" >(單次消費僅能使用一張)</h6>
              <img src='https://cdn-icons-png.flaticon.com/128/3932/3932102.png' style="width: 70px; height: 70px; margin-left:90px; margin-top:23px;">
              
    
            </div>
            </div>`
            cardGenerated = true; // 初始状态为未生成卡片
        
        
       
     } else if (cardGenerated === true) {
         const cardExists = document.querySelector('.card.border-secondary.mb-3');

         if (cardExists) {
             alert("已取得優惠摟!");
         }
     }
 });


        // 如果通知以前没有显示过并且同时满足hasToast和hasCoke条件
      
        /*
        const breakfastsale = document.getElementById('breakfastsale');
        breakfastsale.innerHTML = `<div class="card border-secondary mb-3" style="width: 18rem;">
          <div class="card-body">
          <div class="card-hader" style="display: flex;" ">
          <img src="coupon.png" style="width: 55px; height: 55px;  ">
  
          <h5 class="card-title" style="display: flex;   align-items: center;">恭喜獲得購物優惠卷</h5>
          
          </div>
          
            <h6 class="card-subtitle mb-2 text-body-secondary"  align="right">$折抵10元</h6>
            <p class="card-text">消費時出示此優惠卷可折抵十元</p>
            <h6 class="card-subtitle mb-2 text-body-secondary" >(單次消費僅能使用一張)</h6>
  
          </div>
          </div>`
*/
      }


    },
    error: function () {
      console.log('Error fetching data from the server');
    }
  });
});
// 在页面卸载事件时将 localStorage 中的标志设置为 'false'

/*  
        const couponNotificationShown = localStorage.getItem('couponNotificationShown');
if (!couponNotificationShown && hasToast && hasCoke) {
          // 获取dialog元素
          const couponDialog = document.getElementById('couponDialog');
      
          // 显示dialog
          couponDialog.showModal();
      
          // 在localStorage中存储一个标志，表示通知已经显示给用户
          localStorage.setItem('couponNotificationShown', 'true');
      
          // 附加一个点击事件监听器到dialog的关闭按钮
          couponDialog.querySelector('.closecouponbutton').addEventListener('click', function () {
            couponDialog.close(); // 关闭dialog
          });
        }*/ 