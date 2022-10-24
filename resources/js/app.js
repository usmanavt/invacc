import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


//  For Setting Dates
function setDateToToday(element)
{
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    element.setAttribute("min",today);
    //  LearnMore - https://stackoverflow.com/questions/12346381/set-date-in-input-type-date?answertab=active#tab-top
}
