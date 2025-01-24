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

  <!-- Bootstrap CSS and JS removed as they are included in the main layout -->

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
                        <img class="img-fluid" src="" alt="add">
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
                    <!-- chat-list -->
                    <div class="chat-lists">
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                          <!-- chat-list -->
                          <div class="chat-list">
                            <?php foreach ($data as $row): ?>
                              <a href="#" class="d-flex align-items-center chatUsers" data-username="<?= $row['name'] ?>" data-user-id="<?= $row['id'] ?>"> <!-- Assuming 'id' is the user ID -->
                                <div class="flex-shrink-0 avatar">
                                  <img class="img-fluid" src="" alt="user img">
                                  <span class="active"></span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h3><?= $row['name'] ?></h3> <!--name of the contact -->
                                  <p></p>
                                </div>
                              </a>
                            <?php endforeach; ?>
                          </div>
                          <!-- chat-list -->
                        </div>
                        <div class="tab-pane fade" id="Closed" role="tabpanel" aria-labelledby="Closed-tab">
                          <!-- chat-list -->
                          <div class="chat-list">
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0 avatar">
                                <img class="img-fluid" src="" alt="user img">
                                <span class="active"></span>
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Request 1</h3> <!--name of the requester -->
                                <p>Accept or Ignore</p> <!-- 2 buttons for accept and ignore -->
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid avatar" src="" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Suggestion 1</h3>
                                <p>Send Request or Cancel</p> <!-- 2 buttons for send request and cancel -->
                              </div>
                            </a>
                          </div>
                          <!-- chat-list -->
                        </div>
                      </div>
                    </div>
                    <!-- chat-list -->
                  </div>
                </div>
              </div>
            </div>
            <!-- chatlist -->

            <!-- chatbox -->
            <div class="chatbox">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="msg-head">
                    <div class="row">
                      <div class="col-8">
                        <div class="d-flex align-items-center">
                          <span class="chat-icon">
                            <img class="img-fluid" src="" alt="image title"></span>
                          <div class="flex-shrink-0 avatar">
                            <img class="img-fluid" src="" alt="user img">
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <h3>
                              <div id="receiver" class="receiver"></div>
                            </h3>
                            <p></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-body">
                    <div class="msg-body">
                      <ul id="messages">
                        <!-- <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:06 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:16 am</span>
                        </li>
                        <li class="reply">
                          <p>yes!</p>
                          <span class="time">10:20 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:26 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:32 am</span>
                        </li>
                        <li class="reply">
                          <p>How are you?</p>
                          <span class="time">10:35 am</span>
                        </li>
                        <li>
                          <div class="divider">
                            <h6>Today</h6>
                          </div>
                        </li>

                        <li class="reply">
                          <p>yes, tell me</p>
                          <span class="time">10:36 am</span>
                        </li>
                        <li class="reply">
                          <p>yes... on it</p>
                          <span class="time">just now</span>
                        </li> -->

                      </ul>
                    </div>
                  </div>

                  <div class="send-box">
                    <form id="form">
                      <input id="input" type="text" class="form-control" aria-label="message…" placeholder="Write message…">

                      <button><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- chatbox -->

        </div>
      </div>
    </div>
    </div>
  </section>
  <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
  <script>
    const socket = io("http://localhost:3000");
    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const messages = document.getElementById('messages');

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (input.value) {
        socket.emit('chat message', input.value);
        input.value = '';
      }

    });

    socket.on('chat message', (msg) => {
      const item = document.createElement('li');
      item.textContent = msg;
      item.innerHTML = `<li class="reply"><p>${msg}</p><span class="time"></span></li>`;
      messages.appendChild(item);
      window.scrollTo(0, document.body.scrollHeight);
    });


    socket.on('previousMessages', (messages) => {
      messages.forEach(msg => {
        const item = document.createElement('li');
        item.innerHTML = `<li class="reply"><p>${msg.message}</p><span class="time"></span></li>`;
        messages.appendChild(item);
      });
    });
  </script>
</body>

</html>