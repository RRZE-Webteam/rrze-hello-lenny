(function (blocks, element) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType("lenny/quote-block", {
        title: wp.i18n.__("Lenny Quote", "rrze-hello-lenny"),
        icon: "format-quote",
        category: "widgets",
        edit: function () {
            return el(
                "blockquote",
                { className: "rrze-hello-lenny shortcode", lang: "de" },
                el(
                    "p",
                    {},
                    el(
                        "span",
                        { className: "wuff-ucfirst" },
                        wp.i18n.__("Wuff!", "rrze-hello-lenny")
                    ),
                    " ",
                    el(
                        "span",
                        { className: "wuff-ucfirst wuff-uppercase" },
                        wp.i18n.__("Wuff!", "rrze-hello-lenny")
                    )
                ),
                el("cite", {}, "🐶 Lenny")
            );
        },
        save: function () {
            return null; // Rendered in PHP on the frontend
        },
    });
})(window.wp.blocks, window.wp.element);
