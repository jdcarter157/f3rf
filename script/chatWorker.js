const xhttp = new XMLHttpRequest();
let currentChat = [];

onmessage = function(e){
    //If worker recieves blank message, 
    //it is a request to update the messages from the db
    if (e.data == ""){
        xhttp.open('GET', "/f3r/livechat/getMessage", true);
        // Delete all but the most recent timeout
        var highestTimeoutId = setTimeout(";");
        for (var i = 0 ; i < highestTimeoutId ; i++) {
            clearTimeout(i); 
        }
        /**
         * After opening and sending request...
         * timeout a blank post to keep a 1 second
         * loop running to constanstly check for messages
         */
        this.setTimeout(function(){
            this.postMessage("");
        }, 1000);
        xhttp.send();
    }//Otherwise assume that the user is posting a message and send request
    else {
        let userID = e.data[0];
        let msgContent = e.data[1];
        xhttp.open('GET', "/f3r/livechat/sendMessage?id="+userID+"&msg="+msgContent, true);
        xhttp.send();
    }
}


xhttp.onload = function(a){
    //When the controller echos back the db request, parse it into a json object
    let ajaxResponseJSON = JSON.parse(a.target.response);
    let ajaxResponseArray = [];
    
    //Convert json into an array
    for(var i in ajaxResponseJSON){
        ajaxResponseArray.push([i, ajaxResponseJSON[i]]);
    }

    //If the request returned a blank array, post back a blank message, otherwise post ajaxResponseArray
    if (ajaxResponseArray == []){
        postMessage("");
        
    } else {
        postMessage(ajaxResponseArray);
    }
}



