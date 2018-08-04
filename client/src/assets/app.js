let $ = require("jquery");
//let bs = require("bootstrap");

let connected = false;
const api_url = 'http://localhost:8000';

$(".close").on('click', () => {
    $(".close").alert('close');
});

if (localStorage.getItem('sessionToken') !== null) {
    connected = true;
}

if (connected) {
    $('.menu').html('<li class="nav-item">\n' +
        '                    <a class="nav-link" id="logout-link" href="/logout">Log out</a>\n' +
        '                </li>');

    $('#logout-link').click((e) => {
        e.preventDefault();

        sendRequest('POST', '/logout', null, function (res) {
            localStorage.removeItem('sessionToken');
            window.location.pathname = '/';
        });
    });
}

function sendRequest(method, url, data, callback) {
    let request = new XMLHttpRequest();
    request.open(method, api_url + url);
    request.setRequestHeader("Content-Type", "application/json");
    request.setRequestHeader('Accept', 'application/json');
    if (localStorage.getItem('sessionToken') !== undefined) {
        request.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('sessionToken'));
    }
    request.responseType = 'json';
    request.onload = function () {
        if (callback) callback(request.response);
    };
    request.send(JSON.stringify(data));
}

function setAdvert(message) {
    $('#advert').html('<div class="alert alert-primary alert-dismissible fade show" role="alert">\n' +
        '        ' + message +
        '        <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '            <span aria-hidden="true">&times;</span>\n' +
        '        </button>\n' +
        '    </div>');
}

function refreshTaskList() {
    sendRequest('GET', '/tasks', null, function (response) {
        $('.task-list').html('');

        response.data.forEach(function (task) {
            let status = 'Open';

            if (task.status === "0") {
                status = 'Closed';
            }

            $('.task-list').append('<div class="media text-muted pt-3">\n' +
                '            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">\n' +
                '                <div class="d-flex justify-content-between align-items-center w-100">\n' +
                '                    <a href="/task/' + task.id + '"><strong class="text-gray-dark">' + task.title + '</strong></a>\n' +
                '                    <span class="badge badge-pill badge-primary">' + status + '</span>\n' +
                '                </div>\n' +
                '                <spadatan class="d-block">' + task.description + '</spadatan>\n' +
                '            </div>\n' +
                '        </div>');
        });
    });
}

if (connected) {
    $('#createTaskForm').html('<div class="my-3 p-3 bg-white rounded box-shadow">\n' +
        '            <form>\n' +
        '                <div class="form-group">\n' +
        '                    <label for="title">Title</label>\n' +
        '                    <input type="text" name="title" id="title" class="form-control">\n' +
        '                </div>\n' +
        '                <div class="form-group">\n' +
        '                    <label for="description">Description</label>\n' +
        '                    <textarea name="description" id="description" class="form-control"></textarea>\n' +
        '                </div>\n' +
        '\n' +
        '                <button type="submit" id="createTask" class="btn btn-success">Create task</button>\n' +
        '            </form>\n' +
        '        </div>');
}

$('#createTask').click(function (e) {
    e.preventDefault();

    sendRequest('POST', '/tasks', {
        title: $("#title")[0].value,
        description: $("#description")[0].value
    }, function (data) {
        setAdvert(data.message);
        refreshTaskList();
    });
});

refreshTaskList();

$('#signin').click(function (e) {
    e.preventDefault();

    sendRequest('POST', '/auth', {
        username: $('#username')[0].value,
        password: $('#password')[0].value
    }, function (res) {
        if (res.data.token !== undefined) {
            localStorage.setItem('sessionToken', res.data.token);
            window.location.pathname = '/';
        } else {
            setAdvert(res.message);
        }
    });
});

$('#register').click(function (e) {
    e.preventDefault();

    sendRequest('POST', '/signup', {
        username: $('#username')[0].value,
        password: $('#password')[0].value,
        email: $('#email')[0].value
    }, function (res) {
        setAdvert(res.message);
    });
});