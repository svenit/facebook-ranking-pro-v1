function loadJSON(e){var n=new XMLHttpRequest;n.overrideMimeType("application/json"),n.open("GET",config.root+"/events/wheel/data",!0),n.onreadystatechange=function(){4==n.readyState&&"200"==n.status&&e(n.responseText)},n.send(null)}function myResult(e){app.triggerWheel(e)}function myError(e){console.log("Something was wrong")}function myGameEnd(e){TweenMax.delayedCall(5,function(){wheel.reset()})}function init(){loadJSON(function(e){var n=JSON.parse(e),t=document.querySelector(".spinBtn");(new wheel).init({data:n,onResult:myResult,onGameEnd:myGameEnd,onError:myError,spinTrigger:t})})}init();