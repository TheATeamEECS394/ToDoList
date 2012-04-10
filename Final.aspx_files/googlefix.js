if(window.attachEvent)
    window.attachEvent("onload",setListeners);

function setListeners(){
    inputList = document.getElementsByTagName("INPUT");
    for(i=0;i<inputList.length;i++){
        if (inputList[i].style.backgroundColor == "orange")
            inputList[i].attachEvent("onpropertychange",restoreStyles);
    }
    selectList = document.getElementsByTagName("SELECT");
    for(i=0;i<selectList.length;i++){
        if (selectList[i].style.backgroundColor == "orange")
            selectList[i].attachEvent("onpropertychange",restoreStyles);
    }
}

function restoreStyles(){
    if(event.srcElement.style.backgroundColor != "orange")
        event.srcElement.style.backgroundColor = "orange";
}
