$(window).on('load', function () {
    $('.preload').delay(100).fadeOut('slow');
});

$(document).ready(function() {
    $(".genre-item").find(".subgenre-list").hide();

    var links = document.links;
    for (i = 0; i < links.length; i++) {
        if (links[i].href === document.URL) { 
            links[i].style.color = "var(--blue-color)";
        }
    }

    $("a").click(function (event) {
		event.preventDefault();
        linkLocation = this.href;
        $(".preload").fadeIn('fast', redirectPage);
    });

	function redirectPage() {
		window.location = linkLocation;
	}

    let mouseDown = false;
    let track_i = false;
    let audio = $("audio").get(0);
    let avatar = false;

    $("#avatar").change(function (evt) {
        var file = evt.target.files;
        var f = file[0];
        if (!f.type.match('image.*')) {
            alert("Choose image!");
        }
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                $("#avatar-result").attr({"title":escape(theFile.name), "src":e.target.result, "class":"profile-img"}).css({"margin":"0", "width":"8em", "height":"8em"});
                $(".choose-avatar").text(theFile.name);
            };
        })(f);
        reader.readAsDataURL(f);
    });

    $(".current-track").hover(function () {
            $(this).find(".track-progress-value").slideDown(1000);
            $(this).find(".track-progress-duration").slideDown(1000);
        }, 
        function () {
            $(this).find(".track-progress-value").stop(true);
            $(this).find(".track-progress-duration").stop(true);
            $(this).find(".track-progress-value").slideUp(500);
            $(this).find(".track-progress-duration").slideUp(500);
        }
    );

    $(".play-pause-button, .volume-button, .prev-button, .next-button").attr("disabled", false);

    $(".play-pause-button").on("click",  function () {
        if ($(".play-pause-button").attr("disabled")) {
            if (audio.paused) {
                audio.play();
            }
            else {
                audio.pause();
            }
        }
    });

    $(".prev-button").on("click",  function () {
        if ($(".prev-button").attr("disabled")) {
            track_i--;
            if (track_i === -1) {
                track_i = $(".track-item").length-1;
            }

            getTrack(track_i);
        }
    });

    $(".next-button").on("click",  function () {
        if ($(".next-button").attr("disabled")) {
            track_i++;
            if (track_i === $(".track-item").length) {
                track_i = 0;
            }

            getTrack(track_i);
        }
    });

    $(".volume-button").on("click",  function () {
        if ($(".volume-button").attr("disabled")) {
            if (audio.muted) {
                $(this).css("background", "url('../images/speaker.png') no-repeat center/contain");
                audio.muted = false;
                $(".volume-value").fadeIn(300);
            }
            else {
                $(this).css("background", "url('../images/mute.png') no-repeat center/contain");
                audio.muted = true;
                $(".volume-value").fadeOut(300);
            }
        }
    });

    var timeFormat = (function (){
        function num(val){
            val = Math.floor(val);
            return val < 10 ? '0' + val : val;
        }
    
        return function (ms){
            var sec = ms / 1000, 
                hours = sec / 3600 % 24, 
                minutes = sec / 60 % 60, 
                seconds = sec % 60;
    
            return num(hours) + ":" + num(minutes) + ":" + num(seconds);
        };
    })();

    $(audio).on("canplay", function() {
        $(".play-pause-button, .volume-button, .prev-button, .next-button").attr('disabled', true);
        $(".track-progress-duration").text(timeFormat(audio.duration*1000));
    });

    $(audio).on("play", function() {
        $(".play-pause-button").css("background", "url('../images/pause.png') no-repeat center/contain");
        $(".track-item").find(".track-play").css("background", "url('../images/play_button.png') no-repeat center/contain");
        $(".track-item").eq(track_i).find(".track-play").css("background", "url('../images/pause_button.png') no-repeat center/contain");
    });

    $(audio).on("pause", function() {
        $(".play-pause-button").css("background", "url('../images/play.png') no-repeat center/contain");
        $(".track-item").eq(track_i).find(".track-play").css("background", "url('../images/play_button.png') no-repeat center/contain");
    });

    $(audio).on("timeupdate", function() {
        duration = audio.duration;
        currentTime = audio.currentTime;
        progress = (100 / duration * currentTime);

        $(".track-progress").attr("value", progress);
        $(".track-progress-value").text(timeFormat(currentTime*1000));
    });

    $(audio).on("ended", function () {
        track_i++;
        if (track_i === $(".track-item").length) {
            track_i = 0;
        }
        canplay = false;

        getTrack(track_i);
    });

    function getTrack (i) {
        $.get("../loadtrack/index.php", { id: $(".track-item").eq(i).find(".track-play").data("id") }).done(function(data) {
            result = $.parseJSON(data);
            $(".track-album-img").attr("src", result.album_avatar);
            $(".album-container").find(".album-name").val(result.album_name);
            $(".album-container").find(".performer-name").val(result.performer_name);
            $(audio).find("source").attr("src", result.track_source);
            audio.load();
            audio.play();
        });
    }

    $(".track-progress")
    .on("mousedown", function () {
        mouseDown = true;
    })
    .on("mousemove", function (event) {
        if (mouseDown) {
            percent = event.originalEvent.offsetX / $(this).width() * 100;
            if (percent >= 0 && percent <= 100) {
                audio.currentTime = audio.duration * (percent / 100);
            }
        }
    })
    .on("mouseup", function (event) {
        percent = event.originalEvent.offsetX / $(this).width() * 100;
        if (percent >= 0 && percent <= 100) {
            audio.currentTime = audio.duration * (percent / 100);
        }
    });

    $(".volume-value")
    .on("mousedown", function () {
        mouseDown = true;
    })
    .on("mousemove", function (event) {
        if (mouseDown) {
            percent = event.originalEvent.offsetX / $(this).width() * 100;
            if (percent >= 0 && percent <= 100) {
                audio.volume = percent / 100;
                $(this).attr("value", audio.volume);
            }
        }
    })
    .on("mouseup", function (event) {
        percent = event.originalEvent.offsetX / $(this).width() * 100;
        if (percent >= 0 && percent <= 100) {
            audio.volume = percent / 100;
            $(this).attr("value", audio.volume);
        }
    });

    $(document).on("mouseup", function () {
        mouseDown = false;
    });

    $(".genre-item").hover(function () {   
            $(this).find(".subgenre-list").slideDown(1000);    
        }, 
        function () {
            $(this).find(".subgenre-list").stop(true);
            $(this).find(".subgenre-list").slideUp(1000); 
        }
    );

    $(".track-item").hover(function () {   
        $(this).find(".track-status").hide();
        $(this).find(".track-duration").hide();
        $(this).find(".track-play").show();  
        $(this).find(".track-like").show();  
    }, 
    function () {
        $(this).find(".track-status").stop(true);
        $(this).find(".track-play").stop(true);
        $(this).find(".track-play").hide(); 
        $(this).find(".track-like").hide();
        $(this).find(".track-status").show();
        $(this).find(".track-duration").show();
    });

    $(".album-item").hover(function () {
        $(this).find(".album-like").slideDown(1000);   
    }, 
    function () {
        $(this).find(".album-like").stop(true);
        $(this).find(".album-like").slideUp(100); 
    });

    $(".performer-item").hover(function () {
        $(this).find(".performer-like").slideDown(1000);
    }, 
    function () {
        $(this).find(".performer-like").stop(true);
        $(this).find(".performer-like").slideUp(100); 
    });

    $(".track-play").click(function () {
        if (track_i !== $(this).parent(".track-item").index()) {
            track_i = $(this).parent(".track-item").index();
            console.log(track_i);
            getTrack(track_i);
        } 

        if (!audio.paused) {
            audio.pause();
        } else {
            audio.play();
        }
    });

    $(".search-button").click(function () {
        document.location.href = "../search/?text=" + $(".search-input").val();
    });

    $(".subgenre-item").click(function () {
        let genre = $(this).parent(".subgenre-list").parent(".genre-item").children(".genre-title").text();
        let subgenre = $(this).text();
        if (subgenre.indexOf(genre) == -1) {
            document.location.href = "../search/?genre=" + subgenre + " " + genre;
        } else {
            document.location.href = "../search/?genre=" + subgenre;
        }
    });

    $(".track-item").each(function () {
        if ($(this).find(".track-like").data("fav") == '')
            $(this).find(".track-like").data("fav", 0);

        if ($(this).find(".track-like").data("fav") == 0) {
            $(this).find(".track-like").css("background", "url(../images/non-like.png) no-repeat center/contain");
        } else {
            $(this).find(".track-like").css("background", "url(../images/like.png) no-repeat center/contain");
        }
    });

    $(".track-like").click(function () {
        $this = $(this);
        $.get("../like/tracks.php", { id: $(this).data("id"), fav: $(this).data("fav") }).done(function(data) {
            result = $.parseJSON(data);
            if (result.favourite == 0) {
                $this.data("fav", 0);
                $this.css("background", "url(../images/non-like.png) no-repeat center/contain");
            } else {
                $this.data("fav", 1);
                $this.css("background", "url(../images/like.png) no-repeat center/contain");
            }
        });
    });

    $(".album-item").each(function (){
        if ($(this).find(".album-like").data("fav") == '')
            $(this).find(".album-like").data("fav", 0);

        if ($(this).find(".album-like").data("fav") == 0) {
            $(this).find(".album-like").css("background", "url(../images/non-like.png) no-repeat center/contain");
        } else {
            $(this).find(".album-like").css("background", "url(../images/like.png) no-repeat center/contain");
        }
    });

    $(".album-like").click(function () {
        $this = $(this);
        $.get("../like/albums.php", { id: $(this).data("id"), fav: $(this).data("fav") }).done(function(data) {
            result = $.parseJSON(data);
            if (result.favourite == 0) {
                $this.data("fav", 0);
                $this.css("background", "url(../images/non-like.png) no-repeat center/contain");
            } else {
                $this.data("fav", 1);
                $this.css("background", "url(../images/like.png) no-repeat center/contain");
            }
        });
    });

    $(".performer-item").each(function (){
        if ($(this).find(".performer-like").data("fav") == 0) {
            $(this).find(".performer-like").css("background", "url(../images/non-like.png) no-repeat center/contain");
        } else {
            $(this).find(".performer-like").css("background", "url(../images/like.png) no-repeat center/contain");
        }
    });

    $(".performer-like").click(function () {
        $this = $(this);
        $.get("../like/performers.php", { id: $(this).data("id"), fav: $(this).data("fav") }).done(function(data) {
            result = $.parseJSON(data);
            if (result.favourite == 0) {
                $this.data("fav", 0);
                $this.css("background", "url(../images/non-like.png) no-repeat center/contain");
            } else {
                $this.data("fav", 1);
                $this.css("background", "url(../images/like.png) no-repeat center/contain");
            }
        });
    });

    $(".login-button").click(function (event) {
        event.preventDefault();

        $('input').removeClass('error');

        let email = $("input[name='email']").val(),
            password = $("input[name='password']").val();
        
        $.ajax({
            url: "login.php",
            type: "POST", 
            dataType: "json",
            data: {
                email: email, 
                password: password
            }, 
            success (data) {

                if (data.status === true) {
                    document.location.href = "index.php";
                }
                else {

                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name="${field}"]`).addClass('error');
                        });
                    }

                    $(".message").fadeIn(500).text(data.message);
                }
            }
        });
    });

    $('input[name="avatar"]').change(function (event) {
        avatar = event.target.files[0];
    });

    $(".register-button").click(function (event) {
        event.preventDefault();
    
        $('input').removeClass('error');
        $('select').removeClass('error');
    
        let name = $('input[name="name"]').val(),
            password = $('input[name="password"]').val(),
            email = $('input[name="email"]').val(),
            gender = $('select[name="gender"]').val(),
            birthdate = $('input[name="birthdate"]').val(),
            location = $('select[name="location"]').val();
    
        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('gender', gender);
        formData.append('birthdate', birthdate);
        formData.append('location', location);
        formData.append('avatar', avatar);
    
    
        $.ajax({
            url: 'signup.php',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success (data) {
    
                if (data.status === true) {
                    document.location.href = 'auth.php';
                } 
                else {
    
                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name="${field}"]`).addClass('error');
                            $(`select[name="${field}"]`).addClass('error');
                        });
                    }
    
                    $(".message").fadeIn(500).text(data.message);
                }
    
            }
        });
    
    });

});