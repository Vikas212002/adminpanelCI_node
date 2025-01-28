<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
</head>

<body>
  <!-- Google Fonts -->
  <link href="<?= base_url('assets/css/google-fonts.css') ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  <!-- char-area -->
  <section class="message-area">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="chat-area">
            <!-- chatlist -->
            <div class="chatlist">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="chat-header">
                    <div class="msg-search">
                      <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="search" aria-label="search">
                      <a class="add" href="#">
                        <img class="img-fluid" src="<?= base_url('/assets/add.png') ?>" alt="add">
                      </a>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab" aria-controls="Open" aria-selected="true">Contacts</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab" aria-controls="Closed" aria-selected="false">Request & Suggestions</button>
                      </li>
                    </ul>
                  </div>

                  <div class="modal-body">
                    <div class="chat-lists">
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                          <div class="chat-list mt-2">
                            <?php foreach ($data as $row): ?>
                              <?php if ($row['name'] == session()->get('name')) {
                                continue;
                              } ?>
                              <a href="#" class="d-flex align-items-center chatUsers" data-username="<?= $row['name'] ?>" data-user-id="<?= $row['id'] ?>">
                                <div class="avatar d-flex justify-content-center align-items-center position-relative" id="chat-icon" style="background-color: #f0f0f0;">
                                  <span style="font-size: 1.5rem ; font-weight: bold; ">
                                    <?php
                                    $initial = substr($row['name'], 0, 1);
                                    $initial = strtoupper($initial);
                                    echo $initial;
                                    ?>
                                    <span id="active-status" class=""></span>
                                  </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h3><?= $row['name'] ?></h3>
                                  <p></p>
                                </div>
                              </a>
                            <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="Closed" role="tabpanel" aria-labelledby="Closed-tab">
                          <div class="chat-list">
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0 avatar">
                                <img class="img-fluid" src="" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Request 1</h3>
                                <p>Accept or Ignore</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid avatar" src="" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Suggestion 1</h3>
                                <p>Send Request or Cancel</p>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- chatbox -->
            <div class="chatbox">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="msg-head">
                    <div class="row">
                      <div class="col-8">

                        <div class="d-flex align-items-center" id="chatbox-header">
                          <div class="avatar d-flex justify-content-center align-items-center position-relative">
                            <span class="chat-icon">
                            </span>
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <h3>
                              <div id="receiver" class="receiver"></div>
                            </h3>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="modal-body">
                    <div class="msg-body">
                      <ul id="messages"></ul>
                    </div>
                  </div>

                  <div class="send-box">
                    <form id="form">
                      <input id="input" type="text" class="form-control" aria-label="message…" placeholder="Write message…">
                      <!-- <input type="file"> -->
                      <button type="submit"><i class="fa fa-paper-plane send-message-button" aria-hidden="true"></i> Send</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>

  <script>
    const sender = "<?php echo session()->get('name'); ?>";
    const socket = io("http://localhost:3000", {
      query: {
        userId: sender
      }
    });
    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const messages = document.getElementById('messages');

    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (input.value) {
          const receiver = document.getElementById('receiver').innerText;
          const roomId = [sender, receiver].sort().join('_');
          socket.emit('chat message', {
            msg: input.value,
            roomId,
            sender,
            receiver
          });
          input.value = '';
        }
      });
    }

    socket.on('chat message', ({
      msg,
      sender: msgSender
    }) => {
      const item = document.createElement('li');
      item.classList.add(msgSender === sender ? 'reply' : 'sender');
      item.innerHTML = `<p>${msg}</p><span class="time">${new Date().toLocaleTimeString()}</span>`;
      messages.appendChild(item);
      messages.scrollTop = messages.scrollHeight;
    });

    socket.on('previousMessages', (msgs) => {
      messages.innerHTML = ''; // Clear previous messages
      msgs.forEach(msg => {
        const item = document.createElement('li');
        item.classList.add(msg.sender === sender ? 'reply' : 'sender');
        item.innerHTML = `<p>${msg.message}</p><span class="time">${new Date(msg.timestamp).toLocaleTimeString()}</span>`;
        messages.appendChild(item);
      });
      messages.scrollTop = messages.scrollHeight;
    });

    document.querySelectorAll('.chatUsers').forEach(user => {
      user.addEventListener('click', () => {
        const receiver = user.getAttribute("data-username");
        const receiverId = user.getAttribute("data-user-id");

        // Update receiver name
        document.getElementById('receiver').innerText = receiver;

        // Update the chat header profile picture
        const chatHeaderAvatar = document.querySelector('#chatbox-header .avatar');
        const userInitial = receiver.charAt(0).toUpperCase();
        chatHeaderAvatar.innerHTML = `
      <span style="font-size: 1.5rem; font-weight: bold; color: #0D6EFD">
        ${userInitial}
        <span id="active-status" class=""></span>
      </span>
    `;
        chatHeaderAvatar.style.backgroundColor = '#f0f0f0';

        messages.innerHTML = ''; // Clear previous messages

        const roomId = [sender, receiver].sort().join('_');
        socket.emit('joinRoom', {
          sender,
          receiver,
          roomId
        });
      });
    });



    // Handle active status
    socket.on('active-status', ({
      connectedUsers
    }) => {
      Object.keys(connectedUsers).forEach(userId => {
        const userElement = document.querySelector(`[data-username="${userId}"] #active-status`);
        if (userElement) {
          userElement.classList.add('active');
          userElement.classList.remove('inactive');
        }
      });
    });

    socket.on('disconnection', ({
      connectedUsers
    }) => {
      const allUserElements = document.querySelectorAll(`.chatUsers .active-status`);
      allUserElements.forEach(element => {
        element.classList.remove('active');
        element.classList.add('inactive');
      });

      Object.keys(connectedUsers).forEach(userId => {
        const userElement = document.querySelector(`[data-username="${userId}"] #active-status`);
        if (userElement) {
          userElement.classList.add('active');
          userElement.classList.remove('inactive');
        }
      });
    });

    socket.on('disconnect', () => {
      const userElement = document.querySelector(`[data-username="${sender}"] #active-status`);
      if (userElement) {
        userElement.classList.remove('active');
        userElement.classList.add('inactive');
      }
    });

    socket.emit('user_connected', {
      sender
    });
  </script>


  <script src="<?= base_url('assets/js/socket.js'); ?>"></script>
</body>

</html>