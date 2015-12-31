"use strict";
(function () {
    $(function() {
        $(".rader").each(function (index, canvas) {
            var context = canvas.getContext('2d');

            var headers = $($(canvas).data("header")).map(function (index, element) {
                return element.innerHTML;
            });
            var values = $($(canvas).data("target")).map(function (index, element) {
                return element.innerHTML;
            });

            var count = values.length;
            var r = Math.min(canvas.width, canvas.height) / 2 - 10;

            context.strokeStyle = 'lightgray';
            context.textAlign = 'center';
            context.textBaseline = 'middle';

            for (var i = 0; i < count; ++i) {
                context.beginPath();
                context.moveTo(canvas.width / 2, canvas.height / 2);

                var a = 2 * Math.PI / count * i;

                context.lineTo(canvas.width / 2 + Math.sin(a) * r, canvas.height / 2 - Math.cos(a) * r);
                context.closePath();
                context.stroke();

                context.fillText(headers[i], canvas.width / 2 + Math.sin(a) * (r + 5), canvas.height / 2 - Math.cos(a) * (r + 5));
            }

            var step = 6;

            //var max = 0;
            //for (var i = 0; i < count; ++i) {
            //    max = Math.max(max, values[i]);
            //}
            //max = max - max % step + step;
            var max = 10 * 6;

            for (var i = step; i <= max; i += step) {
                var t = r / max * i;

                if (i % 5 == 0) {
                    context.beginPath();
                    context.moveTo(canvas.width / 2, canvas.height / 2 - t);
                    for (var j = 0; j < count; ++j) {
                        var a = 2 * Math.PI / count * j;
                        context.lineTo(canvas.width / 2 + Math.sin(a) * t, canvas.height / 2 - Math.cos(a) * t);
                    }
                    context.closePath();
                    context.stroke();
                } else {
                    for (var j = 0; j < count; ++j) {
                        var a = 2 * Math.PI / count * j;
                        var x = canvas.width / 2 + Math.sin(a) * t;
                        var y = canvas.height / 2 - Math.cos(a) * t;
                        context.beginPath();
                        context.moveTo(x + Math.cos(a) * 5, y + Math.sin(a) * 5);
                        context.lineTo(x - Math.cos(a) * 5, y - Math.sin(a) * 5);
                        context.closePath();
                        context.stroke();
                    }
                }
            }

            /*
               for (var i = step; i < max; i += step) {
               context.beginPath();
               var t = r / max * i;
               context.moveTo(canvas.width / 2, canvas.height / 2 + t);
               for (var j = 0; j < count; ++j) {
               var a = 2 * Math.PI / count * j;
               context.lineTo(canvas.width / 2 + Math.sin(a) * t, canvas.height / 2 + Math.cos(a) * t);
               }
               context.closePath();
               context.stroke();
               }
               */

            context.strokeStyle='rgba(66, 139, 202, 1.0)';
            context.fillStyle='rgba(91, 192, 222, 0.7)';
            context.beginPath();
            for (var i = 0; i <= count; ++i) {
                var j = i % count;

                var t = r / max * values[j];
                var a = 2 * Math.PI / count * j;

                var x = canvas.width / 2 + Math.sin(a) * t;
                var y = canvas.height / 2 - Math.cos(a) * t;

                if (i == 0) {
                    context.moveTo(x, y);
                } else {
                    context.lineTo(x, y);
                }

            }
            context.closePath();
            context.fill();
            context.stroke();
        });
    });
})();
