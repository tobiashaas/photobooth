const style = document.documentElement.style;

style.setProperty('--primary-color', config.colors.primary);
style.setProperty('--secondary-color', config.colors.secondary);
style.setProperty('--font-color', config.colors.font);

if (config.color_theme === 'blue-gray') {
    $('#wrapper').addClass('bluegray-bg');
}

if (config.color_theme === 'yellow') {
    $('#wrapper').addClass('yellow-bg');
}

$(function () {
    $('#wrapper').show();
});
