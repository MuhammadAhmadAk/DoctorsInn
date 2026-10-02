import os
from rembg import remove
from PIL import Image

def process_image(input_path, output_path):
    print(f"Processing {input_path} -> {output_path}")
    if not os.path.exists(input_path):
        print("Input missing!")
        return
    with open(input_path, 'rb') as i:
        input_data = i.read()
    output_data = remove(input_data)
    with open(output_path, 'wb') as o:
        o.write(output_data)
    print("Done")

process_image(r"C:\Users\Muhammad Ahmad\.gemini\antigravity\brain\bc7ddf87-6d75-47c4-ae9e-9886c7d8700f\real_male_medical_student_1790944580322.jpg", "public/frontend/img/normal/cta-thumb2-1.png")
process_image(r"C:\Users\Muhammad Ahmad\.gemini\antigravity\brain\bc7ddf87-6d75-47c4-ae9e-9886c7d8700f\real_male_instructor_1790944609509.jpg", "public/frontend/img/normal/cta-thumb2-2.png")

