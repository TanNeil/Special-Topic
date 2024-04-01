let Jsondata = [];
let resultArray1 = [];
let resultArray2 = [];
var productEnglishName;
$(document).ready(function () {
  $.ajax({
    url: '/object_classes.json',
    dataType: 'json',
    success: function (data3) {
      Jsondata = data3;
      console.log('讀取到的 JSON 資料:', Jsondata);


    },
    error: function () {
      console.log('讀取 JSON 文件時出錯');
    }
  });
});

fetch('manufacturehistory.php')
  .then(response => response.json())
  .then(data => {
    console.log('historycard', data);
    const productCardsContainer = document.getElementById('product-cards');

    data.forEach(product => {
      var card = document.createElement("div");
      card.className = "card border rounded-0";
      card.style.width = "10rem";
      card.id = "card";

      var col = document.createElement("div");
      col.className = "col";
      col.id = "col";

      var image = document.createElement("img");
      image.src = product.image;
      image.className = "card-img-top";
      image.alt = "Product Image";
      image.style.width = "150px";
      image.style.height = "150px";

      var closeButton = document.createElement("div");

      closeButton.className = "toast__close";
      closeButton.innerHTML = `
      <div></div>

          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
              xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
              <path fill-rule="evenodd"
                  d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z">
              </path>
          </svg>
      `;

      var title = document.createElement("h6");
      title.className = "card-title";
      title.textContent = product.name;

      card.appendChild(col);
      card.appendChild(image);
      card.appendChild(closeButton);
      card.appendChild(title);

      // 添加點擊事件監聽器
      card.addEventListener('click', function () {
        card.classList.add("jello-horizontal");
        setTimeout(function () {
          card.classList.remove("jello-horizontal");
          window.location.href = "http://localhost:3000/templates/poop/product.php?id=" + product.id;
        }, 1000);
      });

      productCardsContainer.appendChild(card);

      jQuery(document).ready(function () {
        jQuery('.toast__close').click(function (e) {
          e.preventDefault();
          var parent = $(this).parent('.card');
          parent.fadeOut("2000", function () { $(this).remove(); });

        });
      });

      closeButton.addEventListener('click', function (e) {
        e.stopPropagation(); // 阻止事件冒泡到包含圖片的元素
        productEnglishName = product.English_name;


        // 在Jsondata中刪除相應的數據
        Jsondata = Jsondata.filter(item => item !== productEnglishName);
        console.log('刪除後的 JSON 陣列資料:', Jsondata);
        // 發送 POST 請求
      

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'manufacture_save_date.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onload = function () {
          if (xhr.status === 200) {
            console.log('成功傳輸 JSON');
          } else {
            console.error('傳輸 JSON 時出錯');
          }
        };
        xhr.send(JSON.stringify(Jsondata));
        window.location.reload();


      });

    });
  })
  .catch(error => {
    console.error('發生錯誤:', error);
  });
// 等待頁面載入完成



const cardgroup = document.getElementById('cardgroup');
const card = document.createElement('div');
let cardinfoname1 = [];

fetch('manufacturecombinesuccess.php')
  .then(response => response.json())
  .then(data => {
    console.log('card', data);

    data.forEach(combine => {
      const info1_id = combine.info1_id;
      const info1_image = combine.info1_image;
      const info1_English_name = combine.info1_English_name;
      const info2_id = combine.info2_id;
      const info2_image = combine.info2_image;
      const info2_English_name = combine.info2_English_name;

      const name = combine.name;
      const price = combine.price;
      const id = combine.id;

      card.innerHTML += `<div class="card" style="width: 380px; align-items: center; margin-top: 5px; ">
      <div style="width: 18rem; display: flex;">           
      <a href="http://localhost:3000/templates/poop/product.php?id=${info1_id}">
      <img src="${info1_image}" class="card-img-top" style="width:100px; height: 100px;" >
      </a>

         <lottie-player src="https://lottie.host/66016864-7fef-4411-94be-260a37649e97/GEYDWHRY6j.json"
         style="width:60px; height: 60px; margin-top: 10px;"  autoplay> </lottie-player>      
         
         <a href="http://localhost:3000/templates/poop/product.php?id=${info2_id}">
         <img src="${info2_image}" class="card-img-top"  style="width:100px; height: 100px;">
         </a>
      </div>
      <div class="card-body">
        <h4>恭喜達成${name}</h4>

        <div style=" display: flex;">
        <p class="card-text" style="margin-top: 5px;">${price}</p>

        <a href="http://localhost:3000/templates/poop/map_combine.php?id=${id}">
        <img src="pin.png"  width="35px" height="35px"  >
        </a>       
         </div>   
        
           </div>
    </div>`


      cardinfoname1.push(info1_English_name);
      cardinfoname1.push(info2_English_name);


    }
    )



    cardgroup.appendChild(card);
    console.log('cardinfoname1', cardinfoname1)
    resultArray1 = Jsondata.filter(item => !cardinfoname1.includes(item));

    console.log('resultArray1', resultArray1);

  })
  .catch(error => {
    console.error('發生錯誤:', error);
  });



const cardgroup1 = document.getElementById('cardgroup1');
const card1 = document.createElement('div');
const cardinfoname2 = [];

fetch('manufacturecombineupcoming.php')
  .then(response => response.json())
  .then(data1 => {
    data1.forEach(combine1 => {
      const info1_id = combine1.info1_id;
      const info1_image = combine1.info1_image;
      const info1_English_name = combine1.info1_English_name;
      const info2_id = combine1.info2_id;
      const info2_image = combine1.info2_image;
      const info2_English_name = combine1.info2_English_name;

      const id = combine1.id;
      const name = combine1.name;
      const price = combine1.price;

      const card = document.createElement('div');
      card.className = "card";
      card.style = "width: 380px; align-items: center; margin-top: 5px; margin-left: 10px;";

      card.innerHTML = `
        <div style="width: 18rem; display: flex;">
          <div class="image-container" id="${info1_id}">
            <img src="${info1_image}" class="card-img-top" id="imgherf1" style="width: 100px; height: 100px;" alt="${info1_English_name}">
          </div>
          <lottie-player src="https://lottie.host/66016864-7fef-4411-94be-260a37649e97/GEYDWHRY6j.json"
            style="width: 60px; height: 60px; margin-top: 10px;" autoplay></lottie-player>
          <div class="image-container" id="${info2_id}">
            <img src="${info2_image}" class="card-img-top" id="imgherf2" style="width: 100px; height: 100px;" alt="${info2_English_name}">
          </div>
        </div>
        <div class="card-body" >
          <h4>即將達成${name}</h4>
          <div style=" display: flex;">
          <p class="card-text" style="margin-top: 5px;">${price}</p>
          <p style="margin-top: 5px;margin-left: 15px;">看看我在哪</p>
          <a href="http://localhost:3000/templates/poop/map_combine.php?id=${id}">
          <img src="pin.png"  width="35px" height="35px"  >
          </a>       
          </div>

        </div>
      `;
      const imgclick = card.querySelectorAll("img");

      // 添加點擊事件監聽器
      imgclick[0].addEventListener('click', function () {
        window.location.href = "http://localhost:3000/templates/poop/product.php?id=" + info1_id;
      });

      imgclick[1].addEventListener('click', function () {
        window.location.href = "http://localhost:3000/templates/poop/product.php?id=" + info2_id;
      });


      cardgroup1.appendChild(card);
      cardinfoname2.push(info1_English_name);
      cardinfoname2.push(info2_English_name);



    });



    resultArray2 = cardinfoname2.filter(item => !resultArray1.includes(item));

    resultArray2.forEach(nobuyinfo => {
      const cardElements = document.querySelectorAll(`[alt="${nobuyinfo}"]`);


      cardElements.forEach(cardElement => {
        if (cardElement && !cardElement.hasAttribute("data-masked")) {
          const imageElement = cardElement.closest(".image-container");
          const innfoID = cardElement.closest(".image-container").id;
          console.log("Mask:innfoID:" + innfoID)
          if (imageElement) {
            const maskElement = document.createElement("div");
            maskElement.className = "image-mask";

            // 創建連結元素並添加遮罩
            const linkElement = document.createElement("a");
            linkElement.href = "http://localhost:3000/templates/poop/product.php?id=" + innfoID;
            linkElement.appendChild(maskElement);

            imageElement.appendChild(linkElement);

            cardElement.setAttribute("data-masked", "true");
          }


        }
      });
    });
  })
  .catch(error => {
    console.error('發生錯誤:', error);
  });
