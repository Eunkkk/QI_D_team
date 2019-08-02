< script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" > < /script> <
    script type = "text/javascript" >

    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#confirm_new_password").val();

        if (password != confirmPassword) {
            var match = "The passwords do not match."
            var result = match.fontcolor('red');
            $("#divCheckPasswordMatch").html(result);
        } else {
            var match = "The passwords match!";
            var result = match.fontcolor('green');
            $("#divCheckPasswordMatch").html(result);
        }
    }

function checkPasswordForm() {
    var password = $("#password").val();
    var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,$,^,*,?,_,~])/;
    var password_regex2 = /([0-9])/;
    var password_regex3 = /([!,%,&,@,#,$,^,*,?,_,~])/;

    if (password.length < 8 || password_regex1.test(password) == false || password_regex2.test(password) == false || password_regex3.test(password) == false) {
        var match = "Password must be at least 8 Digits long and contains one upper case, one Lower case and one special character."
        var result = match.fontcolor('red');
        $("#divCheckPasswordForm").html(result);
    } else {
        var match = "Good password."
        var result = match.fontcolor('green');
        $("#divCheckPasswordForm").html(result);
    }


    function formCheck(frm) {
        if (frm.password.value == "") {
            alert("Please enter your current password.");
            frm.password.focus();
            return false;
        }
        if (frm.new_password.value == "") {
            alert("Please enter your new password.");
            frm.new_password.focus();
            return false;
        }
        if (frm.confirm_new_password.value == "") {
            alert("Please enter your confirm password.");
            frm.confirm_new_password.focus();
            return false;
        }

        var new_pwd = $("#new_password").val();
        var confirm_new_pwd = $("#confirm_new_password").val();
        var password_regex1 = /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,$,^,*,?,_,~])/;
        var password_regex2 = /([0-9])/;
        var password_regex3 = /([!,%,&,@,#,$,^,*,?,_,~])/;

        if (new_pwd.length < 8 || password_regex1.test(new_pwd) == false || password_regex2.test(new_pwd) == false || password_regex3.test(new_pwd) == false) {
            alert("Password Must be at least 8 Digitslong and contains one UpperCase, one LowerCase and One special character.");
            return false;
        } else if (new_pwd !== confirm_new_pwd) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }