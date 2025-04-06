<?php
ob_start();
session_start();

$carno = array("1","2","3","4");
shuffle($carno);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Typing racing game</title>
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

<link rel="prefetch" href="images/car1.png" />
<link rel="prefetch" href="images/car2.png" />
<link rel="prefetch" href="images/car3.png" />
<link rel="prefetch" href="images/car4.png" />
<link rel="prefetch" href="images/road-bg.jpg" />
<style>
body{margin:0;padding:0;background:#FFF;font-family:Arial, Helvetica, sans-serif}
.content{width:1250px;max-width:100%;margin:0 auto}
a{text-decoration:none;color:#333}
.bgwhite{background:#FFF;padding:20px 2%}
h1,h2,h3,h4{font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight:100}
h1{color:#333;font-size:36px;margin:20px 0;font-weight:100}
h2{color:#333;font-size:27px;margin:40px 0 10px;font-weight:100}
.clear{clear:both}
figure{background:#FFF;text-align:center;margin:0}
figure img{width:100%}
.button{padding:10px 30px;border:1px solid #F30;margin:10px 1.5%;text-align:center;float:left}
.button:hover{border:1px solid #de4b4f;color:#FFF;background-color:#b62327}
#timer, #restart{margin:0.2em;line-height:2.2em;height:2.2em}
::placeholder{color:#b42327;opacity:1;letter-spacing:3px}
:-ms-input-placeholder{color:#b42327;letter-spacing:3px}
::-ms-input-placeholder{color:#b42327;letter-spacing:3px}
#word-section{background-color:#fff;font-size:27px;height:4em;line-height:54px;position:relative;padding:0.5em;overflow:hidden;width:80%;margin:0 auto 12px}
#word-section > span{display:inline-block;margin-left:0.2em}
#type-section{text-align:center}
#type-section > * {font-size:1.5em;display:inline-block;color:#fff;vertical-align:middle}
#typebox{width:64%;color:#000;padding:0.5em;border:none;border-bottom:5px solid #b42327;background:#f9f9ec}
#typebox:focus{outline:none}
#timer{width:4em;background-color:#ffd302;margin-right:0;color:#000}
#restart{padding:0 10px;background-color:#ce2127;cursor:pointer}
#restart > span{display:inline-block}
#restart:hover{background-color:#ee2f25}
#restart:active{box-shadow: 1px 1px 4px #467F21 inset}
#results{text-align:center;margin:0 1%;display:block}
#results li{list-style:none}
#results li:first-child{font-size:1.5em}
#results li:nth-child(2){font-size:0.8em;line-height:1em}
#results #results-stats{font-size:0.6em}
.waiting{text-align:center;line-height:1.5em;font-size:3em}
.current-word{background-color:#ffd312}
.correct-word-c{color:#4d9c29}
.incorrect-word-c{color:#e50000}
.incorrect-word-bg{background-color:#e50000}  
#done{background-color:#ce2127;text-align:center;padding:10px 20px;margin:10px;cursor:pointer;color:#FFF;border-radius:10px}
.vr{width:100%;text-align:center;margin-top:20px}
#link{width:600px;margin:10px auto 25px;padding:10px}
#link input{border:none;width:75%;outline:none}
#link button{width:100%;background:#dc4d41;color:#FFF;border:none;padding:9px 1%;cursor:pointer}
#link h3{font-size:27px;font-weight:100;text-align:center;margin:0 0 20px}
.next{margin-top:10px;background:#467f21;color:#FFF;padding:9px 1%;cursor:pointer;display:block;text-align:center;font-size:14px}
#container{width:100%;height:215px;position:relative;background:url(images/road-bg.jpg);background-repeat-y:no-repeat;background-position:right 0px;background-size:cover;margin-bottom:30px}
#animate{width:70px;height:33px;background:url(images/car<?php echo $carno[0]; ?>.png);background-repeat:no-repeat;background-position:center;position:absolute;top:28px;left:0}
#animate2{width:70px;height:33px;background:url(images/car<?php echo $carno[1]; ?>.png);background-repeat:no-repeat;background-position:center;position:absolute;top:69px;left:0}
#animate3{width:70px;height:33px;background:url(images/car<?php echo $carno[2]; ?>.png);background-repeat:no-repeat;background-position:center;position:absolute;top:114px;left:0}
#animate4{width:70px;height:33px;background:url(images/car<?php echo $carno[3]; ?>.png);background-repeat:no-repeat;background-position:center;position:absolute;top:156px;left:0}
.gusten{position:absolute;left:70px;background:#fff;border-radius:6px 6px 6px 0;padding:2px 7px;top:-16px}
ol li{line-height:36px}
.topbox{margin:10px 0 20px;padding:10px;border-bottom:1px solid #e4e5cb;display:block;text-align:center}



</style>
</head>
<body>
<main class="whitebg">
<section class="content bgwhite">
<label class="topbox" for="typebox">Start the race by typing the highlighted word in the red box.</label>
<div id ="container">
  <div id ="animate"><div class="gusten">You</div></div>
  <div id ="animate2"><div class="gusten">Contestant_2</div></div>
  <div id ="animate3"><div class="gusten">Contestant_3</div></div>
  <div id ="animate4"><div class="gusten">Contestant_4</div></div>
</div>
<div id="word-section">
<div class="waiting">Loading...</div>
</div>
<div id="type-section">
<input id="typebox" name="typebox" type="text" tabindex="0" autofocus onkeyup="allStop(event)" placeholder="Type Here" />
<div id="timer" class="type-btn"><span>0:00</span></div>
</div>
<div class="vr" id="result"></div>

<div id="link">
</div>
</section>
</main>

<script> "use strict";
if (window.$ = document.querySelectorAll.bind(document), navigator.userAgent.match(/firefox/i)) {

    var ffwait = "line-height: 1em; font-size: 4em;";
    $(".waiting")[0].setAttribute("style", ffwait)
}

var wordList = ["the", "name", "of", "very", "to", "through", "and", "just", "a","form", "in", "much", "is", "great", "it", "think", "you", "say","that", "help", "he", "low", "was", "line", "for", "before", "on","turn", "are", "cause", "with", "same", "as", "mean", "I", "differ","his", "move", "they", "right", "be", "boy", "at", "old", "one","too", "have", "does", "this", "tell", "from", "sentence", "or","set", "had", "three", "by", "want", "hot", "air", "but", "well","some", "also", "what", "play", "there", "small", "we", "end", "can","put", "out", "home", "other", "read", "were", "hand", "all", "port","your", "large", "when", "spell", "up", "add", "use", "even", "word","land", "how", "here", "said", "must", "an", "big", "each", "high","she", "such", "which", "follow", "do", "act", "their", "why", "time","ask", "if", "men", "will", "change", "way", "went", "about", "light","many", "kind", "then", "off", "them", "need", "would", "house","write", "picture", "like", "try", "so", "us", "these", "again","her", "animal", "long", "point", "make", "mother", "thing", "world","see", "near", "him", "build", "two", "self", "has", "earth", "look","father", "more", "head", "day", "stand", "could", "own", "go","page", "come", "should", "did", "country", "my", "found", "sound","answer", "no", "school", "most", "grow", "number", "study", "who","still", "over", "learn", "know", "plant", "water", "cover", "than","food", "call", "sun", "first", "four", "people", "thought", "may","let", "down", "keep", "side", "eye", "been", "never", "now", "last","find", "door", "any", "between", "new", "city", "work", "tree","part", "cross", "take", "since", "get", "hard", "place", "start","made", "might", "live", "story", "where", "saw", "after", "far","back", "sea", "little", "draw", "only", "left", "round", "late","man", "run", "year", "don't", "came", "while", "show", "press","every", "close", "good", "night", "me", "real", "give", "life","our", "few", "under", "stop", "open", "ten", "seem", "simple","together", "several", "next", "vowel", "white", "toward", "children","war", "begin", "lay", "got", "against", "walk", "pattern", "example","slow", "ease", "center", "paper", "love", "often", "person","always", "money", "music", "serve", "those", "appear", "both","road", "mark", "map", "book", "science", "letter", "rule", "until","govern", "mile", "pull", "river", "cold", "car", "notice", "feet","voice", "care", "fall", "second", "power", "group", "town", "carry","fine", "took", "certain", "rain", "fly", "eat", "unit", "room","lead", "friend", "cry", "began", "dark", "idea", "machine", "fish","note", "mountain", "wait", "north", "plan", "once", "figure", "base","star", "hear", "box", "horse", "noun", "cut", "field", "sure","rest", "watch", "correct", "color", "able", "face", "pound", "wood","done", "main", "beauty", "enough", "drive", "plain", "stood", "girl","contain", "usual", "front", "young", "teach", "ready", "week","above", "final", "ever", "gave", "red", "green", "list", "oh","though", "quick", "feel", "develop", "talk", "sleep", "bird", "warm","soon", "free", "body", "minute", "dog", "strong", "family","special", "direct", "mind", "pose", "behind", "leave", "clear","song", "tail", "measure", "produce", "state", "fact", "product","street", "black", "inch", "short", "lot", "numeral", "nothing","class", "course", "wind", "stay", "question", "wheel", "happen","full", "complete", "force", "ship", "blue", "area", "object", "half","decide", "rock", "surface", "order", "deep", "fire", "moon", "south","island", "problem", "foot", "piece", "yet", "told", "busy", "knew","test", "pass", "record", "farm", "boat", "top", "common", "whole","gold", "king", "possible", "size", "plane", "heard", "age", "best","dry", "hour", "wonder", "better", "laugh", "true", "thousand","during", "ago", "hundred", "ran", "am", "check", "remember", "game","step", "shape", "early", "yes", "hold", "hot", "west", "miss","ground", "brought", "interest", "heat", "reach", "snow", "fast","bed", "five", "bring", "sing", "sit", "listen", "perhaps", "six","fill", "table", "east", "travel", "weight", "less", "language","morning", "among"];
var stopWord=30; // stop game after 10 words

document.getElementById("container").style.width = "100%";


function shuffle(e) {
    for (var t = e.length, r = void 0, o = void 0; t;) o = Math.floor(Math.random() * t--), r = e[t], e[t] = e[o], e[o] = r;
    return e
}

function addWords() {
    var e = $("#word-section")[0];
    e.innerHTML = "";
    for (var t = 300; t > 0; t--) {
        var r = "<span>" + shuffle(wordList)[t] + "</span>";
        e.innerHTML += r
    }
    e.firstChild.classList.add("current-word")
}

 
//get time
function TimeNow(e) {
    var t, r = e,
        o = $("#timer > span")[0].innerHTML;
    if ("0:00" == o) t = setInterval(function() {
        if (wordData.correct >= stopWord)
		{
			clearInterval(t), document.getElementById("result").innerHTML = "<span onclick='allStop(event)' id='done'>View Result</span>";
		}
        else {
            var e = (r += 1) < 10 ? "0" + r : r;
			let extraSeconds = e % 60;
			var timePad = extraSeconds < 10 ? "0" + extraSeconds : extraSeconds; // zero padded
			$("#timer > span")[0].innerHTML = Math.floor(r/60)+":" + timePad;
			wordData.seconds=e;


        }
    }, 1e3);
    if (wordData.correct == stopWord) return !1;
    return !0;
}

var colorCurrentWord = " #dddddd",
    colorCorrectWord = "#93C572",
    colorIncorrectWord = "#e50000",
    wordData = {
        seconds: 1,
        correct: 0,
        incorrect: 0,
        total: 0,
        typed: 0
    };

function checkWord(e) {
    var t = e.value.length,
        r = $(".current-word")[0],
        o = r.innerHTML.substring(0, t);

    return e.value.trim() != o ? (r.classList.add("incorrect-word-bg"), !1) : (r.classList.remove("incorrect-word-bg"), !0)
//	ignore space as a charrecter
}
var carRank=1;
var elem = document.getElementById("animate");
function submitWord(e) {
    var t = $(".current-word")[0];
    checkWord(e) ? (t.classList.remove("current-word"), t.classList.add("correct-word-c"), wordData.correct += 1) : (t.classList.remove("current-word", "incorrect-word-bg"), t.classList.add("incorrect-word-c"), wordData.incorrect += 1), wordData.total = wordData.correct + wordData.incorrect, t.nextSibling.classList.add("current-word")
	elem.style.left = wordData.correct*3 + "%"; // the speed of the car
}

// other car animation
var otherCar2 = 0,otherCar3 = 0,otherCar4 = 0;
var ani2 = document.getElementById("animate2");
var ani3 = document.getElementById("animate3");
var ani4 = document.getElementById("animate4");

function animate2() {
var rand2 = Math.random() * (5 - 0 + 1) + 0; //Generate Random number between 0 - 3
otherCar2 ++
ani2.style.left = otherCar2*3 + "%";   // the speed of the car
	if (ani2.style.left >= '90%') {
	clearInterval(animate2);
	if (wordData.correct < stopWord){carRank = carRank+1;}
	}
	else {
	setTimeout(animate2, rand2 * 1000);
	}
}
function animate3() {
var rand3 = Math.random() * (4 - 0 + 1) + 0; //Generate Random number between 0 - 3
otherCar3 ++
ani3.style.left = otherCar3*3 + "%";   // the speed of the car
	if (ani3.style.left >= '90%') {
	clearInterval(animate3);
	if (wordData.correct < stopWord){carRank = carRank+1;}
	}
	else {
	setTimeout(animate3, rand3 * 1000);
	}
}
function animate4() {
var rand4 = Math.random() * (4 - 0 + 1) + 0; //Generate Random number between 0 - 3
otherCar4 ++
ani4.style.left = otherCar4*3 + "%";   // the speed of the car
	if (ani4.style.left >= '90%') {
	clearInterval(animate4);
	if (wordData.correct < stopWord){carRank = carRank+1;}
	}
	else {
	setTimeout(animate4, rand4 * 1000);
	}
}


var something = (function() {
    var executed = false;
    return function() {
        if (!executed) {
            executed = true;
animate2();
animate3();
animate4();
        }
    };
})();






function clearLine() {
    var e = $("#word-section")[0],
        t = $(".current-word")[0],
        r = t.previousSibling,
        o = $(".correct-word-c, .incorrect-word-c").length;
    if (t.offsetTop > r.offsetTop)
        for (var n = 0; n < o; n++) e.removeChild(e.firstChild)
}




function calculateWPM(e) {
    var t = e.seconds,
        r = e.correct,
        o = e.incorrect,
        n = e.total,
        a = e.typed,
        s = t / 300,
        i = Math.ceil(((a - o*5)/ t )* 12),
        l = Math.ceil(r / n * 100);
var link = "<h3>Congratulation, you rank No. "+carRank+".</h3> <a onClick='window.location.reload();' class='next'>Race Again</a>";
	i < 0 && (i = 0);
	var c = '<ul id="results">\n        <li>You Rank: <span class="wpm-value">' +carRank + '</span></li>\n        <li>WPM: <span class="wpm-value">' + i + '</span> Accuracy: <span class="wpm-value">' + l + '%</span></li>\n        <li id="results-stats">\n        Total Words: <span>' + n + "</span> |\n        Correct Words: <span>" + r + "</span> |\n        Incorrect Words: <span>" + o + "</span> |\n        Characters Typed: <span>" + a + "</span>\n        </li>\n        </ul>";
	$("#word-section")[0].innerHTML = c;
	document.getElementById("link").style.border = "1px solid #CCC", $("#link")[0].innerHTML = link, document.getElementById("result").style.display = "none";
    var h = $("li:nth-child(2) .wpm-value")[0].classList;
    l > 80 ? h.add("correct-word-c") : h.add("incorrect-word-c"), console.log(wordData)
}
function restartTest() {
    location.reload()
}


function allStop(e) {
	something();
    var t = (e = e || window.event).keyCode,
        r = $("#typebox")[0];
    r.value.match(/^\s/g) ? r.value = "" : TimeNow(wordData.seconds) ? (checkWord(r), 32 == t && (submitWord(r), clearLine(), $("#typebox")[0].value = ""), wordData.typed += 1) : calculateWPM(wordData)
}
addWords();
</script>
</body>
</html>