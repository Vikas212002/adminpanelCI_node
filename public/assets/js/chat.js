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


document.querySelectorAll('.chatUsers').forEach(user => {
  user.addEventListener('click', () => {
    
      const receiver = user.getAttribute("data-username");
      const userId = user.getAttribute("data-user-id");
      const sender = "<?php echo $this->session->data('name'); ?>";
      document.getElementById('receiver').innerHTML = receiver;
      messages.innerHTML = '';
      socket.emit('joinRoom', {
          sender,
          receiver
      });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const chatUsers = document.querySelectorAll('.chatUsers');
  if (chatUsers.length > 0) {
      // Automatically open the first chat
      const firstUser = chatUsers[0];
      const receiver = firstUser.getAttribute("data-username");
      const userId = firstUser.getAttribute("data-user-id");
      document.getElementById('receiver').innerHTML = receiver;
  }
});

