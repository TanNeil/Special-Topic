var videoStream = document.getElementById('video-stream');
var startButton = document.getElementById('start-button');
var stopButton = document.getElementById('stop-button');
var videoFeedUrl = "/video_feed";
var recordingAnimation = document.getElementById('recording');
let fetchInterval;
var mediaStream;
const card_group = document.getElementById('card_group');

fetchInterval = setInterval(fetchJSON, 2000);

startButton.addEventListener('click', function () {
  recordingAnimation.play();
  startButton.play();
  stopButton.stop();
  fetchInterval = setInterval(fetchJSON, 2000);

});
stopButton.addEventListener('click', function () {
  recordingAnimation.stop();
  startButton.stop();
  stopButton.play();
  clearInterval(fetchInterval);
});





function startCamera() {

  videoStream.src = videoFeedUrl;

}

function stopCamera() {


  videoStream.src = "static/js/S__20996125.jpg";

  videoStream.style.width = "100%";
  videoStream.style.height = "450px";


}

LottieInteractivity.create({
  player: "#stop-button",
  mode: "click",
  actions: [
    {
      position: { x: [0, 1], y: [0, 1] },
      type: "loop",
      frames: [0, 42]
    },
    {
      position: { x: -1, y: -1 },
      type: 'stop',
      frames: [0],
    }
  ]
});

LottieInteractivity.create({
  player: "#start-button",
  mode: "click",
  actions: [
    {
      position: { x: [0, 1], y: [0, 1] },
      type: "loop",
      frames: [0, 34]
    },
    {
      position: { x: -1, y: -1 },
      type: 'stop',
      frames: [0],
    }
  ]
});
function stopAndStartCamera(event) {
  if (videoStream.src == '/video_feed') {
    event.preventDefault(); // 阻止默认的右键单击行为
  } else {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:5000/start_camera", true);  // 这里的URL应该与Python服务器的地址和端口对应
    xhr.send();
  }
}



let previousData = null; // 保存之前获取的JSON数据


function fetchJSON() {
  fetch('/object_classes.json')
    .then(response => response.json())
    .then(data => {
      if (previousData !== null) {
        const newData = data.filter(item => !previousData.includes(item));
        if (newData.length > 0) {
          console.log('新增的数据:', newData);
          sendJSONToPHP(newData)
          //alert('新增的数据: ' + newData.join(', '));
        } else {
          console.log('没有新增的数据');
        }
      }
      previousData = data; // 更新previousData为最新的数据
    })
    .catch(error => {
      console.error('Error fetching JSON:', error);
    });
}

function sendJSONToPHP(newData) {
  fetch('/process_data', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(newData)
  })
    .then(response => response.json())
    .then(
      result => {
        if (result != null) {
          const data = result.result[0];
          const name = data[0];
          
          const price = data[1];
          const sale = data[2];
          const many_sale = data[3];
          const id = data[4];
          const c_id = data[5]
          console.log('Flask 返回的数据:', result);
          console.log('新增商品紀錄的数据:', name, price, sale, many_sale, id, c_id);
          const toast__cell = document.getElementById('toast__cell');

          const card1 = document.createElement('div');
          const card2 = document.createElement('div');

          card1.innerHTML = ` 
            <div class="toast toast--green add-margin show" style="height: 90px;">
              <div class="toast__icon">
                <lottie-player id="stop-button" src="https://assets2.lottiefiles.com/packages/lf20_U3oyjg.json"
                  style="width:40px; height: 60px;"  autoplay>
                </lottie-player>
              </div>
              <div class="toast__content">
                <p class="toast__type">掃描到一件商品<br></br>已偵測到:<a href="http://localhost:3000/templates/poop/product.php?id=${id}">${name}</a>
                <br></br>原價:${price}元  <br></br>目前：${name}特價${many_sale}

                </p>

              </div>
              <div class="toast__close">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
                  xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                  <path fill-rule="evenodd"
                    d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z">
                  </path>
                </svg>
              </div>
          </div>`;
          toast__cell.appendChild(card1);

          const dialog = document.getElementById('missiondialog');
          const closeDialogButton = document.getElementById('closeDialogButton');
          if (name == '抹香柚茶'||name=='吐司'||name=='可樂'||name=='瑞穗調味乳') {
            const dialog_content = document.getElementById('dialog_content');
            const dialog_mission_content = document.createElement('div');
            
            // 清除先前的資訊
            dialog_content.innerHTML = '';
        
            console.log("任務成功");
            dialog.style.display = 'block';
            setTimeout(() => {
                dialog.style.opacity = '1'; // 透明度设置为1，触发过渡效果
            }, 0); // 这里使用一个很小的延迟以避免过渡被提前触发
        
            dialog_mission_content.innerHTML= ` 
                <p>成功達成一項${name}的任務</p><br>
                <a href="http://localhost:3000/templates/task.html">點擊查看任務<br>
            `;
            
            dialog_content.appendChild(dialog_mission_content);
        }
        
        closeDialogButton.addEventListener('click', () => {
            dialog.style.opacity = '0'; // 透明度设置为0，触发过渡效果
            setTimeout(() => {
                dialog.style.display = 'none'; // 在过渡完成后隐藏对话框
            }, 300); // 和过渡时间保持一致
        });
        


          const combine_data = result.result[1];
          const id3 = combine_data[0];
          const name3 = combine_data[1];
          const price3 = combine_data[2];
          const info1_id3 = combine_data[3];
          const info2_id3 = combine_data[4];
          const info1_name3 = combine_data[5];
          const info1_price3 = combine_data[6];
          const info1_image3 = combine_data[7];
          const info2_name3 = combine_data[8];
          const info2_price3 = combine_data[9];
          const info2_image3 = combine_data[10];


          console.log('Flask 返回的数据:', result.result[1])
          console.log('新增組合商品的数据:', id3, name3, price3, info1_id3, info2_id3, info1_name3, info1_price3, info1_image3, info2_name3, info2_price3, info2_image3);
          card2.innerHTML = ` <div class="toast toast--red add-margin show" style="height: 90px;">
          <div class="toast__icon">
            <lottie-player id="stop-button" src="https://lottie.host/0ceefc62-99ce-48f9-b0e2-0b7614cff013/Oo0HZNJXvk.json"
              style="width:40px; height: 60px;"  autoplay>
            </lottie-player>
          </div>
          <div class="toast__content">
            <p > 此商品${price3}: </p>
            <p class="toast__type" style="  display:flex; margin-top: -20px; ">
            <a href="http://localhost:3000/templates/poop/product.php?id=${info1_id3}">
            <img src="${info1_image3}" class="card-img-top" style="width:50px; height: 50px;" >
            </a>
      
            <lottie-player src="https://lottie.host/66016864-7fef-4411-94be-260a37649e97/GEYDWHRY6j.json"
            style="width:50px; height: 50px; ;"  autoplay> </lottie-player> 
            <a href="http://localhost:3000/templates/poop/product.php?id=${info2_id3}">
            <img src="${info2_image3}" class="card-img-top"  style="width:50px; height: 50px;">
            </a>
            </p>

          </div>
          <div class="toast__close">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
              xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
              <path fill-rule="evenodd"
                d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z">
              </path>
            </svg>
          </div>
      </div>

          `;

          toast__cell.appendChild(card2);

          if (result != null) {
            for (let i = 2; i < result.result.length; i++) {
              const data2 = result.result[i];
              const name2 = data2[0];
              const price2 = data2[1];
              const sale2 = data2[2];
              const many_sale2 = data2[3];
              const image2 = data2[4];
              const id2 = data2[5];


              console.log('Flask 返回的数据:', result.result[i]);
              console.log('新增同區商品的数据:', id2, name2, price2, sale2, many_sale2, image2);
              card_group.innerHTML += `
              <div class="card" style="width: 200px;height:300px; margin-left: 5px;">
    
              <a href="http://localhost:3000/templates/poop/product.php?id=${id2}">
              <img src="${image2} " class="card-img-top" style="height: 200px; width: 200px;">
              </a>
              <div class="card-body">
                <h5 class="card-title">${name2}</h5>
    
                <div style=" display: flex;">
                <p class="card-text" >${many_sale2}   </p>
                <p class="card-text"style=" margin-left: 5px;"> 原價:${price2} </p>
                <p class="card-text"style=" margin-left: 5px;"> 現在只要:${sale2}</p>
              </div>
    
              </div>`;

            }
          }



          /*
          if(many_sale!==null){
            card2.innerHTML = ` 
            <div class="toast toast--red add-margin show" style="height: 80px;" >
              <div class="toast__icon">
              <img src="/static/js/sale.png" style="width: 40px; height: 40px; margin-top:5px  ">

                
              </div>
              <div class="toast__content">
              <h4>號外!!此商品大優惠</h4>
                <p class="toast__type" >${name}大特價：${many_sale}</p>
                <p class="toast__message"></p>
              
              </div>
              <div class="toast__close">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
                  xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                  <path fill-rule="evenodd"
                    d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z">
                  </path>
                </svg>
              </div>
          </div>`;
          toast__cell.appendChild(card2);
           }
                 */


          jQuery(document).ready(function () {
            jQuery('.toast__close').click(function (e) {
              e.preventDefault();
              var parent = $(this).parent('.toast');
              parent.fadeOut("2000", function () { $(this).remove(); });
            });
          });

        } else {
          console.log('Flask 返回的数据为空');
        }
      })
    .catch(error => {
      console.error('接收 Flask 响应时出错:', error);
    });

  /*
      fetch('/process_combine_data', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(newData)
      }).then(response => response.json())
        .then(combine_result => {
          if (combine_result != null) {
  
              const combine_data = combine_result.combine_result[0];
              const id3 = combine_data[0];
              const name3 = combine_data[1];
              const price3 = combine_data[2];
              const info1_id3= combine_data[3];
              const info2_id3 = combine_data[4];
              const info1_name3 = combine_data[5];
              const info1_price3 = combine_data[6];
              const info1_image3 = combine_data[7];
              const info2_name3 = combine_data[8];
              const info2_price3 = combine_data[9];
              const info2_image3 = combine_data[10];
    
              console.log('Flask 返回的数据:', combine_data.combine_data[0]);
              console.log('新增組合商品的数据:', id3,name3, price3, info1_id3, info2_id3, info1_name3,info1_price3,info1_image3,info2_name3,info2_price3,info2_image3);
              card_group.innerHTML += `
              `;
    
            
  
          } else {
            console.log('Flask 返回的数据为空');
          }
        })
        .catch(error => {
          console.error('接收 Flask 响应时出错:', error);
    
        });
  
  */

  /*
    fetch('/process_rate_data', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(newData)
    }).then(response => response.json())
      .then(info_result => {
        if (info_result != null) {
          for (let i = 0; i < info_result.info_result.length; i++) {
            const data2 = info_result.info_result[i];
            const name2 = data2[0];
            const price2 = data2[1];
            const sale2 = data2[2];
            const many_sale2 = data2[3];
            const image2 = data2[4];
            const id2= data2[5];
  
  
            console.log('Flask 返回的数据:', info_result.info_result[i]);
            console.log('新增同區商品的数据:', id2,name2, price2, sale2, many_sale2, image2);
            card_group.innerHTML += `
            <div class="card" style="width: 17rem; margin-left: 5px;">
  
            <a href="http://localhost:3000/templates/poop/product.php?id=${id2}">
            <img src="${image2} " class="card-img-top" style="height: 300px; width: 250px;">
            </a>
            <div class="card-body">
              <h5 class="card-title">${name2}</h5>
  
              <div style=" display: flex;">
              <p class="card-text" >${many_sale2}   </p>
              <p class="card-text"style=" margin-left: 5px;"> 原價:${price2} </p>
              <p class="card-text"style=" margin-left: 5px;"> 現在只要:${sale2}</p>
            </div>
  
         
            </div>`;
  
          }
  
  
  
        } else {
          console.log('Flask 返回的数据为空');
        }
      })
      .catch(error => {
        console.error('接收 Flask 响应时出错:', error);
  
      });
  
  */

}


