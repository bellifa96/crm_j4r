
import { CommentAction } from './comment-action.js';
let commentaires;

function main() {
    commentaires = new CommentAction();
}
main();

document.addEventListener("DOMContentLoaded", function() {
    // Définissez "commentaires" ici
  
    // Ensuite, ajoutez le gestionnaire d'événements onclick
    document.querySelector("#tester").onclick = function() {
      // Utilisez "commentaires" ici
    };
  });