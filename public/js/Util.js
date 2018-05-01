"use strict";

var Util = {}

Util.basePath = 'http://104.236.202.204/job-tracker/';

Util.getBasePath = function(){
    return Util.basePath;
}

/* TO CHECK IF SOMETHING WAS RETURNED YOU WILL CHECK FOR AN EMPTY ARRAY. IE if(Util.getEl('#someid').length != 0)*/
Util.getEl = function(input) {
    return document.querySelectorAll(input);
}

if (window.addEventListener) {

    Util.addLis = function(ele, event, func) {
        if(ele){
            ele.addEventListener(event, func, false);
        }
    };

    Util.stProp = function(event) {
        event.stopPropagation();
    };
    Util.prDef = function(event) {
        event.preventDefault();
    };
    Util.remLis = function(ele, event, func) {
        if(ele){
            ele.removeEventListener(event, func, false);
        }
    };

}

if (window.attachEvent) {
    Util.addLis = function(ele, event, func) {
        if(ele){
            ele.attachEvent("on" + type, listener2);
        }
    };

    Util.stProp = function(event) {
        event.cancelBubble = true;
    };

    Util.prDef = function(event) {
        event.returnValue = false;
    };

    Util.remLis = function(ele, event, func) {
        if(ele){
            ele.detachEvent(event, func);
        }
    };

}

Util.sendRequest = function(url, callback, postData, file) {

    /*SET FILE TO FALSE IF IT IS NOT ALREADY SET.  IF IT IS SET THEN
    IT IS SUPPOSED TO BE TRUE.  IF IT IS SET TO TRUE THAT INDICATES THAT A FILE IS
    BEING SENT.*/
    if (file === undefined) {
        file = false;
    }

    /*CREATES THE XML OBJECT*/
    var req = Util.createXMLHttpObject();

    /*IF RETURNS FALSE CANCEL OPERATION*/
    if (!req) {
        return;
    }

    /*CHECK TO SEE IF POSTDATA WAS PASSED IF SO SET METHOD TO POST*/
    var method = (postData) ? "POST" : "GET";

    /*CALL THE OPEN METHOD, SEND THE METHOD "POST" OR "GET" AND PASS TRUE*/
    req.open(method, url, true);

    /*IF POSTDATA IS SENT AND THE FILE IS ZERO MEANING WE ARE NOT SENDING A FILE THEN SET REQUEST HEADER FOR FORMS, OTHERWISE JAVASCRIPT WILL DECIDE THE HEADER TYPE ON THE REQ.SEND METHOD*/
    if (postData && !file) {
        req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }
    /*IF EVERYTHING RETURNS OK SEND REQ VALUE TO "CALLBACK"*/
    req.onreadystatechange = function() {
        if (req.readyState !== 4) return;
        if (req.status !== 200 && req.status !== 304) {
            return;
        }
        callback(req);
    };

    /*IF WE HAVE ALREADY COMPLETED THE REQUEST, STOP THE FUNCTION SO AS NOT
    TO SEND IT AGAIN*/
    if (req.readyState === 4) {
        return;
    }

    /*IF POSTDATA WAS INCLUDED SEND IT TO SERVER SIDE PAGE. INFORMATION
    CAN BE RECEIVED BY USING $_POST['DATA'] (THIS IS VIA PHP)
  
    SENDING A FILE AND SOME TEXT*/
    if (postData && file) {
        req.send(postData);
    }
    /*SENDING TEXT ONLY*/
    else if (postData && !file) {
        req.send("data=" + postData);
    } else {
        req.send(null);
    }

};

/*DEPENDING ON THE BROWSER RETURN APPROPRIATE REQUEST.*/
Util.XMLHttpFactories = [
    function() {
        return new XMLHttpRequest();
    },
    function() {
        return new ActiveXObject("Msxml2.XMLHTTP");
    },
    function() {
        return new ActiveXObject("Msxml3.XMLHTTP");
    },
    function() {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
];

/*THIS METHOD CYCLES THROUGH ALL REQUESTS IN XMLHTTPFACTORIES UNTIL
ONE IS FOUND.*/
Util.createXMLHttpObject = function() {
    var xmlhttp = false;
    for (var i = 0; i < Util.XMLHttpFactories.length; i++) {
        try {
            xmlhttp = Util.XMLHttpFactories[i]();
        } catch (e) {
            continue;
        }
        break;
    }
    return xmlhttp;
};

/* TO USE THE MESSAGE BOX YOU NEED TO CREATE AN OBJECT OF OBJECTS THAT DEFINE THE HEADER, BODY AND BUTTONS.  ALL OBJECT PROERTIES ARE OPTIONAL AS THERE IS ACCOMPANING CSS THAT GOES WITH THE MESSAGE BOX.  ALSO YOU MUST HAVE A DIV ON THE WEBPAGE WITH THE ID OF "msgbox".  TO USE THE MSGBOX JUST CALL THE Util.msgBox() METHOD AND PASS IN THE OBJECT.  BELOW IS AN EXAMPLE 
var obj = {
    heading:{background: 'red', color: 'white', text: 'This is the header'},
    body: {text: 'This is the body text'},
    leftbtn:{background: 'green', color: 'black', display: 'none', text: 'Button Text'},
    rightbtn:{background: 'red', color: 'white', text: 'Button Text'}
}

Util.msgBox(obj);

TO CLOSE THE MESSAGE BOX CALL THE Util.closeMsgBox() METHOD

Util.closeMsgBox()

CSS THAT IS NEEDED
#msgbox{background: rgba(0, 0, 0, .5); position: absolute; width: 100%; height: 100%; font-family: sans-serif; display: none;}
#msgbox .box {width: 400px; border-radius: 5px; margin: 50px auto;}
#msgbox .box .heading {background: blue; color: white; border-radius: 5px 5px 0 0; font-size: 20px; padding: 5px;}
#msgbox .box .body {background: #FFF; position: relative; border-radius: 0 0 5px 5px; min-height: 100px; font-size: 16px; padding: 15px 8px 50px 8px;}
#msgbox .box .body .btns {margin: 10px 0 0 0; overflow: auto; position: absolute; right: 5px; bottom: 5px;}
#msgbox .box .body .btns input{float: right; padding: 6px 12px; font-size: 14px; font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-image: none; border: 1px solid transparent; border-radius: 4px; background: #286090; color: #FFF; outline: none;}
#msgbox .box .body #leftbtn{margin: 0 5px 0 0;}


*/

Util.msgBox = function(obj){
    var msgBox = '<div class="box"><div class="heading">Heading</div><div class="body">Body text';
    this.getEl('#msgbox')[0].style.display = 'block';
    this.getEl('#msgbox')[0].innerHTML = msgBox;
    this.msgBoxStyle(obj);
}


Util.msgBoxStyle = function(obj){
    this.getEl('.heading')[0].innerHTML = obj.heading.text;
    this.getEl('.body')[0].innerHTML = obj.body.text;
    this.getEl('.body')[0].innerHTML = obj.body.text + '<div class="btns"><input type="button" id="leftbtn" value="Left Button"><input type="button" id="rightbtn" value="Right Button"></div></div></div>';


    if(obj.heading.color){this.getEl('.heading')[0].style.color = obj.heading.color;}
    if(obj.heading.background){this.getEl('.heading')[0].style.background = obj.heading.background;}

    if(obj.hasOwnProperty('leftbtn')){
        if(obj.leftbtn.text){this.getEl('#leftbtn')[0].value = obj.leftbtn.text;}
        if(obj.leftbtn.background){this.getEl('#leftbtn')[0].style.background = obj.leftbtn.background;}
        if(obj.leftbtn.color){this.getEl('#leftbtn')[0].style.color = obj.leftbtn.color;}
        if(obj.leftbtn.display){this.getEl('#leftbtn')[0].style.display = obj.leftbtn.display;}
    }

    if(obj.hasOwnProperty('rightbtn')){
        if(obj.rightbtn.background){this.getEl('#rightbtn')[0].value = obj.rightbtn.text;}
        if(obj.rightbtn.background){this.getEl('#rightbtn')[0].style.background = obj.rightbtn.background;}
        if(obj.rightbtn.color){this.getEl('#rightbtn')[0].style.color = obj.rightbtn.color;}
        if(obj.rightbtn.display){this.getEl('#rightbtn')[0].style.display = obj.rightbtn.display;}
    }
}

Util.closeMsgBox = function(){
    Util.getEl('#msgbox')[0].style.display = 'none';
}


/* ALL THIS FUNCTION DOES IS LOOP THROUGH THE OBJECT AND DISPLAY THE APPROPRIATE ERROR MESSAGE TO THE APPROPRIATE LABEL*/
Util.displayError = function (obj){
    
    var i = 0, label;
    while(i < obj.length){
        if(obj[i].status == 'error'){

            label = Util.getEl('label[for="' + obj[i].for + '"]')[0];
            label.lastChild.className ="fa fa-exclamation-circle";
            label.lastChild.setAttribute("data-content", obj[i].msg);
        }
        i++;
    }
}

Util.addData = function(obj){

   var updSign = 0;
   switch(obj[0]['page']){
        case 'addAcc': add2DB(obj, 'Account Added', 'Account has been added'); break;
        case 'addCon': add2DB(obj, 'Contact Added', 'Contact has been added'); break;
        case 'addJob': add2DB(obj, 'Job Added', 'Job has been added'); break;
        case 'addJobNote': add2DB(obj, 'Job Note Added', 'Job Note has been added'); break;
        case 'updJobNote': add2DB(obj, 'Success', 'Job Note Has Been Updated'); updSign = 1; break;
        case 'updJobHour': add2DB(obj, 'Success', 'Job Hour Has Been Updated'); updSign = 1; break;
        case 'addJobHours': add2DB(obj, 'Success', 'Job Hours has been added'); break;
   }

   function add2DB(obj, msg1, msg2){

        var data = JSON.stringify(obj);
        var phpFile = Util.getBasePath() + "xhr/switch.php";
        Util.sendRequest(phpFile, function(res){

                    if(res.responseText == 'success'){
                        
                        var msgObj = {};
                        msgObj.heading = { background: 'green', text: msg1, color: 'white '};
                        msgObj.body =   {text: msg2};
                        Util.msgBox(msgObj);               
                        setTimeout(function(){Util.closeMsgBox();}, 1500);
                        //clear all the value in the fields
                        if(updSign == 0) document.forms[0].reset();
                        
                    }
                    else{
                        var msgObj = {};
                        msgObj.heading = { background: 'red', text: 'Error', color: 'white '};
                        msgObj.body =   {text: res.responseText };
                        msgObj.rightbtn = {background: 'red', color: 'white', text: 'OK', display:'block'};
                        Util.msgBox(msgObj);  
                        Util.addLis( Util.getEl('#rightbtn')[0], 'click', Util.closeMsgBox );   
                        
                    }
        }, data);

   }

}

/* THIS METHOD CLEARS ALL THE SPAN ELEMENTS FROM THE LABEL ELEMENTS */
Util.clearLabels = function(){
    var labels, i = 0;

    labels = Util.getEl('label');
    while(i < labels.length){
        if(labels[i].lastChild.nodeName.toLowerCase() == 'i'){
            labels[i].lastChild.className=""; //set <i></i> element's class to null
        }
        i++;
    }

}

/* act like a php heredoc in javascript by passing a string surrounded by comment */
Util.heredoc = function(fn){
    return fn.toString().match(/\/\*\s*([\s\S]*?)\s*\*\//m)[1];
}

Util.showToolTip = function(){

    $(function () {
          $('[data-toggle="popover"]').popover({
            trigger: 'hover',
            title: "Field Error"
          })

        })

}

Util.addLis4ListChange = function(idName, func){
    
    if(Util.getEl('#'+idName).length != 0){
        Util.addLis(Util.getEl('#'+idName)[0], 'change', func); 
    }
}

Util.removeJobList = function(idName){

    if(Util.getEl('#' + idName).length != 0 ){
        Util.getEl('#job_account_name')[0].parentNode.removeChild(Util.getEl('#' + idName)[0]);
    }
}