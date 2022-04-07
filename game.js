let params = new URLSearchParams(window.location.search);
let roomid = params.get("id");

function leaveRoom() {
    $.post("leave_room.php", { "id": roomid });
}

function empile(e) {
    console.log("ok");
    $("#pile > .carte").remove();
    $("#pile").append(e);
}

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

