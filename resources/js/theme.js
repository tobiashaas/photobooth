if (theme === 'bluegray') {
    var style = document.documentElement.style;

    style.setProperty('--primary-color', '#669db3');
    style.setProperty('--secondary-color', '#2e535e');
    style.setProperty('--font-color', '#f0f6f7');

    document.getElementById('wrapper').style.backgroundImage = 'url(resources/img/bg_bluegray.jpg)';
}

if (theme === 'yellow') {
    var style = document.documentElement.style;

    style.setProperty('--primary-color', '#fcff00');
    style.setProperty('--secondary-color', '#2e535e');
    style.setProperty('--font-color', '#f0f6f7');

    document.getElementById('wrapper').style.backgroundImage = 'url(resources/img/bg_yellow.jpg)';
}

$(function() {
    $('#wrapper').show();
});