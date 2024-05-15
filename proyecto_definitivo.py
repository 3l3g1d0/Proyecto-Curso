import os
import sqlite3
import requests
import shutil

api_key = "5458fba33a434aba677815a33d446ed356dddd785cbef9ba0a5029fa8ad907b4"
carpeta_uploads = "C:\Users\cf2022336\Downloads\laragon\www\paginawebproyecto\uploads"
carpeta_maliciosos = "maliciosos/"
database_file = "virus_total.js"

# Asegurar la creación de carpetas si no existen
if not os.path.exists(carpeta_uploads):
    os.makedirs(carpeta_uploads)
if not os.path.exists(carpeta_maliciosos):
    os.makedirs(carpeta_maliciosos)

conn = sqlite3.connect(database_file)
cursor = conn.cursor()

# Asegurar la estructura de la tabla en la base de datos
cursor.execute('''
    CREATE TABLE IF NOT EXISTS analyzed_files (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        file_name TEXT NOT NULL,
        file_path TEXT NOT NULL,
        is_infected BOOLEAN,
        detections INTEGER,
        detected_by TEXT,
        scan_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
''')

def analizar_archivo(filepath):
    headers = {"x-apikey": api_key}
    files = {"file": (os.path.basename(filepath), open(filepath, "rb"))}
    response = requests.post("https://www.virustotal.com/api/v3/files", headers=headers, files=files)
    
    if response.status_code == 200:
        data = response.json()
        analysis_id = data['data']['id']
        
        # Obtener el reporte del análisis
        report_response = requests.get(f"https://www.virustotal.com/api/v3/analyses/{analysis_id}", headers=headers)
        report_data = report_response.json()
        
        # A veces es necesario esperar a que el análisis esté completo
        # Aquí se podría implementar una espera activa o un sistema de verificación recurrente
        
        is_infected = report_data['data']['attributes']['stats']['malicious'] > 0
        detections = report_data['data']['attributes']['stats']['malicious']
        detected_by = "Ejemplo" # Aquí deberías procesar qué motores detectaron el archivo
        
        # Registrar en la base de datos
        cursor.execute('''INSERT INTO analyzed_files 
                          (file_name, file_path, is_infected, detections, detected_by) 
                          VALUES (?, ?, ?, ?, ?)''', 
                       (os.path.basename(filepath), filepath, is_infected, detections, detected_by))
        conn.commit()

        if is_infected:
            shutil.move(filepath, os.path.join(carpeta_maliciosos, os.path.basename(filepath)))
            print(f"Archivo infectado movido a {carpeta_maliciosos}")
        else:
            shutil.move(filepath, os.path.join(carpeta_uploads, os.path.basename(filepath)))
            print(f"Archivo limpio movido a {carpeta_uploads}")
    else:
        print("Error en la solicitud a VirusTotal.")

if __name__ == "__main__":
    # Asumiendo que el script recibe la ruta del archivo como argumento
    import sys
    if len(sys.argv) > 1:
        analizar_archivo(sys.argv[1])
    else:
        print("Por favor, proporciona la ruta del archivo a analizar.")

conn.close()
