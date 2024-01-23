const socket = new WebSocket('ws://localhost:2346');

socket.onopen = function(e) {
    ShowNotify("WebSocket", "Подключено", 'warning');
    socket.send("Меня зовут Джон");
};