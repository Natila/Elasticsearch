$.widget("custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
        this._super();
        this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
    },
    _renderMenu: function(ul, items) {
        var that = this;
        var ws_count = 0;
        var rp_count = 0;
        var sg_count = 0;
        var ca_count = 0;
        $.each(items, function(index, item) {
            var li;

            if (item.status == 'ws' && ws_count == 0) {
                ul.append("<li class='ui-autocomplete-category' style='padding:5px;'><b>Did you mean...</b></li>");
                ws_count++;
            }
            if (item.status == 'rp' && rp_count == 0) {
                ul.append("<li class='ui-autocomplete-category' style='padding:5px;'><b>Related Products</b></li>");
                rp_count++;
            }
            if (item.status == 'sg' && sg_count == 0) {
                ul.append("<li class='ui-autocomplete-category' style='padding:5px;'><b>Suggestion Products</b></li>");
                sg_count++;
            }
            if (item.status == 'ca' && ca_count == 0) {
                ul.append("<li class='ui-autocomplete-category' style='padding:5px;'><b>Related Categories</b></li>");
                ca_count++;
            }

            li = that._renderItemData(ul, item);
        });
    },
    _renderItem: function(ul, item) {
        console.log (item);
        if (item.status == 'rp') {
            return $("<li>")
                .append('<span><img style="width:50px;height:auto;margin-right:20px;" src="' + item.ImgUrl + '" /></span>')

                .attr('style', 'padding-left: 30px;')
                .attr('data-status', item.status)
                // .addClass(item.value)
                .attr("data-value", item.value)
                .append($("<a>")
                    .text('' + item.label))
                .appendTo(ul);
        } else {
            return $("<li>")
                .attr('style', 'padding-left: 30px;')
                .attr('data-status', item.status)
                // .addClass(item.value)
                .attr("data-value", item.value)
                .append($("<a>")
                    .text('' + item.label))
                .appendTo(ul);
        }
    }

});

$(function() {
    $('#search_suggestion').catcomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                url: 'home_demo/search',
                dataType: 'json',
                data: {
                    term: request.term
                },
                success: function (data) {
                    response ($.map(data, function(item) {
                        return item;
                    }));
                }
            });
        },
        select: function( event, ui ) {
            // console.log(ui);
            // shop_id
            if ($('select[name=shop_id]').val() == undefined) {
                $shop_id = '';
            }
            else {
                $shop_id = $('select[name=shop_id]').val();
            }
            // languages
            if($($('#lang').val() == undefined)) {
                $lang = 'th';
            }
            else {
                $lang = $('#lang').val();
            }
            // page size
            if($($('#select_page_size').val() == undefined)) {
                $page_size = 12;
            }
            else {
                $page_size = $('#select_page_size').val();
            }

            if(ui.item.status == 'ca') {
                location.href = "?q=" + $('#search_suggestion').val() +
                    "&cate=" + termEncode(ui.item.value)  +
                    '&shop_id=' + $shop_id +
                    '&lang=' + $lang;
                return false;
            } else if (ui.item.status == 'rp' || ui.item.status == 'ws' || ui.item.status == 'sg') {
                location.href = "?q=" + ui.item.value +
                    '&shop_id=' + $shop_id +
                    '&lang=' + $lang;
            }
        },
        focus: function(event, ui) {
            return false;
        }
    });
})
