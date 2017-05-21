"use strict";

function delete_contact(id) {
    $.ajax({
        url: 'api/users/' + id,
        type: 'DELETE',
    })
}

