(function(){
var $ = function(id){return document.getElementById(id);}
var butt = $('s');
butt.onclick = function(){
if($('title_event').value == '') {alert('Please enter a event title!');return;} 
butt.setAttribute('disabled','disabled');
butt.setAttribute('value','loading...');
var url = 'insert-event.php?format=json';
var fields = ['title_event','startMon','startDay','startYear','startHourMerid','startMin'];
  for(var i=0;i<fields.length;i++){
        var value = $(fields[i]).value;
        url += '&'+fields[i]+'='+value;
  }
  asyncRequest.REQUEST('GET',url,handleResponse);
  return false;     
 }

 function handleResponse(resp) {

    butt.removeAttribute('disabled');
 
    butt.setAttribute('value','Add Event');

    $('stats').innerHTML = resp;
 }
})();//do exec
