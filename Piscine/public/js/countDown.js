function makeCounter(tdId, dateInitiale, periode) {

    var dti = new Date(dateInitiale)
    var dtiMillis = dti.getTime();
    var newTime = dtiMillis + 1000 * 60 * 60 * periode
    var newDate = new Date(newTime)

    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = newDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display countdown in desired td
        if (days > 0){
            document.getElementById(tdId).innerHTML = days + "j " + hours + "h "
                + minutes + "m " + seconds + "s ";
        }
        else {
            if (hours > 0){
                document.getElementById(tdId).innerHTML =  hours + "h "
                    + minutes + "m " + seconds + "s ";
            }
            else {
                document.getElementById(tdId).innerHTML =  minutes + "m " + seconds + "s ";
            }
        }

        // If the count down is finished, notify client
        if (distance < 0) {
            clearInterval(x);
            document.getElementById(tdId).innerHTML = "EXPIRED";
        }
    }, 1000);

}