import json
import torch
import numpy as np
import cv2

stored_object_classes = set()

model = torch.hub.load('ultralytics/yolov5', 'custom',
                       path='best.pt', force_reload=True)

cap = cv2.VideoCapture(0)
try:
    with open('/Users/User/Desktop/meow/object_classes.json', 'r') as f:
        all_object_classes = json.load(f)
        stored_object_classes = set(all_object_classes)
except FileNotFoundError:
    all_object_classes = []
while cap.isOpened():

    success, frame = cap.read()
    if not success:
        print("Ignoring empty camera frame.")
        continue
    frame = cv2.resize(frame, (800, 480))
    results = model(frame)

    detected_objects = results.pandas().xyxy[0]

    object_classes = detected_objects['name'].tolist()

    for obj_class in object_classes:
        if obj_class not in stored_object_classes:
            all_object_classes.append(obj_class)
            stored_object_classes.add(obj_class)
        else:
            print("已偵測過，不新增")

    print(all_object_classes)
    cv2.imshow('YOLO COCO 01', np.squeeze(results.render()))
    if cv2.waitKey(1) & 0xFF == ord('q'):  # if I press enter
        with open('/Users/User/Desktop/meow/object_classes.json', 'w') as f:
            json.dump(all_object_classes, f)
        break

cap.release()
cv2.destroyAllWindows()
