window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const papa_stockzen = document.getElementById('papa_stockzen');
    if (papa_stockzen) {
        new simpleDatatables.DataTable(papa_stockzen);
    }
});
