"use strict";

$("#new_contact").on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: 'api/users',
        type: 'POST',
        data: $(this.elements).serialize(),
        success : ({id, first_name, last_name, email, phone}) => {
            let actions = '<td id="actions"><a href="">' +
                '<span class="glyphicon glyphicon-pencil" aria-hidden="true" onclick="edit_contact('+ id +')">' +
                '</span></a><a href=""><span class="glyphicon glyphicon-trash" aria-hidden="true" onclick="delete_contact('+ id +')">' +
                '</span></a></td>';

            let name = "<td class='first_name'>" + first_name + "</td>";
            let surname = "<td class='last_name'>" + last_name + "</td>";
            let mail = "<td class='email'>" + email + "</td>";
            let tel = "<td class='phone'>" + phone + "</td>";

            $('tbody').append("<tr id=" + id + ">" + name + surname + mail + tel + actions + "</tr>");
        }
    });

    // $( "#new_contact" ).css('display', 'none');
});
