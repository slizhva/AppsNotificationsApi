document.addEventListener("DOMContentLoaded", function () {
    const $enableDangerousActionForm = $('#enable-dangerous-action-form')
    $enableDangerousActionForm.on('submit', (e) => {
        e.preventDefault()
        const dangerousKey = $enableDangerousActionForm.find("input[name='key']").val()
        $('.dangerous-action-key-value').each((index, el) => {
            $(el).val(dangerousKey)
        })
        $('.dangerous-action-button').removeAttr("disabled")
    });

    const $copyLinkButtons = $('.copyLinkButton')
    if ($copyLinkButtons) {
        navigator.permissions.query({name: "clipboard-write"}).then((result) => {
            if (result.state === "granted" || result.state === "prompt") {
                $copyLinkButtons.on('click', (e) => {
                    const $button = $(e.target)
                    navigator.clipboard.writeText($button.siblings('.copyLinkValue').text())
                    $button.text('Copied!')
                    setTimeout(() => {
                        $button.text('Copy Link')
                    }, 2000)
                })
            } else {
                $copyLinkButtons.on('click', (e) => {
                    const $button = $(e.target)
                    alert($button.siblings('.copyLinkValue').text())
                })
            }
        });
    }

});
