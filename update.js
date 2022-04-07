function sendMessage(content) {
    $.post("update.php", { "message": content });
}

function receiveMessages(onReceive) {
    $.ajax({
        url: "update.php?new-messages",
        type: "GET",
        dataType: "json",
        success: data => data.forEach(onReceive)
    });
}

function playCard(card) {
    $.post("update.php", { "play-card": card });
}

function pickCard() {
    $.post("update.php", { "pick-card": "" });
}