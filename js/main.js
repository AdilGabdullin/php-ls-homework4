function registrationSubmit() {
    var fd = new FormData;
    fd.append('login', $("#reg-login").val());
    fd.append('password1', $("#reg-pass").val());
    fd.append('password2', $("#reg-pass-repeat").val());
    fd.append('name', $("#reg-name").val());
    fd.append('age', $("#reg-age").val());
    fd.append('description', $("#reg-description").val());
    fd.append('img', $("#reg-photo").prop('files')[0]);
    $.ajax({
        type: 'POST',
        url: '/php/registration.php',
        processData: false,
        contentType: false,
        data: fd,
        success: function (data) {
            alert(data);
        }
    });
}

function authorizationSubmit() {
    var fd = new FormData;
    fd.append('login', $('#auth-login').val());
    fd.append('password', $('#auth-password').val());
    $.ajax({
        type: 'POST',
        url: '/php/authorization.php',
        processData: false,
        contentType: false,
        data: fd,
        success: function (data) {
            alert(data);
        }
    });
}

function ViewListOfUsers() {
    $.ajax({
        url: '/php/list.php',
        success: function (data) {
            if (data === '') {
                alert('Нет доступа');
            } else {
                var json = JSON.parse(data);
                for (var i = 0; i < json.length; i++) {
                    var rows = $('<tr></tr>')
                        .append('<td>' + json[i].login + '</td>')
                        .append('<td>' + json[i].name + '</td>')
                        .append('<td>' + json[i].age + '</td>')
                        .append('<td>' + json[i].description + '</td>')
                        .append('<td><img src="/photos/' + json[i].photo + '" height="100"></td>')
                        .append('<td><a href="/php/deleteuser.php?delete=' +
                            json[i].id + '">Удалить пользователя</a></td>');
                    $('#users').append(rows);
                }
            }
        }
    })
}

function ViewListOfFiles() {
    $.ajax({
        url: '/php/filelist.php',
        success: function (data) {
            if (data === '') {
                alert('Нет доступа');
            } else {
                var json = JSON.parse(data);
                for (var i = 0; i < json.length; i++) {
                    var x = json[i].photo;
                    var rows = $('<tr></tr>')
                        .append('<td>' + x + '</td>')
                        .append('<td><img src="/photos/' + x + '" height="200"></td>')
                        .append('<td><a href="/php/deleteimage.php?delete=' +
                            x + '">Удалить аватарку пользователя</a></td>');
                    $('#avatars').append(rows);
                }
            }
        }
    })
}