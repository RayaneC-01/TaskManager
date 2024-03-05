document.getElementById('due_date_select').addEventListener('change', function () {
    var customDateInput = document.getElementById('custom_due_date');
    if (this.value === 'choose_date') {
        customDateInput.setAttribute('type', 'date');
        customDateInput.style.display = 'block';
        customDateInput.focus();
    } else {
        customDateInput.setAttribute('type', 'text');
        customDateInput.style.display = 'none';
    }
});
