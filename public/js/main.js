
import { CommentAction } from './comment-action.js';
let commentaires;

function main() {
    commentaires = new CommentAction();
}
main();

document.addEventListener("DOMContentLoaded", function () {
    // Définissez "commentaires" ici

    // Ensuite, ajoutez le gestionnaire d'événements onclick
    document.querySelector("#btn-envoyer-commantaires").onclick = function () {
        let message_ticket = document.getElementById("message_ticket").value;
        let  ticket_id = document.getElementById("ticket_id").value;
       commentaires.envoyerComment(ticket_id,message_ticket);
    };
});