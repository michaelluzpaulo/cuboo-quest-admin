//-----------------------------------------------//
// CHECKBOX
//-----------------------------------------------//

$.fn.check = function () {
    return this.each(function () {
        this.checked = true;
    });
};

$.fn.uncheck = function () {
    return this.each(function () {
        this.checked = false;
    });
};

$.fn.toogleCheck = function () {
    return this.each(function () {
        this.checked = !this.checked;
    });
};

$.fn.checked = function () {
    if (this.attr('checked') == true)
        return true;
    else
        return false;
};