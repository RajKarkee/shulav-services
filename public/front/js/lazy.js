var lazy={
    observer:null,
    has:false,
    init:function (selector) {
        lazy.has=('IntersectionObserver' in window);
        if(lazy.has){
            lazy.observer = new IntersectionObserver(lazy.callback, {});
            lazy.initLazyLoading(selector);
        }else{
            lazy.initLazyLoading(selector);
        }
    },
    initLazyLoading:(selector)=>{
        if(lazy.has){

            document.querySelectorAll(selector).forEach(ele => {
                lazy.observer.observe(ele);
            });
        }else{
            document.querySelectorAll(selector).forEach(ele => {
                ele.src = ele.dataset.src;
            });
        }
    },
    callback :(entries, observer) => {
        entries.forEach(entry => {
            if( entry.isIntersecting){
                let lazyImage = entry.target;
                lazyImage.src = lazyImage.dataset.src;
                observer.unobserve(lazyImage);
            }
        });
    }
};

