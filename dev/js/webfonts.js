// Alternate
//WebFont.load({
//    google: {
//    families: ['Droid Sans', 'Droid Serif', 'Roboto']
//    }
//});

// more info: https://github.com/typekit/webfontloader


WebFontConfig = {
    google: {
        families: ['Droid Sans', 'Open Sans', 'Bitter']
    },
    timeout: 20 // Set the timeout to 20 milliseconds
};
(function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
        '://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();