function callback_startdate(date, month, year)
{
	if (String(month).length == 1) {
		month = '0' + month;
	}

	if (String(date).length == 1) {
		date = '0' + date;
	}
	document.editform.startdate.value = date + '.' + month + '.' + year;
	document.editform.online[2].checked=true;
}

//Callback for Calendar stop date
function callback_enddate(date, month, year)
{
	if (String(month).length == 1) {
		month = '0' + month;
	}

	if (String(date).length == 1) {
		date = '0' + date;
	}
	document.editform.enddate.value = date + '.' + month + '.' + year;
	document.editform.online[2].checked=true;
}

   $.tools.dateinput.localize('de', {
   months: 'Januar,Februar,März,April,Mai,Juni,Juli,August,September,October,November,December',
   shortMonths:  'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
   days:         'Sonntag,Montag,Dienstag,Mittwoch,Donnerstag,Freitag,Sonabend',
   shortDays:    'Son,Mon,Die,Mit,Don,Fri,Sam'});

   $.tools.dateinput.localize('en', {
   months: 'January,February,March,April,May,June,July,August,September,October,November,December',
   shortMonths:  'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
   days:         'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
   shortDays:    'Sun,Mon,Tue,Wed,Thu,Fri,Sat'});

   $.tools.dateinput.localize('fr',  {
   months:        'janvier,f&eacute;vrier,mars,avril,mai,juin,juillet,ao&ucirc;t,' +
                   	'septembre,octobre,novembre,d&eacute;cembre',
   shortMonths:   'jan,f&eacute;v,mar,avr,mai,jun,jul,ao&ucirc;,sep,oct,nov,d&eacute;c',
   days:          'dimanche,lundi,mardi,mercredi,jeudi,vendredi,samedi',
   shortDays:     'dim,lun,mar,mer,jeu,ven,sam'});

