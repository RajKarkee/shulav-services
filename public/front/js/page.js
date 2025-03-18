function openSidebar() {
    $('#sidebar').addClass('active');
    $('#page-holder').addClass('page-index')
    // $('#mobile-head').addClass('d-none');

}

function closeSidebar(params) {
    $('#sidebar').removeClass('active');
    $('#page-holder').removeClass('page-index')
    // $('#mobile-head').removeClass('d-none');
}

function goToTop() {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    });
}

function template(str,obj){
    var t='';
    console.log(obj);
    i=0;
    for (const key in obj) {
        if (obj.hasOwnProperty.call(obj, key)) {
            const element = obj[key];
            if(i++==0){

                t=str.replaceAll('xxx_'+key,element);
            }else{
                t=t.replaceAll('xxx_'+key,element);

            }
        }
    }
    return t;
}

function strReplaceAll(str,searchArr,replaceArr) {
    var t='';
    for (let index = 0; index < searchArr.length; index++) {
        const search = searchArr[index];
        const replace = replaceArr[index];
        if(index==0){
            t=str.replaceAll(search,replace);
        }else{
            t=t.replaceAll(search,replace);
        }
    }
    return t;
}

function time_ago(time) {

  switch (typeof time) {
    case 'number':
      break;
    case 'string':
      time = +new Date(time);
      break;
    case 'object':
      if (time.constructor === Date) time = time.getTime();
      break;
    default:
      time = +new Date();
  }
  var time_formats = [
    [60, 'seconds', 1], // 60
    [120, '1 minute ago', '1 minute from now'], // 60*2
    [3600, 'minutes', 60], // 60*60, 60
    [7200, '1 hour ago', '1 hour from now'], // 60*60*2
    [86400, 'hours', 3600], // 60*60*24, 60*60
    [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
    [604800, 'days', 86400], // 60*60*24*7, 60*60*24
    [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
    [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
    [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
    [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
    [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
    [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
    [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
    [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
  ];
  var seconds = (+new Date() - time) / 1000,
    token = 'ago',
    list_choice = 1;

  if (seconds == 0) {
    return 'Just now'
  }
  if (seconds < 0) {
    seconds = Math.abs(seconds);
    token = 'from now';
    list_choice = 2;
  }
  var i = 0,
    format;
  while (format = time_formats[i++])
    if (seconds < format[0]) {
      if (typeof format[2] == 'string')
        return format[list_choice];
      else
        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
    }
  return time;
}

$(function() {
    window.onscroll = function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            $('.go-to-top')[0].style.bottom = "10px";
        } else {
            $('.go-to-top')[0].style.bottom = "-50px";
        }
    };
    $('[data-role="open-sidebar"]').click(function (e) {
        e.preventDefault();
        openSidebar();
    });

    $('[data-role="close-sidebar"]').click(function (e) {

        closeSidebar();
    });

    $('.sidebar-link').click(function (e) {
        e.stopPropagation();

    });
});
