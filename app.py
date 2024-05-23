import os
import requests
import glob
import shutil

# Configura tu clave API de VirusTotal aquí
API_KEY = '5458fba33a434aba677815a33d446ed356dddd785cbef9ba0a5029fa8ad907b4'

# Ruta de la carpeta que deseas escanear
CARPETA = '/home/dns/archivos-py'  # Usar \\ o / para evitar problemas de escape en la cadena de ruta

def obtener_ultimo_archivo(carpeta):
    archivos = glob.glob(os.path.join(carpeta, '*'))
    if not archivos:
        return None
    ultimo_archivo = max(archivos, key=os.path.getctime)
    return ultimo_archivo

def enviar_archivo_virus_total(api_key, archivo):
    url = 'https://www.virustotal.com/api/v3/files'
    headers = {
        'x-apikey': api_key
    }
    with open(archivo, 'rb') as f:
        files = {'file': (os.path.basename(archivo), f)}
        response = requests.post(url, headers=headers, files=files)
    return response.json()

def obtener_enlace_analisis(respuesta):
    return respuesta['data']['links']['self']

def obtener_resultado_analisis(enlace_analisis):
    headers = {"x-apikey": API_KEY, "accept": "application/json"}
    response = requests.get(enlace_analisis, headers=headers)
    return response.json()

def determinar_estado_analisis(resultado_analisis):
    if 'data' in resultado_analisis:
        data = resultado_analisis['data']['attributes']['stats']
        undetected = data.get('undetected', 0)
        malicious = data.get('malicious', 0)
        #print(undetected)
        if malicious > 5:
            shutil.move(ruta_archivo, "/home/dns/cuarentena")
        elif undetected > 59:
            shutil.move(ruta_archivo, "/home/dns/archivos")
        else:
            shutil.move(ruta_archivo, "/home/dns/cuarentena")
    else:
        print("No se pudo obtener el resultado del análisis correctamente.")

def main():
    ultimo_archivo = obtener_ultimo_archivo(CARPETA)
    if not ultimo_archivo:
        print("No se encontraron archivos en la carpeta especificada.")
        return
    
    print(f"Enviando el archivo: {ultimo_archivo} a VirusTotal...")
    respuesta = enviar_archivo_virus_total(API_KEY, ultimo_archivo)
    
    if 'data' in respuesta:
        enlace_analisis = obtener_enlace_analisis(respuesta)
        print("Obteniendo resultado del análisis...")
        resultado_analisis = obtener_resultado_analisis(enlace_analisis)
        determinar_estado_analisis(resultado_analisis)
    else:
        print("Hubo un problema al obtener el enlace de análisis.")

if __name__ == '__main__':
    main()
