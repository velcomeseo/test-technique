$(document).ready(function() {
    $('#dialog').dialog({
        dialogClass: "no-close",
        modal: true,
        title: 'Bienvenue sur notre site',
        buttons: [
            {
                text: "OK",
                click: function() {
                    $(this).dialog("close");
                }
            },
            {
                text: "Non merci",
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    })
})