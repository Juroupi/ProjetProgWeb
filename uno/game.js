let params = new URLSearchParams(window.location.search);
let roomid = params.get("id");

function leaveRoom() {
    $.post("leave_room.php", { "id": roomid });
}

function createCard(name) {
    return $('<div class="carte" name="' + name + '"><img src="cartes/' + name + '.png" /></div>')
}

function empile(name) {
    $.ajax({
        method : "POST",
        url : "update.php",
        data : {"play-card": name}
    });
    update();
}

function pioche(e) {
    $.ajax({
        method : "POST",
        url : "update.php",
        data : {"pick-card": ""}
    });
    update();
}

function setTop(name) {
    let pile = $("#pile > .carte");
    if ((pile.length == 0) || (pile.length > 0 && pile.first().attr("name") != name)) {
        $("#pile > .carte").remove();
        $("#pile").append(createCard(name));
    }
}

function setCards(playername, names) {
    let cards = $("#" + playername + " > .cartes > .carte");
    if (names.length != cards.length) {
        cards.remove();
        names.forEach((name, i) => {
            let card = createCard(name);
            card.attr("onclick", "empile('" + i + "')");
            $("#" + playername + " > .cartes").append(card);
        });
    }
}

function setOthersCards(others) {
    let othernames = [ "joueur_haut", "joueur_gauche", "joueur_droit" ];
    let n = Math.min(others.length, othernames.length);
    for (let i = 0; i < n; i++) {
        setCards(othernames[i], Array(others[i]).fill("card_back"));
    }
}

function update() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "update.php",
        data: {"cards": "" }
    }).done(function(e) {
        setTop(e.top);
        setCards("joueur_bas", e.cards);
        setOthersCards(e.others);
    });
}

function envoyer_message() {
    let messageInput = $("#message-input");
    let content = messageInput.prop("value");
    if (content.length > 0) {
        $.ajax({
            method : "GET",
            dataType: "json",
            url: "update.php",
            data: {"message": content }
        });
        messageInput.prop("value", "");
        update_messages();
    }
}

function update_messages() {
    $.ajax({
        method: "GET",
        dataType: "json",
        url: "update.php",
        data: {"new-messages": "" }
    }).done(function(messages) {
        messages.forEach(message => {
            $("#messages").append("<div class='message'><span class='message-id'>" + message[0] + "</span><span class='message-content'>" + message[1] + "</span></div>");
        });
    });
}

function toggleChat(){
    let chat = document.getElementById("chat");
    let messages = document.getElementById("messages");
    let button = document.getElementById("chat-toggle");
    if (button.textContent == "▼") {
        messages.style.visibility = "hidden";
        messages.style.display = "none";
        chat.style.height = "auto";
        button.textContent = "▲";
    } else {
        messages.style.visibility = "visible";
        messages.style.display = "block";
        chat.style.height = "20em";
        button.textContent = "▼";
    }
}

window.onload = () => {

    update();

    setInterval(update, 1000);
    setInterval(update_messages, 1000);

    $("#message-input").keyup(function(e){
        if(e.keyCode == 13) {
            envoyer_message();
        }
    });
};

function Couleur(type){
    if(type.startsWith("blue")){
        return 'blue';
    }
    if(type.startsWith("green")){
        return 'green';
    }
   if(type.startsWith("red")){
        return 'red';
   }
   if(type.startsWith("yellow")){
        return 'yellow';
   }
   if(type == "card_back.png"){
       return 'back';
   }
   if(type.startsWith('wild')){
       return 'wild';
   }
}

