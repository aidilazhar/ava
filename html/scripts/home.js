function widgets() {
    $.getJSON("../api/widgets.php?lid=" + localid, function(e) {
        for (var t = 0; t < e.length; t++) {
            if (7 == e[t].type)var a = $("<div class='col-sm-2 col-xs-2' style='padding:2px;overflow:hidden'><img  style='height:100%;width:100%' onclick='viewProfile("+ e[t].id +")' src=" + e[t].details + "></img></div>");
			else var a = $('<div><b> &#8226; <a href="#scroll" onclick="viewProfile(' + e[t].id + "," + localid + ')">' + e[t].details + "</a> &#8226; " + e[t].status + "</div>");
            $("#widgets" + e[t].type).append(a)
        }
    })
}

function logOut() {
    localStorage.removeItem("id"), location.reload()
}

function checkLogin() {
    var e = new Array;
    e[0] = "January", e[1] = "February", e[2] = "March", e[3] = "April", e[4] = "May", e[5] = "June", e[6] = "July", e[7] = "August", e[8] = "September", e[9] = "October", e[10] = "November", e[11] = "December";
    var t = new Date,
        a = e[t.getMonth()],
        r = t.getFullYear();
    my = a + " " + r, $(".monthyear").html(r), localid ? my == usrexpired ? ($("#dashboard").show(), $("#usrname").html(usrname), $("#usrnamemobile").html(usrname), $("#userDetails").show(), $("#donation").hide(), search(), widgets()) : ($("#dashboard").show(), $("#usrname").html(usrname), $("#usrnamemobile").html(usrname), $("#userDetails").show(), $(".widgets").hide(), search()) : ($("#frontPage").show(), $("#frontlogo").show(), $("#footer").show())
}

function pForm() {
    $("#formProfile").toggle(), $("#tabnav").toggle(), $("#tabcontent").toggle()
}

function recovery() {
    var e = $("#mobile").val();
    $.getJSON("../api/recovery.php?mobile=" + e, function(t) {
        1 == t[0].status ? ($("#loginMsg").hide(), $("#recovery").html('<div class="alert alert-success" role="alert" style="text-align:center"><i class="fa fa-info-circle" aria-hidden="true"></i><b> Success!</b> Recovery SMS send to <b>' + e + "</b></div>")) : ($("#loginMsg").hide(), $("#recovery").html('<div class="alert alert-danger" role="alert" style="text-align:center"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed!</b> Maximum Recovery SMS</div>'))
    })
}

function search() {
    table = $("#search").DataTable(), table.clear().destroy(), $(document).ready(function() {
        var e = $("#searchterm").val(),
            t = $("#search");
        $.getJSON("../api/search.php?id=" + localid + "&term=" + e, function(a) {
            for (var r = 0; r < a.length; r++) {
				var q = "";
				if (a[r].flag > 0){var q = '<i class="fa fa-flag" aria-hidden="true" style="font-size:12px;color:red"></i>';} 
                var i = $('<tr><td><a id="searchresult" href="#scroll" onclick="viewProfile(' + a[r].id + "," + localid + ')"><b> '+q+' '+ a[r].fullname+"</b></a></td><td><b>" + a[r].mobile + "</b></td><td><b>" + a[r].location + "</b></td></tr>");
                t.append(i)
            }
            a.length > 0 ? ($("#searchusers").show(), $("#adduserForm").hide(), $("#search").DataTable({
                order: [
                    [0, "desc"]
                ],
                lengthMenu: [
                    [5, 10, -1],
                    [5, 10, "All"]
                ]
            })) : ($("#adduserForm").show(), $("#backsearch").show(), $("#searchfield").show(), $("#searchusers").hide(), $("#searchmsg").html('Cannot Find User "' + e + '"'))
        })
    })
}

function viewProfile(e, t) {
    if (2 == usrtype) return !1;
    $("[id^=profile]").empty(), $("[id^=records]").empty(), $("[id^=pmsg]").show(), $("#userid").val(e), $("#useridu").val(e), $("#cridu").val(t), $("#crid").val(t);
    var e = e;
    $.getJSON("../api/getprofile.php?rname=" + usrname + "&pid=" + e, function(e) {
        $("#profile11").append('<div><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i><b> Mobile &#8226; ' + e[0].mobile + "</b</div>"), $("#profile11").append('<div><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i><b> Location &#8226; ' + e[0].ulocation + "</b</div>"), $("#profile11").append('<div><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i><b> NRIC &#8226; ' + e[0].nric + "</b</div>");
        for (var t = 0; t < e.length; t++) {
            if (0 == e[t].type) var a = $("<b>" + e[t].details + '</b> <button data-toggle="collapse" data-parent="#accordion" href="#info" aria-expanded="true" aria-controls="collapseOne" type="button" class="btn btn-default btn-xs"><span><i class="fa fa-plus" aria-hidden="true"></i></span></button><button type="button" class="btn btn-default btn-xs" style="color:red" onclick="flagBtn(' + e[t].id + "," + e[t].flag + ')"><span><i class="fa fa-flag" aria-hidden="true"></i> <b id="totalflag">' + e[t].flag + '</b></span></button><button type="button" class="btn btn-default btn-xs" style="color:green" onclick="ratingBtn(' + e[t].id + "," + e[t].rating + ')"><span><i class="fa fa-star" aria-hidden="true"></i> <b id="totalrating">' + e[t].rating + "</b></span></button> <button type='button' class='btn btn-success btn-xs'>Verified</button>");
            else if (1 == e[t].status) var a = $('<div><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i><b> ' + e[t].name + " &#8226; " + e[t].details + " &#8226; " + e[t].date + " &#8226; " + e[t].number + '</b> ||<span class="votebtn"><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteUp(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-plus-circle" aria-hidden="true"></i></button><span id="totalvotes' + e[t].id + '"><b>' + e[t].votes + '</b></span><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteDown(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></span></div>"');
            
			else if (7 == e[t].type) var a = $('<div class="col-sm-4 col-xs-6"><img class="img-responsive" src="' + e[t].details + '"></img><i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i> Verified ||<span class="votebtn"><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteUp(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-plus-circle" aria-hidden="true"></i></button><span id="totalvotes' + e[t].id + '"><b>' + e[t].votes + '</b></span><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteDown(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></span></div>"'); 
			
			else var a = $('<div><i class="fa fa-ban" aria-hidden="true" style="color:red"></i><b style="color:#999"> ' + e[t].name + " &#8226; " + e[t].details + " &#8226; " + e[t].date + " &#8226; " + e[t].number + '</b> ||<span class="votebtn"><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteUp(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-plus-circle" aria-hidden="true"></i></button><span id="totalvotes' + e[t].id + '"><b>' + e[t].votes + '</b></span><button class="btn btn-default btn-xs" style="border:0px" type="button" onclick="voteDown(' + e[t].id + "," + e[t].votes + ')"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></span></div>"');
            var r = $("#records" + e[t].type).text();
            "" == r && (r = 0);
            var i = parseInt(r, 10) + 1;
            $("#profile" + e[t].type + e[t].status).append(a), $("#records" + e[t].type).html(i), $("#pmsg" + e[t].type).hide(), $("#uv" + e[t].type + e[t].status).show()
        }
    }), $("#view_profile").show(), $("#widgets").hide()
}

function voteUp(e, t) {
    $.getJSON("../api/votes.php?v=1&usrid=" + localid + "&pid=" + e, function(t) {
        1 == t[0].status ? ($("#totalvotes" + e).html(t[0].total), $("#perrora").hide(), $("#psuccessa").show(), $("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> Vote added <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>')) : ($("#psuccessa").hide(), $("#perrora").show(), $("#perrorb").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed! </b>You already voted for this info<button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>'))
    })
}

function voteDown(e, t) {
    $.getJSON("../api/votes.php?v=0&usrid=" + localid + "&pid=" + e, function(t) {
        1 == t[0].status ? ($("#totalvotes" + e).html(t[0].total), $("#perrora").hide(), $("#psuccessa").show(), $("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> Vote added <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>')) : ($("#psuccessa").hide(), $("#perrora").show(), $("#perrorb").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed! </b>You already voted for this info<button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>'))
    })
}

function ratingBtn(e, t) {
    $.getJSON("../api/ratingflag.php?t=r&usrid=" + localid + "&pid=" + e, function(e) {
        1 == e[0].status ? ($("#totalrating").html(e[0].total), $("#perrora").hide(), $("#psuccessa").show(), $("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> Rating added <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>')) : ($("#psuccessa").hide(), $("#perrora").show(), $("#perrorb").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed! </b>You already rated this user<button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>'))
    })
}

function flagBtn(e, t) {
    $.getJSON("../api/ratingflag.php?t=f&usrid=" + localid + "&pid=" + e, function(e) {
        1 == e[0].status ? ($("#totalflag").html(e[0].total), $("#perrora").hide(), $("#psuccessa").show(), $("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> User Flagged <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>')) : ($("#psuccessa").hide(), $("#perrora").show(), $("#perrorb").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed! </b>You already Flag this user<button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>'))
    })
}

function xclose(t) {
    $("#perrora").hide(), $("#psuccessa").hide()
}

function molpayform() {
    $("#view_profile").hide(), $("#donations").show()
}

function molpay() {
    $(document).ready(function() {
        $(".thb").hide(), $("#selector").change(function() {
            var e = $(this).val();
            $(".cur_span").text(e), $("#currency").val(e), "MYR" == e ? ($(".myr").show(), $(".thb").hide()) : ($(".thb").show(), $(".myr").hide())
        }), $("input[name=payment_options]").on("click", function() {
            var e = $(this).closest("form");
            e[0].checkValidity() ? e.trigger("submit") : (alert("Please fill in required field."), $(":input[required]").each(function() {
                return 0 == $(this).val().length ? ($(this).focus(), !1) : void 0
            }))
        })
    })
}
var avava = {};
localid = localStorage.getItem("id"), usrname = localStorage.getItem("name"), usrmobile = localStorage.getItem("mobile"), usrexpired = localStorage.getItem("expired"), usrtype = localStorage.getItem("type"), $("#home").click(function() {
    location.reload()
}), $("#info").click(function() {
    $("#formProfilemsg").hide(), $("#formProfile").show()
}), $("#type").change(function() {
    1 == this.value && ($("#name").attr("placeholder", "Mobile Provider, Location or Car Type"), $("#details").attr("placeholder", "Details"), $("#date").attr("placeholder", "Car Plate Number, Mobile Number"), $("#number").attr("placeholder", "NRIC, Bank Account Number")), 2 == this.value && ($("#name").attr("placeholder", "Wife, Son, Daughter or Girlfriend"), $("#details").attr("placeholder", "Full Name"), $("#date").attr("placeholder", "Wedding or Born Date"), $("#number").attr("placeholder", "NRIC")), 3 == this.value && ($("#name").attr("placeholder", "University Name"), $("#details").attr("placeholder", "Award Name - B.A in Multimedia"), $("#date").attr("placeholder", "Graduation Date"), $("#number").attr("placeholder", "Award Number")), 4 == this.value && ($("#name").attr("placeholder", "Company Name"), $("#details").attr("placeholder", "Job Title - Position"), $("#date").attr("placeholder", "Date Join"), $("#number").attr("placeholder", "Salary")), 5 == this.value && ($("#name").attr("placeholder", "Crime Code"), $("#details").attr("placeholder", "Crime Details"), $("#date").attr("placeholder", "Police Report Number or Date"), $("#number").attr("placeholder", "Case Status - Open - Investigation - Court - Close")), 6 == this.value && ($("#name").attr("placeholder", "Title"), $("#details").attr("placeholder", "Comments"), $("#date").attr("placeholder", "Character - Good - Bad - Ugly"), $("#number").attr("placeholder", "Recomendation or Advise")), 7 == this.value && ($("#updatePform").hide(),$("#uploadPform").show())
}), $("#signupForm").submit(function() {
    return $("#response").html("<b>Loading response...</b>"), $.post("../api/signup.php", $(this).serialize(), function(e) {
        $("#response").html(e)
    }).fail(function() {
        alert("Posting failed.")
    }), !1
}), $("#adduserForm").submit(function() {
    return $("#cid").val(localid), $("#nid").val(usrname), $("#searchmsg").html("<b>Loading response...</b>"), $.post("../api/adduser.php", $(this).serialize(), function(e) {
       $("#adduserForm").hide(),$("#searchterm").val(e),search()
    }).fail(function() {
        alert("Posting failed.")
    }), !1
}), $("#formProfile").submit(function() {
    return $.post("../api/updateprofile.php", $(this).serialize(), function(e) {
        var t = JSON.parse(e);
        1 == t[0].status ? ($("#info").removeClass("in"), $("#perrora").hide(), $("#psuccessa").show(), viewProfile(t[0].id), $("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> User information updated <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>')) : ($("#info").removeClass("in"), $("#psuccessa").hide(), $("#perrora").show(), $("#perrorb").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> Failed! </b> You have reach max edit for this user<button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>'))
    }).fail(function() {
        alert("Posting failed.")
    }), !1
}), $("#loginForm").submit(function() {
    return $("#loginMsg").html('<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>'), $.post("../api/login.php", $(this).serialize(), function(e) {
        var t = JSON.parse(e),
            a = t[0].status,
            r = t[0].id,
            i = t[0].fullname,
            l = t[0].mobile,
            d = t[0].expired,
            s = t[0].type;
        1 == a ? ($("#loginMsg").html("Incorrect NRIC / Password"), $("#recovery").html('<a href="#" class="btn btn-default form-control" onclick="recovery()"><b><i class="fa fa-key" aria-hidden="true"></i> Password Recovery </a')) : (localStorage.setItem("id", r), localStorage.setItem("name", i), localStorage.setItem("mobile", l), localStorage.setItem("expired", d), localStorage.setItem("type", s), location.reload())
    }).fail(function() {
        alert("Posting failed.")
    }), !1
}), $("#fullnameSU").keyup(function() {
    var e = $("#fullnameSU").val(),
        t = $.trim(e).length,
        a = new RegExp(/\s+/),
        r = a.test(e);
    1 == r && t > 7 ? ($("#response").html("Must follow your NRIC"), $("#mobileSU").removeAttr("disabled")) : ($("#response").html("Please type your Full Name"), $("#mobileSU").attr("disabled", "true"))
}), $("#mobileSU").keyup(function() {
    var e = $("#mobileSU").val(),
        t = $.trim(e).length,
        a = new RegExp(/([0]{1})([1]{1})([0-9]{1})([1-9]{1})([0-9]{6}$)/),
        r = a.test(e);
    1 == r && 10 == t ? $.post("../api/login.php", $(this).serialize(), function(t) {
        var a = JSON.parse(t),
            r = a[0].status;
        2 == r ? ($("#response").html("Please enter your NRIC Number"), $("#nricSU").attr("border", "1"), $("#nricSU").removeAttr("disabled"), $("#nricSU").attr("border", "1")) : ($("#response").html(" Mobile Number <b>" + e + "</b> already Registered "), $("#nricSU").attr("disabled", "true"))
    }) : ($("#response").html("10 digits in <b>0123456789</b> format"), $("#nricSU").attr("disabled", "true"))
}), $("#nricSU").keyup(function() {
    $("#response").html('<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>');
    var e = $("#nricSU").val(),
        t = $.trim(e).length,
        a = new RegExp(/([0-9]{2})([0-1]{1})([0-9]{1})([0-3]{1})([0-9]{2})([1-9]{1})/),
        r = a.test(e);
    1 == r && 12 == t ? ($("#response").html("To Proceed please click <b>SIGN UP</b> button"), $("#signupBtn").removeAttr("disabled")) : ($("#response").html("NRIC must be in <b>951203065878</b> Format"), $("#signupBtn").attr("disabled", "true"))
}), $("#fullnameAD").keyup(function() {
    var e = $("#fullnameAD").val(),
        t = $.trim(e).length,
        a = new RegExp(/\s+/),
        r = a.test(e);
    1 == r && t > 7 ? ($("#searchmsg").html("Please enter Mobile Number"), $("#mobileAD").removeAttr("disabled")) : ($("#searchmsg").html("Please type Fullname"), $("#mobileAD").attr("disabled", "true"))
}), $("#mobileAD").keyup(function() {
    var e = $("#mobileAD").val(),
        t = $.trim(e).length,
        a = new RegExp(/([0]{1})([1]{1})([0-9]{1})([1-9]{1})([0-9]{6}$)/),
        r = a.test(e);
    1 == r && 10 == t ? ($("#searchmsg").html("Please enter NRIC Number"), $("#addusrBtn").removeAttr("disabled")) : ($("#searchmsg").html("Wrong Mobile Number Format"), $("#addusrBtn").attr("disabled", "true"))
}), $("#nricAD").keyup(function() {
    var e = $("#nricAD").val(),
        t = $.trim(e).length,
        a = new RegExp(/([0-9]{2})([0-1]{1})([0-9]{1})([0-3]{1})([0-9]{7}$)/),
        r = a.test(e);
    1 == r && 12 == t ? $("#searchmsg").html("Click Advanced Search Button to Proceed") : $("#searchmsg").html("Wrong NRIC Format")
}), $("#mobile").bind("change keyup", function(e) {
    $("#mobile").val();
    $.post("../api/login.php", $(this).serialize(), function(e) {
        var t = JSON.parse(e),
            a = t[0].status,
            r = t[0].fullname;
        0 == a ? ($("#loginMsg").html("Please verify your Mobile Number"), $("#loginBtn").attr("disabled", "true"), $("#nric").attr("disabled", "true")) : 1 == a ? ($("#loginMsg").html("<b>" + r + "</b>"), $("#loginBtn").removeAttr("disabled"), $("#nric").removeAttr("disabled")) : ($("#loginMsg").html("Unregistered, Please Sign-Up"), $("#loginBtn").attr("disabled", "true"), $("#nric").attr("disabled", "true"))
    })
});
$("#uploadForm").on("submit", function(t) {
    t.preventDefault(), $.ajax({
        url: "api/upload.php",
        type: "POST",
        data: new FormData(this),
        contentType: !1,
        cache: !1,
        processData: !1,
        success: function(t) {
		0==t?($("#perrora").show(),$("#perrorb").html('<i class="fa fa-thumbs-down" aria-hidden="true"></i><b> Failed!</b> Max 6 Photos only & image must be in .jpg format <button type="button" class="btn btn-danger btn-xs pull-right" onclick="xclose()">x</button>')):($("#info").removeClass("in"),viewProfile(t,localid),$("#psuccessa").show(),$("#psuccessb").html('<i class="fa fa-thumbs-up" aria-hidden="true"></i><b> Success!</b> User photos updated <button type="button" class="btn btn-success btn-xs pull-right" onclick="xclose()">x</button>'));},
        error: function() {}
    })
});
$("#uploadCancel").click(function() {
    $("#updatePform").show(), $("#formProfile").show(),$("#uploadPform").hide(),$("#type").val(""),$("#uploadPform").hide();
});

