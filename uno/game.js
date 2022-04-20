let params = new URLSearchParams(window.location.search);
let roomid = params.get("id");

function createCard(name) {
    return $('<div class="carte" name="' + name + '"><img src="cartes/' + name + '.png" /></div>')
}

function empile(name) {
    $.ajax("update.php", {
        method : "POST",
        data : {"play-card": name}
    });
    update();
}

function pioche(e) {
    $.ajax("update.php", {
        method : "POST",
        data : {"pick-card": ""}
    });
    update();
}

function setTop(name) {
    let pile = $("#pile > .carte");
    if (pile.length == 0) {
        $("#pile").append(createCard(name));
    } else if (pile.first().attr("name") != name) {
        $("#pile > .carte").replaceWith(createCard(name));
    }
}

function setCards(playername, names) {
    let cards = $("#" + playername + " > .carte");
    if (names.length != cards.length) {
        cards.remove();
        names.forEach((name, i) => {
            let card = createCard(name);
            card.attr("onclick", "empile('" + i + "')");
            $("#" + playername).append(card);
        });
    }
}

function setOthersCards(others) {
    let othernames = [ "joueur_haut", "joueur_gauche", "joueur_droit" ];
    for (let i = 0; i < othernames.length; i++) {
        if (i < others.length) {
            setCards(othernames[i], Array(Math.min(others[i], 15)).fill("card_back"));
        } else {
            setCards(othernames[i], []);
        }
    }
}

function update() {
    $.ajax("update.php", {
        method: "GET",
        dataType: "json",
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
        traiter_message(content);
        $.ajax("update.php", {
            method : "GET",
            dataType: "json",
            data: {"message": content }
        });
        messageInput.prop("value", "");
        update_messages();
    }
}

function update_messages() {
    $.ajax("update.php", {
        method: "GET",
        dataType: "json",
        data: {"new-messages": "" }
    }).done(function(messages) {
        let message_list = $("#messages");
        messages.forEach(message => {
            message_list.append("<div class='message'><span class='message-id'>" + message[0] + "</span><span class='message-content'>" + message[1] + "</span></div>");
        });
        message_list.scrollTop(message_list[0].scrollHeight)
    });
}

function toggleChat() {
    let chat = document.getElementById("chat");
    let messages = document.getElementById("messages");
    let button = document.getElementById("chat-toggle");
    if (button.textContent == "▼") {
        messages.style.visibility = "hidden";
        messages.style.display = "none";
        chat.style.width = "20em";
        chat.style.height = "auto";
        button.style.top = "0";
        button.style.height = "100%";
        button.textContent = "▲";
    } else {
        messages.style.visibility = "visible";
        messages.style.display = "block";
        chat.style.width = "25em";
        chat.style.height = "15em";
        button.style.top = "0.1em";
        button.style.height = "auto";
        button.textContent = "▼";
    }
}

function traiter_message(content) {

    content = content.trim();

    if (content == "tacos") {
        tacos(30);
    }

    else if (content.startsWith("tacos ")) {
        let n = Number(content.substr(6));
        if (n != NaN) {
            tacos(n);
        }
    }
}


window.onload = () => {

    update();

    setInterval(update, 1000);
    setInterval(update_messages, 1000);

    toggleChat();

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

function tacos(n) {

    let body = document.getElementsByTagName("body")[0];

    for (let i = 0; i < n; i++) {

        let taco = document.createElement("img");
        taco.className = "taco";
        taco.src = "useless/taco.png";

        let height = (Math.random() * 75 + 25);
        let time = Math.random() * 1000 + 1500;

        taco.style.zIndex = "300";
        taco.style.position = "absolute";
        taco.style.top = "-" + height + "px";
        taco.style.left = (Math.random() * 110 - 5) + "%";
        taco.style.height = height + "px";
        taco.style.width = "auto";
        taco.style.opacity = "50%";
        taco.style.transition = "top " + time + "ms linear";
        body.appendChild(taco);

        setTimeout(() => {
            setTimeout(() => taco.style.top = (body.offsetHeight + height) + "px", 100);
            setTimeout(() => taco.remove(), time + 100);
        }, i * 50);
    }
}