function block(ele) {
    $(ele).block({ message: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'});
}

function unblock(ele) {
    $(ele).unblock();
}


function success(msg){
    toastr.success(msg);
}

function error(msg){
    toastr.error(msg);
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


