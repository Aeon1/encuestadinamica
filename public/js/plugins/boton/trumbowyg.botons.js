(function ($) {
    'use strict';

    // Plugin default options
    var defaultOptions = {
    };

    // If the plugin is a button
    function buildButtonDef (trumbowyg) {
        return {
            fn: function () {
                let ctx = $('#contexto').val();
                trumbowyg.execCmd('insertHTML', "<button onclick="+'"'+"window.open('"+ctx+"/Encuesta', '_self')"+'"'+" class='btn btn-lg btn-primary'> Iniciar encuesta</button>");
            }
        }
    }

    // If the plugin is a button
    function buildButtonIcon() {
        if ($("#trumbowyg-myplugin").length > 0) {
            return;
        }
        const iconWrap = $(document.createElementNS("http://www.w3.org/2000/svg", "svg"));
        iconWrap.addClass("trumbowyg-icons");

        // For demonstration purposes, we've taken the "File" icon from
        // Remix Icon - https://remixicon.com/
        iconWrap.html(`
            <symbol id="trumbowyg-myplugin" viewBox="0 0 15 15">
            <path d="M5.5 10V8.5M5.5 8.5V3.5C5.5 2.94772 5.94772 2.5 6.5 2.5C7.05228 2.5 7.5 2.94772 7.5 3.5V7.5H10.8529C11.7626 7.5 12.5 8.23741 12.5 9.14706V10C12.5 12.4853 10.4853 14.5 8 14.5H7.5C5.29086 14.5 3.5 12.7091 3.5 10.5C3.5 9.39543 4.39543 8.5 5.5 8.5ZM9 5.5H11C12.3807 5.5 13.5 4.38071 13.5 3C13.5 1.61929 12.3807 0.5 11 0.5H4C2.61929 0.5 1.5 1.61929 1.5 3C1.5 4.38071 2.61929 5.5 4 5.5" stroke="#000000"/>
            </symbol>
        `).appendTo(document.body);
    }


    $.extend(true, $.trumbowyg, {
        // Add some translations
        langs: {
            es: {
                myplugin: 'Boton de inicio de encuesta'
            }
        },
        // Register plugin in Trumbowyg
        plugins: {
            myplugin: {
                // Code called by Trumbowyg core to register the plugin
                init: function (trumbowyg) {
                    // Fill current Trumbowyg instance with the plugin default options
                    trumbowyg.o.plugins.myplugin = $.extend(true, {},
                        defaultOptions,
                        trumbowyg.o.plugins.myplugin || {}
                    );

                    // If the plugin is a paste handler, register it
                    trumbowyg.pasteHandlers.push(function(pasteEvent) {
                        // My plugin paste logic
                    });

                    // If the plugin is a button
                    buildButtonIcon();
                    trumbowyg.addBtnDef('myplugin', buildButtonDef(trumbowyg));
                },
                // Return a list of button names which are active on current element
                tagHandler: function (element, trumbowyg) {
                    return [];
                },
                destroy: function (trumbowyg) {
                }
            }
        }
    })
})(jQuery);