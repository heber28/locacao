/**
 * 
 */

function scroll(text, speed, delay) {
	if (speed == undefined)
		speed = 400;
	if (delay == undefined)
		delay = 1300;
	$('#mensagem').html('<div id="texto">' + text + "</div>");
	$('#mensagem').slideToggle(speed);
	$('#mensagem').delay(delay);
	$('#mensagem').slideToggle(speed);
}
