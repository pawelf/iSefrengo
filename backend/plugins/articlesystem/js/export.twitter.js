function publishTweet(aid) {
  window.frames['articleupdate'+aid].document.frm.sentdatetime.value=getDateTime();
  window.frames['articleupdate'+aid].document.frm.action.value='publish';
  window.frames['articleupdate'+aid].document.frm.submit();
}


function getDateTime(){
	var now = new Date();
	
	var year=now.getFullYear();
	var month=now.getMonth()+1;
	var day=now.getDate();
	var minute=now.getMinutes()
	var hour=now.getHours();
	var seconds=now.getSeconds();
	
	if (month<10)
		month='0'+month;

	if (day<10)
		day='0'+day;

	if (minute<10)
		minute='0'+minute;

	if (hour<10)
		hour='0'+hour;

	if (seconds<10)
		seconds='0'+seconds;

	return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+seconds;
																	
}
    