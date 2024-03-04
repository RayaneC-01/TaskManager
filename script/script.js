document.getElementById('due_date_select').addEventListener('change', function () {
    var customDateInput = document.getElementById('custom_due_date');
    if (this.value === 'choose_date') {
        customDateInput.style.display = 'block';
    } else {
        customDateInput.style.display = 'none';
    }
});
