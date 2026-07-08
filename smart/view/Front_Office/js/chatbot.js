const API_KEY = "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";
const API_URL =
  "https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill";
const element = $(".floating-chat");
const myStorage = localStorage;
if (!myStorage.getItem("chatID")) myStorage.setItem("chatID", createUUID());
setTimeout(() => element.addClass("enter"), 1000);
element.click(openElement);
function openElement() {
  const messages = element.find(".messages");
  const textInput = element.find(".text-box");
  element.find(">i").hide();
  element.addClass("expand").find(".chat").addClass("enter");
  textInput.keydown(onMetaAndEnter).prop("disabled", false).focus();
  element.off("click", openElement);
  element.find(".header button").click(closeElement);
  element.find("#sendMessage").click(sendNewMessage);
  messages.scrollTop(messages.prop("scrollHeight"));
}
function closeElement() {
  element.find(".chat").removeClass("enter").hide();
  element.find(">i").show();
  element.removeClass("expand");
  element.find(".header button").off("click", closeElement);
  element.find("#sendMessage").off("click", sendNewMessage);
  element
    .find(".text-box")
    .off("keydown", onMetaAndEnter)
    .prop("disabled", true)
    .blur();
  setTimeout(() => {
    element.find(".chat").removeClass("enter").show();
    element.click(openElement);
  }, 500);
}
function createUUID() {
  const hexDigits = "0123456789abcdef";
  return Array(36)
    .fill(0)
    .map((_, i) =>
      i === 14
        ? "4"
        : i === 19
        ? hexDigits.substr(((Math.random() * 16) & 0x3) | 0x8, 1)
        : [8, 13, 18, 23].includes(i)
        ? "-"
        : hexDigits.substr(Math.random() * 16, 1)
    )
    .join("");
}
function sendNewMessage() {
  const userInput = $(".text-box");
  const newMessage = userInput
    .html()
    .replace(/<div>|<br.*?>/g, "\n")
    .replace(/<\/div>/g, "")
    .trim()
    .replace(/\n/g, "<br>");
  if (!newMessage) return;
  $(".messages").append(`
    <li class="self">
      <img src="https://github.com/Thatkookooguy.png" alt="User Avatar">
      <span>${newMessage}</span>
    </li>
  `);
  userInput.html("").focus();
  $(".messages").animate(
    { scrollTop: $(".messages").prop("scrollHeight") },
    250
  );
  fetchChatbotResponse(newMessage);
}
async function fetchChatbotResponse(userMessage) {
  $(".messages")
    .append(
      `
    <li class="other thinking">
      <img src="https://i.pinimg.com/736x/f5/96/9d/f5969dc8d64385ae8fb66b4aafbf2ad5.jpg" alt="Chatbot Avatar">
      <span>Thinking...</span>
    </li>
  `
    )
    .animate({ scrollTop: $(".messages").prop("scrollHeight") }, 250);
  const response = await fetch(API_URL, {
    method: "POST",
    headers: {
      Authorization: `Bearer ${API_KEY}`,
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ inputs: userMessage }),
  });
  const data = await response.json();
  $(".thinking").remove();
  $(".messages")
    .append(
      `
    <li class="other">
      <img src="https://i.pinimg.com/736x/f5/96/9d/f5969dc8d64385ae8fb66b4aafbf2ad5.jpg" alt="Chatbot Avatar">
      <span>${
        data[0]?.generated_text ||
        "I'm here to help. Could you clarify your question?"
      }</span>
    </li>
  `
    )
    .animate({ scrollTop: $(".messages").prop("scrollHeight") }, 250);
}
function onMetaAndEnter(event) {
  if ((event.metaKey || event.ctrlKey) && event.keyCode === 13)
    sendNewMessage();
}