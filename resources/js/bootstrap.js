require('alpinejs');
const qs = require('qs')

window.sorter = function (sortElement) {
    if (!sortElement) {
        return;
    }
    const name = sortElement.getAttribute('name');
    const value = sortElement.value;
    const location = window.location;
    const search = qs.parse(location.search, {
        ignoreQueryPrefix: true
    });
    // add new query param
    search[name] = value;
    window.location.href = `${location.origin}${location.pathname}?${qs.stringify(search)}`;
}
