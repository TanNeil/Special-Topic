from flask import Flask, render_template
from flask_socketio import SocketIO, emit

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your_secret_key'
socketio = SocketIO(app)
socketio.init_app(app,cors_allowed_origins="*")
@app.route('/')
def index():
    return render_template('socketIO.html')

@socketio.on('connect')
def handle_connect():
    emit('server_message', 'Connected to the server.')

@socketio.on('client_message')
def handle_message(message):
    emit('server_message', 'Received message: ' + message)

if __name__ == '__main__':
    socketio.run(app, host='127.0.0.1', port=5000, debug=True)
