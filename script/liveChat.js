
let chatWorker = new Worker('script/chatWorker.js');
let chatHTMLDiv = document.getElementById("liveChatMessageBox");
let currentChat = [];
let newChatMessages = [];


chatWorker.onmessage = function(e){
    /**
     * If worker doesnt send an empty message run logic to find the difference between the chat on the screen
     * and the chat on the database and create elements for those differences
     **/
     
    if (e.data != ""){
        
        let updatedChat = e.data;
        
        //Find the difference of both arrays, if the arrays are the same length there must not be new messages
        if (currentChat.length != updatedChat.length){
            for(let i = 0; i <currentChat.length; i++){
                updatedChat.shift();
            }
            newChatMessages = updatedChat;
        } else {
            newChatMessages = [];
        }

        //For each entry in newChatMessages, create elements and append them onto the chatHTMLDiv
        newChatMessages.forEach(entry =>{
            
            //Create elements that will be needed for the message
            let p = document.createElement('p');
            let s = document.createElement('small');
            let d = document.createElement('div');

            //Insert message content and metadata into respective html elements
            p.innerText = entry[1]["content"];
            s.innerHTML = `${entry[1]["first_name"]} ${entry[1]['last_name']}<span class="chatTime"> ${entry[1]["created"]}</span>`;

            //Append the paragraph and small onto the div and then append div onto the page element
            d.appendChild(p);
            d.appendChild(s);
            d.setAttribute("class","live-chat-div");
            chatHTMLDiv.appendChild(d);
            

            //Push the entry into currentChat one the element is displayed on screen
            currentChat.push(entry);
        });
        
    } else {
        //Else runs if user posts message, this is to be able to update the screen with the user's post
        chatWorker.postMessage("");
    }
}


//Chat object is instanciated in livechat.htm to be able to start the loop of updating the screen with messages
class Chat {

    constructor(id){
        this.id = id;
        //Posting a blank message to the worker runs its logic to get messages from db
        chatWorker.postMessage("");
        
    }

    sendMessages(messageValue){
        chatWorker.postMessage([this.id, messageValue]);
    }  

}


