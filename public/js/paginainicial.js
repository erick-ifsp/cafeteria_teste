document.getElementById('sidebarToggle').addEventListener('click', function () {
    var sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
    document.body.classList.toggle('no-scroll', sidebar.classList.contains('active'));
});