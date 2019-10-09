//Usage

//load your JSON (you could jQuery if you prefer)
function loadJSON(callback) {

    var xobj = new XMLHttpRequest();
    xobj.overrideMimeType("application/json");
    xobj.open('GET', config.root + '/events/wheel/data', true);
    xobj.onreadystatechange = function () {
        if (xobj.readyState == 4 && xobj.status == "200") {
            callback(xobj.responseText);
        }
    };
    xobj.send(null);
}

function myResult(e) 
{
    console.log('Spin Count: ' + e.spinCount + ' - ' + 'Win: ' + e.win + ' - ' + 'Message: ' + e.msg);
    if (e.userData) {

        console.log('User defined score: ' + e.userData.score)
    }
    alert(e.msg);

}

function myError(e) {
    console.log('Spin Count: ' + e.spinCount + ' - ' + 'Message: ' + e.msg);

}

function myGameEnd(e) {

    //e is gameResultsArray
    console.log(e);
    TweenMax.delayedCall(5, function () {

        Spin2WinWheel.reset();

    })


}

function init() {
    loadJSON(function (response) {
        // Parse JSON string to an object
        var jsonData = JSON.parse(response);
        //if you want to spin it using your own button, then create a reference and pass it in as spinTrigger
        var mySpinBtn = document.querySelector('.spinBtn');
        //create a new instance of Spin2Win Wheel and pass in the vars object
        var myWheel = new Spin2WinWheel();

        //WITH your own button
        myWheel.init({
            data: jsonData,
            onResult: myResult,
            onGameEnd: myGameEnd,
            onError: myError,
            spinTrigger: mySpinBtn
        });

        //WITHOUT your own button
        //myWheel.init({data:jsonData, onResult:myResult, onGameEnd:myGameEnd, onError:myError});
    });
}



//And finally call it
init();
