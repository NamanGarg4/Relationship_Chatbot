<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Relationship Chatbot</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="chat-container">
    <h2>Relationship Chatbot</h2>

    <?php if (!isset($_SESSION['person'])): ?>
      <form method="POST" action="">
        <label>Who do you want to talk to?</label>
        <select name="person" required>
          <option value="">Select</option>
          <option value="girlfriend">Girlfriend</option>
          <option value="boyfriend">Boyfriend</option>
          <option value="husband">Husband</option>
          <option value="wife">Wife</option>
          <option value="son">Son</option>
          <option value="daughter">Daughter</option>
          <option value="mother">Mother</option>
          <option value="father">Father</option>
        </select>

        <label>Choose their mood:</label>
        <select name="mood" required>
          <option value="">Select</option>
          <option value="angry">Angry</option>
          <option value="sad">Sad</option>
          <option value="happy">Happy</option>
          <option value="jealous">Jealous</option>
        </select>

        <button type="submit">Start Chat</button>
      </form>

      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $_SESSION['person'] = $_POST['person'];
          $_SESSION['mood'] = $_POST['mood'];
          $_SESSION['chat_history'] = [];

          include 'responses.php';
          $intro = $intros[$_SESSION['person']][$_SESSION['mood']];
          $_SESSION['chat_history'][] = ['bot', $intro];
          header("Location: index.php");
          exit();
      }
      ?>

    <?php else: ?>
      <div class="chat-box" id="chat-box">
        <?php
        foreach ($_SESSION['chat_history'] as $msg) {
            $cls = $msg[0] == 'user' ? 'user-msg' : 'bot-msg';
            echo "<div class='$cls'>{$msg[1]}</div>";
        }
        ?>
      </div>

      <div class="input-area">
        <input type="text" id="userInput" placeholder="Type a message..." autofocus>
        <button id="sendBtn">Send</button>
      </div>

      <form method="POST" action="">
        <button name="reset" value="1" class="reset">Change Person</button>
      </form>

      <?php
      if (isset($_POST['reset'])) {
          session_destroy();
          header("Location: index.php");
          exit();
      }
      ?>
    <?php endif; ?>
</div>

<script src="script.js"></script>
</body>
</html>
