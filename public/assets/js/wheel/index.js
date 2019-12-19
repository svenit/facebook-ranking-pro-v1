function loadJSON(callback) 
{
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
    app.triggerWheel(e);
}
function myError(e) 
{
    console.log('Something was wrong');
}
function myGameEnd(e) 
{
    TweenMax.delayedCall(5, function () {
        wheel.reset();
    })
}
function init() 
{
    loadJSON(function (response) {
        var jsonData = JSON.parse(response);
        var mySpinBtn = document.querySelector('.spinBtn');
        var myWheel = new wheel();
        myWheel.init({
            data: jsonData,
            onResult: myResult,
            onGameEnd: myGameEnd,
            onError: myError,
            spinTrigger: mySpinBtn
        });
    });
}
init();
