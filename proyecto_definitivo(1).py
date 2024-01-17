import os
import sqlite3
import requests
import shutil

api_key = "5458fba33a434aba677815a33d446ed356dddd785cbef9ba0a5029fa8ad907b4"
carpeta_infectados = "archivos_infectados/"
carpeta_limpios = "archivos_limpios/"
database_file = "virus_total.db"

directory = r'C:\Users\Ivanc\Downloads\virus'
output_folder = r'C:\Users\Ivanc\OneDrive\Documentos\archivos_infectados'

if not os.path.exists(carpeta_infectados):
    os.mkdir(carpeta_infectados)
if not os.path.exists(carpeta_limpios):
    os.mkdir(carpeta_limpios)

conn = sqlite3.connect(database_file)
cursor = conn.cursor()

cursor.execute('''
    CREATE TABLE IF NOT EXISTS analyzed_files (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        file_path TEXT,
        is_infected BOOLEAN,
        scan_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
''')

def analizar_archivo(filepath):
    url = 'https://www.virustotal.com/api/v3/files'
    params = {'x-apikey': api_key}
    files = {'file': (os.path.basename(filepath), open(filepath, 'rb'))}
    response = requests.post(url, files=files, params=params)
    data = response.json()
    is_infected = data.get('data', {}).get('attributes', {}).get('last_analysis_stats', {}).get('malicious', 0) > 0
    cursor.execute('INSERT INTO analyzed_files (file_path, is_infected) VALUES (?, ?)', (filepath, is_infected))
    conn.commit()

    if is_infected:
        print("Archivo infectado")
        shutil.move(filepath, os.path.join(carpeta_infectados, os.path.basename(filepath)))
    else:
        print("El archivo está limpio")
     

def analizar_url(url):
    url = 'https://www.virustotal.com/api/v3/urls/analyze'
    params = {'x-apikey': api_key}
    data = {'url': url}
    response = requests.post(url, json=data, params=params)
    
def main():
    while True:
        print("Paso 1. Analizar archivo")
        print("Paso 2. Analizar URL")
        print("Paso 3. Salir")
        opcion = input("Selecciona una opción: ")

        if opcion == "1":
            filepath = input("Ruta del archivo: ")
            if os.path.isfile(filepath):
                analizar_archivo(filepath)
            else:
                print('Ruta de archivo no válida')
        elif opcion == "2":
            url = input("URL a analizar: ")
            response_data = analizar_url(url)
            print("Se ha enviado la URL para analizar en VirusTotal.")
        elif opcion == "3":
            break
        else:
            print("Opción no válida")

if __name__ == "__main__":
    main()

conn.close()