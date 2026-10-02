import os
from PIL import Image

def resize_image(path, size):
    if not os.path.exists(path): return
    with Image.open(path) as img:
        img = img.resize(size, Image.Resampling.LANCZOS)
        # Ensure we save as the correct format regardless of extension
        img.save(path)

# Testimonial images
for i in range(1, 4):
    resize_image(f"public/frontend/img/testimonial/testi_2_{i}.png", (100, 100))

# Team images
for i in [1, 4]:
    resize_image(f"public/frontend/img/team/team_2_{i}.jpg", (400, 400))

print("Resizing complete.")
