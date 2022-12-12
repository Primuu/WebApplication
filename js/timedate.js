//--------------------------------------//
// Wyswietlanie biezacej godziny i daty //
//-------------------------------------//

function gettheDate()
{
    Todays = new Date();
    TheDate = ""
    TheDate += (Todays.getDate() < 10) ? "0" + Todays.getDate() : Todays.getDate();
    TheDate += " / "
    TheDate += (Todays.getMonth() < 10) ? "0" + Todays.getMonth() + 1 : Todays.getMonth() + 1;
    TheDate += " / "
    TheDate += (Todays.getYear() - 100);
    document.getElementById("data").innerHTML = TheDate;
}

var timerID = null;
var timerRunning = false;

function stopClock()
{
    if(timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}

function startclock()
{
    stopClock();
    gettheDate();
    showtime();
}

function showtime ()
{
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var timeValue = hours
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds
    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
}