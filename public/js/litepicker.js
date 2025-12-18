// Litepicker
// 
// The date pickers in Material Admin Pro
// are powered by the Litepicker plugin.
// Litepicker is a lightweight, no dependencies
// date picker that allows for date ranges
// and other options. For more usage details
// visit the Litepicker docs.
// 
// Litepicker Documentation
// https://wakirin.github.io/Litepicker

window.addEventListener('DOMContentLoaded', event => {

    const litepickerSingleDate = document.getElementById('litepickerSingleDate');
    if (litepickerSingleDate) {
        new Litepicker({
            element: litepickerSingleDate,
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerDateRange = document.getElementById('litepickerDateRange');
    if (litepickerDateRange) {
        new Litepicker({
            element: litepickerDateRange,
            singleMode: false,
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerDateRange2 = document.getElementById('litepickerDateRange2');
    if (litepickerDateRange2) {
        new Litepicker({
            element: litepickerDateRange2,
            singleMode: false,
            format: 'MMM DD, YYYY',
            numberOfMonths: 2,
            numberOfColumns: 2,
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    // Trigger your observer/validation check
                    const button = document.getElementById('generateReport');
                    if(button) button.disabled = false;
                });
            }
        });
    }

    const litepickerDateRange3 = document.getElementById('litepickerDateRange3');
    if (litepickerDateRange3) {
        new Litepicker({
            element: litepickerDateRange3,
            singleMode: false,
            format: 'MMM DD, YYYY',
            numberOfMonths: 2,
            numberOfColumns: 2,
        });
    }

    const litepickerDateRange2Months = document.getElementById('litepickerDateRange2Months');
    if (litepickerDateRange2Months) {
        new Litepicker({
            element: litepickerDateRange2Months,
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            format: 'MMM DD, YYYY'
        });
    }

    const litepickerRangePlugin = document.getElementById('litepickerRangePlugin');
    if (litepickerRangePlugin) {
        new Litepicker({
            element: litepickerRangePlugin,
            startDate: new Date(),
            endDate: new Date(),
            singleMode: false,
            numberOfMonths: 2,
            numberOfColumns: 2,
            format: 'MMM DD, YYYY'
        });
    }
});
