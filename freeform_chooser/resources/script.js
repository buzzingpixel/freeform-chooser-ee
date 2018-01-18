function runFreeformChooser() {
    'use strict';

    if (! window.Grid || ! window.FluidField) {
        setTimeout(function() {
            runFreeformChooser();
        }, 10);
        return;
    }

    window.Grid.bind('freeform_chooser', 'display', function($cell) {
        var $blocksContent = $cell.closest('.blocksft-content');
        var $tblWrap = $cell.closest('.tbl-wrap');

        window.Dropdown.renderFields($cell);

        if ($blocksContent.length) {
            $blocksContent.css('overflow', 'visible');
        }

        if ($tblWrap.length) {
            $tblWrap.css('overflow', 'visible');
        }
    });

    window.FluidField.on('freeform_chooser', 'add', function($row) {
        window.Dropdown.renderFields($row);
    });
}

runFreeformChooser();
