from flask import Flask, render_template
 
app = Flask(__name__)
 
@app.route('/')
def index():
    return render_template('index.html')
 
@app.route('/analizar')
def analizar_contenido():
    # Agrega el código para llamar a tu script de Python para el análisis
    # Puedes llamar a la función o la lógica de análisis aquí
    return 'Análisis de contenido'
 
if __name__ == '__main__':
    app.run(debug=True)