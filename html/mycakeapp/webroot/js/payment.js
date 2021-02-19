$(window).on('load', () => {
    const usePoint = $('input[name="use_point"]');
    const changePointDisplayBySelect = () => {
        if ($('select').val() === 'no_use_point') {
            $('input[name="use_point"]').remove();
        }
        if ($('select').val() === 'use_all_points') {
            usePoint.insertAfter('select');
            const useAllPoints = $('input[name="use_point"]').data('useallpoints');
            $('input[name="use_point"]').val(useAllPoints);
        }
        if ($('select').val() === 'use_some_points') {
            usePoint.insertAfter('select');
            $('input[name="use_point"]').val('');
        }
    };
    changePointDisplayBySelect();
    $('select').on('change', changePointDisplayBySelect);
});
