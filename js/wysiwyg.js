(($) => {
    const mdToHtml = new showdown.Converter();

    $(document).on('ready', () => {
        const $input = $('#wysiwyg-in');
        const inputText = $input.text();
        const inputHtml = mdToHtml.makeHtml(inputText);

        const $editor = $('#wysiwyg-editor');

        $editor
            .trumbowyg({
                btns: [
                    ['viewHTML'],
                    ['formatting'],
                    'btnGrp-semantic',
                    'preformatted',
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    'btnGrp-justify',
                    'btnGrp-lists',
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen'],
                ],
                autogrow: true,
                removeformatPasted: true,
                svgPath: '/user/plugins/admin-wysiwyg/css-compiled/icons.svg',
            })
            .on('tbwchange', e => {
                console.log(e);
                $input.text(toMarkdown(e.target.value))
            });

        // Setup the editor block with the parsed Markdown
        $editor.trumbowyg('html', inputHtml);
    });
})(jQuery);
