import { Ajax } from './ajax.js'; // Provide the correct path to the Ajax class file

export class CommentAction {

    constructor() {
        this.ajax = new Ajax();

    }

    envoyerComment(ticket,message,userId) {
         
         let data = {
               idTicket : ticket,
               message : message,
               userId : userId


         }
        this.ajax.post("comment/new", data, (response) => {
            let resultat = JSON.parse(response.text);
            console.log(resultat);
            if (resultat.code == 200) {
                alert(resultat.msg);
            } else {
                alert(resultat.msg);
            }
        });
    }

    tester(){
        console.log("application");
    }

}