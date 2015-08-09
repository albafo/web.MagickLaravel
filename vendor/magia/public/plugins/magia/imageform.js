/**
 * Created by alvarobanofos on 02/08/15.
 */

$.widget("magia.imageform", {

    //Default options
    options : {
        noImageSrc: '',
        firstImageSrc: null,
        imgDOM:null,
        hiddenDeleteDOM: null
    },
    _create: function() {
        var imgDom = this.options.imgDOM;

        if(imgDom != null) {
            this.options.firstImage = imgDom.attr('src');
        }

    },

    reset: function() {
        if(this.options.imgDOM != null && this.options.firstImageSrc != null) {
            this.options.imgDOM.attr('src', this.options.firstImageSrc);
        }

        if(this.options.hiddenDeleteDOM != null){
            this.options.hiddenDeleteDOM.val(0);
        }

        this.element.val('');
        this._trigger("onImgUpdate");

    },

    imageSrc: function(src) {
        if(this.options.imgDOM != null) {
            this.options.imgDOM.attr('src', src);
            console.log(this.options.imgDOM);
        }
        this._trigger("onImgUpdate");
    },

    remove: function() {
        if(this.options.hiddenDeleteDOM != null){
            this.options.hiddenDeleteDOM.val(1);
        }
        this.options.imgDOM.attr('src', this.options.noImageSrc);
    },

    eventToImage: function(event) {
        var files = event.target.files;
        var thisContext = this;
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    thisContext.imageSrc(e.target.result);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }
});