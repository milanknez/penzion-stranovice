from PIL import Image
import os

def remove_background(input_path, output_path):
    print(f"Processing: {input_path}")
    img = Image.open(input_path)
    img = img.convert("RGBA")
    
    datas = img.getdata()
    
    new_data = []
    
    for item in datas:
        # Check for white or grey (common checkerboard colors)
        r, g, b, a = item
        
        # If the pixel is very close to white or some shade of grey
        # and the color components are very similar (neutral colors)
        is_white = r > 200 and g > 200 and b > 200
        is_grey = abs(r - g) < 10 and abs(g - b) < 10 and abs(r - b) < 10 and r > 150
        
        if is_white or is_grey:
            new_data.append((255, 255, 255, 0))
        else:
            new_data.append(item)
            
    img.putdata(new_data)
    img.save(output_path, "PNG")
    print(f"Saved to: {output_path}")

if __name__ == "__main__":
    logo_path = "logo_final.png"
    output_path = "logo_final_transparent.png"
    
    if os.path.exists(logo_path):
        remove_background(logo_path, output_path)
    else:
        print(f"Error: {logo_path} not found.")
