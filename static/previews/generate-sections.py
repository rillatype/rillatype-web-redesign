"""Generate placeholder images for non-font product sections."""
from PIL import Image, ImageDraw, ImageFont
import os

OUT = os.path.dirname(__file__)

# (filename, title, subtitle, bg_color, accent)
items = [
    ("brush-set-1.jpg", "Ink Brush Set", "Procreate brushes", "#e8e4df", "#5a5248"),
    ("graphic-pack-1.jpg", "Stamp & Badge Pack", "Graphic elements", "#dce4e0", "#4a5e56"),
    ("font-bundle-1.jpg", "Foundry Bundle Vol. 1", "3 fonts · 12 styles", "#e2e5ec", "#3d4560"),
    ("brush-set-2.jpg", "Marker Toolkit", "Procreate brushes", "#ece2df", "#6b4f48"),
    ("graphic-pack-2.jpg", "Label & Tag Pack", "Graphic elements", "#e0e6e2", "#4e5e52"),
    ("font-bundle-2.jpg", "Display Duo", "2 fonts · 6 styles", "#e4e2e8", "#4e4860"),
    ("brush-set-3.jpg", "Watercolor Wash", "Procreate brushes", "#dfe4ea", "#485260"),
]

for filename, title, subtitle, bg, accent in items:
    img = Image.new("RGB", (1200, 800), bg)
    draw = ImageDraw.Draw(img)
    # subtle geometric shapes for visual interest
    for i in range(5):
        x = 150 + i * 200
        y = 200 + (i % 3) * 150
        draw.ellipse([x, y, x + 120, y + 120], outline=accent, width=2)
    # large decorative text area
    draw.rectangle([100, 550, 1100, 700], fill=accent)
    # title
    try:
        font_title = ImageFont.truetype("arialbd.ttf", 48)
        font_sub = ImageFont.truetype("arial.ttf", 28)
    except:
        font_title = ImageFont.load_default()
        font_sub = ImageFont.load_default()
    draw.text((130, 575), title, fill=bg, font=font_title)
    draw.text((130, 640), subtitle, fill=bg, font=font_sub)
    img.save(os.path.join(OUT, filename), quality=85)
    print(f"  {filename}")

print("Done.")
