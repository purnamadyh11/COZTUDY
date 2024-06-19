$(function () {
    const table = $('.table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/rating',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user', name: 'user' },
            { data: 'place', name: 'place' },
            { data: 'rating_star', name: 'rating_star' },
        ]
    });
});