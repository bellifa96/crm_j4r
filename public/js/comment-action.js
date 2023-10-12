import { Ajax } from './ajax.js'; // Provide the correct path to the Ajax class file

export class CommentAction {

    constructor() {
        this.ajax = new Ajax();

    }

    envoyerComment(ticket,message) {
         
         let data = {
               ticketId : ticket,
               message : message,
               userId:2
         }
        this.ajax.post("/comment/new/comment", data, (response) => {
            let resultat = JSON.parse(response.text);
            console.log(resultat);
            if (resultat.code == 200) {
                alert(resultat.msg);
            } else {
                alert(resultat.msg);
            }
        });
    }

    tester(message_ticket){
        console.log("application" + message_ticket);
    }

}