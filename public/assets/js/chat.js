const chatList = document.querySelectorAll('.chat-list a');
const chatBox = document.querySelector('.chatbox');
const chatIcon = document.querySelector('.chat-icon');

chatList.forEach(function(chat) {
    chat.addEventListener("click", function() {
        chatBox.classList.add('showbox');
    });
});

chatIcon.addEventListener('click', function (event) {
  chatBox.classList.remove('showbox');
});