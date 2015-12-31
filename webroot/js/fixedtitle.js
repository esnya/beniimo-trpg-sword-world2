$(function () {
    $(".fixed-title").each(function (index, element){
        var title = $(element);

        var listener = function() {
            var offset = this.data("offset");
            if (this.data("fixed")) {
                if (this.data("fixed").offset().top < this.offset().top) {
                    var fixed = this.data("fixed");
                    fixed.remove();
                    this.data("fixed", null);
                }
            } else {
                if ($(window).scrollTop() >= this.offset().top - offset) {
                    var fixed = this.clone();
                    fixed.css("background", "white");
                    fixed.css("z-index", "1");
                    fixed.css("position", "fixed");
                    fixed.css("top", offset + "px");
                    fixed.css("left", "0px");
                    fixed.css("right", "0px");
                    $("body").append(fixed);
                    this.data("fixed", fixed);
                }
            }
        }.bind(title);

        listener();
        $(window).scroll(listener);
    });
});
