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