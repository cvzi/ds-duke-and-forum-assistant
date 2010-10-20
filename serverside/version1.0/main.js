// OnLoad
window.addEvent('domready', function() {

    if($("registerpassword0") && $("registerpassword1")) {
        $("registerpassword0").addEvent("keyup",pass_check);
        $("registerpassword1").addEvent("keyup",pass_check);
    }

    if($("registername")) {
        $("registername").addEvent("keyup",name_check);
    }

    if($("registerusername")) {
        $("registerusername").addEvent("keyup",name_check);
    }

    if($("registergroupname")) {
        $("registergroupname").addEvent("keyup",name_check);
    }


});

function name_check() {
    if(this.value.length > 3) {
        this.tween('background-color', '#90ee90');
    }
    else {
        this.tween('background-color', '#f08080');
    }
}

function pass_check() {
    if($("registerpasswordt0").value == $("registerpassword1").value) {
        $$($("registerpassword0"),$("registerpassword1")).tween('background-color', '#90ee90');
    } 
    else if("" == $("registerpassword1").value) {
        $("registerpassword0").tween('background-color', '#ffffff');
        $("registerpassword1").tween('background-color', '#f0e68c');
    }
    else {
        $$($("registerpassword0"),$("registerpassword1")).tween('background-color', '#f08080');
    }
}


