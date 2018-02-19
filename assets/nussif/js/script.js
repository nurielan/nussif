$(document).ready(function () {
    $('.sidebar-menu').tree();

    function getCsrf() {
        var csrf = null;

        csrf = $.getJSON(siteUrl + 'admin/user/getCsrf', {}, function (data) {
            return data;
        });

        return csrf;
    }

    var anchorMethod = $('#anchorMethod');

    anchorMethod.click(function () {
        if ($(this).data('method') == 'POST') {
            csrf = getCsrf();
            csrfTokenName = csrf.name;
            csrfTokenHash = Cookies.get(csrfTokenName);
            csrfToken = {csrfTokenName: csrfTokenHash};

            $.ajax({
                //headers: csrfToken,
                url: $(this).data('href'),
                type: 'POST',
                dataType: 'json',
                //data: csrfToken,
                context: this,
                success: function (result, status, xhr) {
                    alert(status);
                },
                error: function (xhr, status, error) {
                    alert(xhr.text + ' ' + xhr.statusText);
                }
            });
        }

        return false;
    });
});