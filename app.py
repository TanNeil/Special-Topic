from flask import Flask, jsonify, render_template, Response, request, send_file,redirect,flash
import cv2
import torch
import json
import mysql.connector
from flask import jsonify

app = Flask(__name__)

db = mysql.connector.connect(
    host="localhost",  # 資料庫主機位置
    user="root",  # 使用者名稱
    password="",  # 使用者密碼
    database="shoppingmull3"  # 資料庫名稱
)
cursor = db.cursor()




stored_object_classes = set()

model = torch.hub.load('ultralytics/yolov5', 'custom', path='finalbest.pt', force_reload=True)

def get_camera_frame():
    camera = cv2.VideoCapture(0)

    while True:
        with open('C:/Users/88693/Desktop/meow/object_classes.json', 'r') as f:
            all_object_classes = json.load(f)
            stored_object_classes = set(all_object_classes)
    
        success, frame = camera.read()
        if not success:
            break
        else:
            frame = cv2.resize(frame, (800, 430))
            results = model(frame)
            detected_objects = results.pandas().xyxy[0]
            object_classes = detected_objects['name'].tolist()

            for obj_class in object_classes:
                if obj_class not in stored_object_classes:
                    stored_object_classes.add(obj_class)
                    all_object_classes.append(obj_class)
                    with open('C:/Users/88693/Desktop/meow/object_classes.json', 'w') as f:
                        json.dump(list(all_object_classes), f)
                    # 新增以下程式碼，將偵測到的物件也存到新的 JSON 檔案中
                    with open('C:/Users/88693/Desktop/meow/object_classes_two.json', 'r') as f:
                        new_object_classes = json.load(f)
                    if obj_class not in new_object_classes:
                        new_object_classes.append(obj_class)
                        with open('C:/Users/88693/Desktop/meow/object_classes_two.json', 'w') as f:
                            json.dump(new_object_classes, f)
                    else:
                        print(f"{obj_class} 已存在於 object_classes_two.json 中，不新增")
                else:
                    print(f"{obj_class} 已存在於 object_classes.json 中，不新增")

            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()
            yield (b'--frame\r\n'
                b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')


@app.route('/')
def index():
    return render_template('index.html', object_classes=stored_object_classes)

@app.route('/object_classes.json', methods=['GET'])
def get_local_json():
    json_file_path = 'object_classes.json'
    return send_file(json_file_path, mimetype='application/json')



@app.route('/video_feed')
def video_feed():
    return Response(get_camera_frame(), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/delete_object_classes', methods=['POST'])
def update_object_classes():
    # 在這裡新增一個空陣列
    updated_object_classes = []

    # 將更新後的物件類別寫入到 object_classes.json 中
    with open('object_classes.json', 'w') as json_file:
        json.dump(updated_object_classes, json_file)

    # 同樣的操作也適用於 object_classes_two.json
    updated_object_classes_two = []
    with open('object_classes_two.json', 'w') as json_file:
        json.dump(updated_object_classes_two, json_file)
    
    

    # 返回首頁
    return redirect('/') 


@app.route('/process_data', methods=['POST'])
def process_data():
    data = request.get_json()

    # 擷取要搜尋的 English_name
    english_name = data[0]

    # 執行資料庫查詢
    cursor.execute("SELECT name, price, sale, many_sale,a_id,id,c_id FROM info WHERE English_name = %s", (english_name,))
    data_result = cursor.fetchone()

    c_id=data_result[6]
    print(c_id)
    print (data_result)

    cursor.execute("SELECT combine.*, info1.name AS info1_name, info1.price AS info1_price,  info1.image AS info1_image, info2.name AS info2_name, info2.price AS info2_price,  info2.image AS info2_image FROM combine INNER JOIN info AS info1 ON combine.info1_id = info1.id INNER JOIN info AS info2 ON combine.info2_id = info2.id WHERE combine.id =  %s",(c_id,))
    combine_result=cursor.fetchone()    

    print (combine_result)

    
    cursor.execute("SELECT purchasebuyrate_id FROM info WHERE English_name = %s", (english_name,))
    purchasebuyrate_id_result = cursor.fetchone()
    purchasebuyrate_id = purchasebuyrate_id_result[0]

    cursor.execute("SELECT NO_1_id, NO_2_id, NO_3_id, NO_4_id FROM purchasebuyrate WHERE id = %s", (purchasebuyrate_id,))
    purchasebuyrate_result = cursor.fetchall()
    if not purchasebuyrate_result:
                # 如果 purchasebuyrate_result 為空，返回空的查詢結果
                return jsonify(info_result=[])

    NO_1_id, NO_2_id, NO_3_id, NO_4_id = purchasebuyrate_result[0]

    cursor.execute("SELECT name, price, sale, many_sale,image ,id FROM info WHERE id IN (%s, %s, %s, %s)", (NO_1_id, NO_2_id, NO_3_id, NO_4_id))
    info_result = cursor.fetchall()

    result=(data_result,combine_result,info_result[0],info_result[1],info_result[2],info_result[3])

    print (result)

    return jsonify(result=result)


if __name__ == '__main__':
    app.run()
