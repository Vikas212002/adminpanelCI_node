const chatList = document.querySelectorAll('.chat-list a');
const chatBox = document.querySelector('.chatbox');
const chatIcon = document.querySelector('.chat-icon');

if (chatList) {
    chatList.forEach(chat => {
        chat.addEventListener("click", () => {
            chatBox.classList.add('showbox');
        });
    });
}

if (chatIcon) {
    chatIcon.addEventListener('click', (event) => {
        chatBox.classList.remove('showbox');
    });
}

document.querySelectorAll('.chatUsers').forEach(user => {
    user.addEventListener('click', () => {
        const receiver = user.getAttribute("data-username");
        const userId = user.getAttribute("data-user-id");

        document.getElementById('receiver').innerText = receiver;
        messages.innerHTML = '';
        const roomId = [sender, receiver].sort().join('_');
        socket.emit('joinRoom', { sender, receiver, roomId });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const chatUsers = document.querySelectorAll('.chatUsers');
    if (chatUsers.length > 0) {
        const firstUser = chatUsers[0];
        const receiver = firstUser.getAttribute("data-username");
        document.getElementById('receiver').innerText = receiver;
        const roomId = [sender, receiver].sort().join('_');
        socket.emit('joinRoom', { sender, receiver, roomId });
    }
});

// Socket.IO logic


