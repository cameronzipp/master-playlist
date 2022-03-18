/**
 * Creates the DataTable and dynamically updates the DataTable through Ajax
 */

function handleApi() {
    $('button').click(function (event) {
        const isSearchPage = window.location.pathname.endsWith("/search")
        const target = event.target;
        const path = event.target.getAttribute('data-path');
        $.ajax(path).done(function () {
            if (target.innerText === "Add") {
                event.target.innerText = "Remove";
                event.target.setAttribute('data-path', path.replace('add', 'remove'));
            } else {
                if (!isSearchPage) {
                    const table = $('#songData').DataTable();
                    table.ajax.reload(handleApi, false);
                } else {
                    event.target.innerText = "Add";
                    event.target.setAttribute('data-path', path.replace('remove', 'add'));
                }
            }
        });
    });
}

$(document).ready(function () {
    const isSearchPage = window.location.pathname.endsWith("/search");
    $('#songData').DataTable({
    searching: isSearchPage,
    lengthChange: false,
        ajax: './ajax',
        stateSave: true,
        initComplete: handleApi
});
})