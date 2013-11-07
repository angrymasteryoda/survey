function clearForm(inputs){
    for ( var  i = 0; i < inputs.length; i++ ) {
        inputs.eq(i).val('');
    }
}

function clog(array){
    console.log(array);
}

function createSuccessBanner(str, error, time){
    var className = 'greenHat';
    var addTo = '';
    if(!time){
        time = 5000;
    }
    console.log(typeof error);
    if(typeof error != 'undefined'){
        className = 'redHat';
        addTo = '<br>Debug Info:  ' + error
        time = 10000;
    }

    $('body').append('<div style="display: none;" class="successBanner"><div class="'+className+'"></div>' + str + addTo + '</div>');
    $('.successBanner').slideDown(550, function(){
        setTimeout("$('.successBanner').slideUp(550, function(){$('.successBanner').remove();})", time);
    });

}

function checkRegex(str, type, formClass, pattern) {
    if(typeof type == 'undefined'){clog('not testing ' + str);return [];}//hacky way to bypass if no test required
    if ( type.match(/conf/) ) {
        var parent = type.split( 'conf' )[1].toLowerCase();

        if( $('[data-type=' + parent + ']', formClass).val() != ''){
            if ( $('[data-type=' + parent + ']', formClass).val() != str ) {
                return null;
            }
        }

        type = parent;
    }
    if(type == 'custom'){
        return str.match(pattern);
    }
    else{
        return str.match( getRegex(type).regex );
    }
}

function getApp_Dir(path){
    if(path){
        return APP_URL + path;
    }
    else{
        return APP_URL;
    }
}

function getHumanTime(time){
    timeSplit = time.split(':');
    if(timeSplit[0] > 12){
        return (timeSplit[0]%12) + ':' + timeSplit[1] + 'Pm';
    }
    else{
        return timeSplit[0] + ':' + timeSplit[1] + 'Am';
    }
}

function goTo(url) {
    location.href = url;
}

function getRegex(type){
    if ( type.match(/length-/) ) {
        var len = type.split( '-' )[1];
        return {'regex' : new RegExp('\(.){' + len + '}'), 'error' : 'has to be ' + len + ' long'};
    }
    else {
        return regex[type];
    }
}

var regex = {
    'username' : {
        'regex' : /^[a-zA-Z]{2,50}$/g,
        'error' : 'has to be 2-50 letters only'
    },
    'password' : {
        'regex' : /^[0-9a-zA-Z]{6,50}$/g,
        'error' : 'has to be 6-50 long alphanumerical'
    },
    'email' : {
        'regex' : /[a-zA-Z0-9-]{1,}@([a-zA-Z\.])?[a-zA-Z]{1,}\.[a-zA-Z]{1,4}/gi,
        'error' : 'has to be valid email'
    },
    'complex-password' : {
        'regex' : /^(?!.*(.)\1{3})((?=.*[\d])(?=.*[a-z])(?=.*[A-Z])|(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[A-Z])(?=.*[^\w\d\s])|(?=.*[\d])(?=.*[a-z])(?=.*[^\w\d\s])).{7,30}$/g,
        'error' : 'has to be 7-30 must contain capital letter, and number or symbol'
    },
    'date' : {
        'regex' : /(\d{4})\-(\d{2})\-(\d{2})/g,
        'error' : 'has to be a valid date'
    },
    'time' : {
        'regex' : /(\d{2})\:(\d{2})/g,
        'error' : 'has to be a valid time'
    }
};