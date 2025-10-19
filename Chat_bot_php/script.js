document.addEventListener("DOMContentLoaded", function() {
  const sendBtn = document.getElementById("sendBtn");
  const userInput = document.getElementById("userInput");
  const chatBox = document.getElementById("chat-box");

  function sendMessage() {
    const msg = userInput.value.trim();
    if (!msg) return;

    const userDiv = document.createElement("div");
    userDiv.className = "user-msg";
    userDiv.textContent = msg;
    chatBox.appendChild(userDiv);

    fetch("chat.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "message=" + encodeURIComponent(msg)
    })
    .then(res => res.json())
    .then(data => {
      const botDiv = document.createElement("div");
      botDiv.className = "bot-msg";
      botDiv.textContent = data.reply;
      chatBox.appendChild(botDiv);
      chatBox.scrollTop = chatBox.scrollHeight;
    });

    userInput.value = "";
  }

  sendBtn.addEventListener("click", sendMessage);
  userInput.addEventListener("keypress", e => {
    if (e.key === "Enter") sendMessage();
  });
});
