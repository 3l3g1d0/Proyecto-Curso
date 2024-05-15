from flask import Flask, render_template, request, redirect, url_for
import subprocess
import os
from werkzeug.utils import secure_filename
 
app = Flask(__name__)
 
# Configuración para la carga de archivos
UPLOAD_FOLDER = 'uploads'
ALLOWED_EXTENSIONS = {'txt', 'pdf', 'png', 'jpg', 'jpeg', 'gif'}  # Ajusta según tus necesidades
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
 
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS
 
@app.route('/')
def index():
    return render_template('subir.html')
 
@app.route('/upload', methods=['POST'])
def upload():
    if 'fileToUpload' not in request.files:
        return 'No file part'
    uploaded_file = request.files['fileToUpload']
    if uploaded_file.filename == '':
        return 'No selected file'
    if uploaded_file and allowed_file(uploaded_file.filename):
        filename = secure_filename(uploaded_file.filename)
        filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        uploaded_file.save(filepath)
        try:
            subprocess.run(['python', 'proyecto_definitivo.py', filepath], check=True)
        except subprocess.CalledProcessError as e:
            # Manejar aquí el error si el script falla
            print(e)
            return 'Error al procesar el archivo'
        return redirect(url_for('index'))
    return 'Archivo no permitido o error al subir'
 
if __name__ == '__main__':
    # Asegúrate de que el directorio de cargas existe
    if not os.path.exists(UPLOAD_FOLDER):
        os.makedirs(UPLOAD_FOLDER)
    app.run(debug=True)