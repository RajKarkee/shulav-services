<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />
<script>
    const galleryelem = document.querySelectorAll('.gallery .item img');
    var index=0;
  
    $(document).ready(function() {
        window.onload=()=>{
            console.log('ma');
            $('#gallery').masonry({
                itemSelector: '.item',
            });
        };
    });

</script>