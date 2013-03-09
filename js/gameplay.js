var val =false;
var tab = [false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false ,false];
var tdarray =[] ,foundwordsarr = [];
var str =new String("");
var site_url = "http://www.wordtrix.in/gamerboard.html";
var words;
var name,id;
var seconds_left ;
var prev =-1,score =0 ,valid =false ,exist =false;

function convert(m) {
	return (parseInt((m-11)/10)*4 + (m%10) -1);
}
function changetext(td)
{
	document.getElementById(td).className ="buttoncssmod";
}
function mousedown(td ) {
	//clearing
	tdarray.length =0;
	var tmp =document.getElementById(td).innerHTML;
	if(!val)
		   val =true;
    if(!tab[convert(td)]) {
	prev = convert(td)+1;
	str += tmp; 
	tab[convert(td)] =true;
	changetext(td);
	tdarray.push(td);
	//console.log("mouse down");
	}

}

function mouseover(td) {
	var tmp =document.getElementById(td).innerHTML;
	if(val && !tab[convert(td)] )  {
	var curr =convert(td);
	++curr;
	var cal = Math.abs(curr-prev);
	if(cal ==1 || cal==3 || cal ==4 || cal==5)
	{
	str += tmp;
	tab[convert(td)] =true;
	changetext(td);
	prev =curr;
	tdarray.push(td);
	}
	//console.log("mouse over");
	}
}
function mousemove(elm) 
{
	//console.log("mouse move -outside table" +elm);
	mouseup();
}


function mouseup() {
	//alert("Mouse Up,index clicked :");
	if(val) {
	updatescore();
	highlightblocks();
	val =false;
	for(var i=0;i<16;++i) tab[i] =false;
	str="";
	prev =-1;
	}
}
function highlightblocks()
{
	if(valid && !exist) {
		for(var i=0;i<tdarray.length;++i)
		  document.getElementById(tdarray[i]).className = "buttoncsscorrect";
	}
	else if(exist) 
	{
		for(var i=0;i<tdarray.length;++i)
		  document.getElementById(tdarray[i]).className = "buttoncssexisting";
	}
	else {
		for(var i=0;i<tdarray.length;++i)
		  document.getElementById(tdarray[i]).className = "buttoncsswrong";
	}
	setTimeout('resetcss()',300);
}
function resetcss() {
	 document.getElementById("11").className ="buttoncss";
	 document.getElementById("12").className ="buttoncss";
	 document.getElementById("13").className ="buttoncss";
	 document.getElementById("14").className ="buttoncss";
	 document.getElementById("21").className ="buttoncss";
	 document.getElementById("22").className ="buttoncss";
	 document.getElementById("23").className ="buttoncss";
	 document.getElementById("24").className ="buttoncss";
	 document.getElementById("31").className ="buttoncss";
	 document.getElementById("32").className ="buttoncss";
	 document.getElementById("33").className ="buttoncss";
	 document.getElementById("34").className ="buttoncss";
	 document.getElementById("41").className ="buttoncss";
	 document.getElementById("42").className ="buttoncss";
	 document.getElementById("43").className ="buttoncss";
	 document.getElementById("44").className ="buttoncss";
}

function updatescore()
{
	var len =str.length;
	valid =false;
	exist =false;
	if(len>2 ) {	
	//valid = isvalidword();
	for(var i=0;i<foundwordsarr.length;++i) {
		if(foundwordsarr[i] == str) 
		  exist =true;
	}
	if(!exist)  {
		for(var i=0;i<words.length;++i) {
		if(words[i] == str) 
		valid =true;
	}
	if(valid) 
	{
	score += len *len;
	document.getElementById("score_div").innerHTML = score;	
    addfoundword();	
	var snd = new Audio("/sounds/correct.wav"); // buffers automatically when created
snd.play();
	}
	else
	{
	var snd = new Audio("/sounds/wrong.wav"); // buffers automatically when created
snd.play();	
	console.log("invalid word");
	}
	}
	else
	{
	console.log(" already found");
	var snd = new Audio("/sounds/exists.wav"); // buffers automatically when created
snd.play();
	}
	}
	else
	{
	console.log('too short');
	var snd = new Audio("/sounds/wrong.wav"); // buffers automatically when created
snd.play();
	}
}


function addfoundword()
{
	var found = document.getElementById("foundwords_div");
	var word = document.createElement("li");
	var fword= document.createTextNode(str);
	word.appendChild(fword);
	found.appendChild(word);
	foundwordsarr.push(str);
}


function loadwords()
{
//window.localStorage.clear();
var _words = localStorage['storewords'];
if(_words==null)  {
	//first time cgame
	var xhr = new XMLHttpRequest();
    xhr.open('GET', 'Data/op.txt', false);
    xhr.send(null);
	localStorage['storewords']  =xhr.responseText;
    words = localStorage['storewords'].split(',');
}
else {
	words = _words.split(',');
}
//console.info(words.length + "are avilable");
//console.info(words[0][0]);
//for(var i=0;i<100;++i)
//console.info(words[i]);
}


//binary search algo -not used ,some bugs ..complexity O(LOGN)
function isvalidword() {
      var beginning = 0, end = words.length,mid ;
      while (true) {
          mid = Math.floor((beginning + end) / 2);
		  if ((mid === end || mid === beginning) && words[mid]!== str) {
              return -1;
          }
          if (str > words[mid] ) {
              end = mid;
          } else if (str < words[mid]) {
             beginning =mid;
          } 
		  else 
		  return mid;
      }
  }


  
function submitgame() {
/*alert("your score ="+ document.getElementById("score_div").innerHTML + " ,no of words :" + foundwordsarr.length +" !" );*/
//submit to db
var xhr = new XMLHttpRequest();
xhr.open('GET', 'js/insert-db.php?name='+name+'&score='+score+"&id="+id,false);
xhr.send(null);
console.log(xhr.responseText);
window.localStorage.setItem('finalscore',score);
window.localStorage.setItem('wordcount',foundwordsarr.length);
window.location.href = "gamerboard.html";
//setTimeout('moveurl()',200);

}



function loadpuzzle() {
var tmp;
var xhr = new XMLHttpRequest();
xhr.open('GET', 'js/puzzle.php',false);
xhr.send(null);
console.log(xhr.responseText);
var gamearr = xhr.responseText;
for(var i=0;i<gamearr.length;++i) 
{
 tmp = decrypt(i);	
 console.log(tmp);
 document.getElementById(tmp).innerHTML = gamearr[i];
}
}

function decrypt(n) {
	return parseInt((n/4)+1)*10+(n%4)+1;
}

function cleardb() {
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'js/clearlb.php',true);
	xhr.send(null);
	console.log(xhr.responseText)
}

/*function init() {
	//all initlization stuff
	loadwords();
	//loadpuzzle();
	//cleardb();
	window.localStorage.setItem('finalscore',0);
	window.localStorage.setItem('wordcount',0);
	document.onselectstart = function(){ return false; }
	var xhr = new XMLHttpRequest();
	xhr.open('GET', 'js/timer.php',false);
	xhr.send(null);
	console.log(xhr.responseText);
    var tmp = parseInt(xhr.responseText);
	//decide before or aftre the game.
	if(tmp <=120 ) {
	   seconds_left = 120-tmp;
	}
	else {
		window.location.href = site_url;
	}
	var interval = setInterval(function() {
    document.getElementById('timer_div').innerHTML = --seconds_left;
	if(seconds_left==8)
	{
		var snd = new Audio("/sounds/clock.ogg"); // buffers automatically when created
snd.play();
	}
    if (seconds_left <= 0)
    {
        document.getElementById('timer_div').innerHTML = "Time's up";
        clearInterval(interval);
		//submitgame();
    }
}, 1000);
	var labels = document.getElementsByTagName('th');
	for (var i = 0; i < labels.length; i++) {
		disableSelection(labels[i]);
	}  			
}*/
function disableSelection(element) 
			{
                if (typeof element.onselectstart != 'undefined') {
                    element.onselectstart = function() { return false; };
                } else if (typeof element.style.MozUserSelect != 'undefined') {
                    element.style.MozUsserSelect = 'none';
                } else {
                    element.onmousedown = function() { return false; };
                }
            }	