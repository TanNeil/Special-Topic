var videoStream = document.getElementById('video-stream');
var startButton = document.getElementById('start-button');
var stopButton = document.getElementById('stop-button');
var socket = io.connect('http://localhost:5000/video_stream');

function startCamera() {
    socket.emit('start_stream');
    startButton.disabled = true;
    stopButton.disabled = false;
}

function stopCamera() {
    socket.disconnect();
    videoStream.src = "";
    startButton.disabled = false;
    stopButton.disabled = true;
}

socket.on('connect', function() {
    console.log('已连接到视频流命名空间。');
});

socket.on('video_frame', function(frame) {
    videoStream.src = 'data:image/jpeg;base64,' + frame;
});
