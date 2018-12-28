function show_time(){
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var seconds=Digital.getSeconds()
var dn="AM"
if (hours>12){
dn="PM"
hours=hours-12
}
if (hours==0)
hours=12
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds
/*document.Tick.Clock.value = hours+":"+minutes+":"
+seconds+" "+dn
 */

document.getElementById('time').innerHTML = hours+":"+minutes+":"
+seconds+" "+dn;
setTimeout("show_time()",1000);

}