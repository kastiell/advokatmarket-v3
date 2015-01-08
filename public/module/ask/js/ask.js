/**
 * Created by kasu on 10.02.14.
 */

window.FORM = {};
window.FORM.DATA = [];

FORM.callStep = function(form,data,hasError){
    console.log(form,data,hasError);
    console.log($(form).attr('id'));
    if(!hasError){
        var id = $(form).attr('id');
        var step = parseInt(id.split('-')[1]);
        window.FORM.callStep.callObj[step](form,step);
    }
}