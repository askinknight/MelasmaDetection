import sys
import cv2
import numpy as np
from PIL import Image, ImageDraw
from facenet_pytorch import MTCNN
import mediapipe as mp

def process_image(image_path):
    try:
        # Load the image
        img = Image.open(image_path)
        img_cv = np.array(img)

        # Initialize MTCNN for face detection
        mtcnn = MTCNN(keep_all=True)

        # Convert image to RGB (MTCNN expects RGB format)
        img_rgb = cv2.cvtColor(img_cv, cv2.COLOR_BGR2RGB)

        # Detect faces
        boxes, _ = mtcnn.detect(img_rgb)

        if boxes is None:
            raise ValueError("ไม่พบใบหน้าในรูปภาพ")

        # Initialize MediaPipe Face Mesh for landmarks
        mp_face_mesh = mp.solutions.face_mesh
        face_mesh = mp_face_mesh.FaceMesh(min_detection_confidence=0.5, min_tracking_confidence=0.5)
        mp_drawing = mp.solutions.drawing_utils

        # Prepare paths for saving images
        face_path = image_path.replace(".jpg", "_face.jpg")
        pixel_graph_path = image_path.replace(".jpg", "_pixel_graph.png")

        for i, box in enumerate(boxes):
            x1, y1, x2, y2 = map(int, box)
            
            # Crop face image
            face_img_cv = img_cv[y1:y2, x1:x2]
            face_img_pil = Image.fromarray(face_img_cv)

            # Convert cropped face image to RGB for MediaPipe
            face_img_rgb = cv2.cvtColor(np.array(face_img_pil), cv2.COLOR_BGR2RGB)

            # Detect landmarks on the cropped face image
            results = face_mesh.process(face_img_rgb)

            # Draw landmarks on the cropped face image
            draw = ImageDraw.Draw(face_img_pil)
            if results.multi_face_landmarks:
                for face_landmarks in results.multi_face_landmarks:
                    for landmark in face_landmarks.landmark:
                        x = int(landmark.x * face_img_cv.shape[1])
                        y = int(landmark.y * face_img_cv.shape[0])
                        draw.ellipse([(x-2, y-2), (x+2, y+2)], outline='blue', fill='blue')

            # Save the cropped face image with landmarks
            face_img_pil.save(pixel_graph_path)

        # Convert the original image to PIL for drawing bounding boxes
        img_pil = Image.fromarray(img_cv)
        draw = ImageDraw.Draw(img_pil)

        # Draw bounding boxes on the original image
        for i, box in enumerate(boxes):
            x1, y1, x2, y2 = map(int, box)
            draw.rectangle([(x1, y1), (x2, y2)], outline='red', width=2)

        # Save the image with bounding boxes
        img_pil.save(face_path)

        # Print output paths
        print(f"{face_path}|{pixel_graph_path}")

    except Exception as e:
        print(f"เกิดข้อผิดพลาดในการประมวลผล: {str(e)}", file=sys.stderr)

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python script.py <image_path>", file=sys.stderr)
        sys.exit(1)
    
    image_path = sys.argv[1]
    process_image(image_path)
