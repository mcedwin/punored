/* variables de habilidades */
(function ($) {
    function box(el) {
        mib = $('<div data-id="' + el.hid + '" class="pb-2 hbox ' + 'mih' + el.hid + '"><input type="hidden" name="mihabi[rid][]" value="' + el.rid + '"><input type="hidden" name="mihabi[hid][]" value="' + el.hid + '"><span>' + el.text + '</span> <a href="#"><i class="fa fa-times"></i></a></div>');
        mib.find('a').click(function () {
            $('.habilidades').find('.mih' + el.hid).prop('checked', false);
            $(this).closest('div').remove();
            return false;
        })
        return mib;
    }

    clickarea = function () {
        $('.areas .area').removeClass('active');
        $(this).addClass('active');
        $.gs_loader.show();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: $(this).attr('href'),
        }).done(function (data) {
            $area = mdlg.find('.habilidades').html(data)

            $area.parent().scrollTop(0);
            boxes = mdlg.find('.boxes .hbox')
            boxes.each(function () {
                $area.find('.mih' + $(this).data('id')).prop('checked', true);
            })

            $area.find('.check').click(function () {
                if ($(this).is(":checked")) {
                    $('.boxes').append(box({ rid: '', hid: $(this).data('id'), text: $(this).val() }))
                } else {
                    $('.boxes').find('.mih' + $(this).data('id')).remove();
                }
            })


            $.gs_loader.hide();
        }).fail(function (data) {
            $.gs_loader.hide();
            alert(data.statusText);
        });
        return false;
    }

    $.fn.load_habis = function () {
        dlg = this;
        mdlg = $(dlg);

        mdlg.find('.addarea').click(function () {
            if(mdlg.find('#newarea').val()!=''>0&&confirm("¿Desea agregar una categoría?")){

                $.gs_loader.show();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: baseurl + "Habilidad/addarea/" + mdlg.find('#newarea').val(),
                }).done(function (data) {
                    mdlg.find(".areas").append('<a href="' + baseurl + 'Habilidad/habilidades/' + data.id + '" data-id="'+data.id+'" class="list-group-item area"><i class="' + data.icon + '"></i> ' + data.name + '</a>');
                    mdlg.find('.areas a:last').click(clickarea);
                    $.gs_loader.hide();
                }).fail(function (data) {
                    $.gs_loader.hide();
                    alert(data.statusText);
                });
                mdlg.find('#newarea').val('')
            }
        })


        mdlg.find('.addskill').click(function () {
            if(mdlg.find('#newskill').val()!=''>0&&confirm("¿Desea agregar una habilidad?")){

                $.gs_loader.show();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: baseurl + "Habilidad/addskill/"+mdlg.find('.areas .area.active').data('id')+"/" + mdlg.find('#newskill').val(),
                }).done(function (data) {
                    $.gs_loader.hide();
                    mdlg.find('.areas .area.active').click();
                }).fail(function (data) {
                    $.gs_loader.hide();
                    alert(data.statusText);
                });
                mdlg.find('#newskill').val('')
            }
        })

        objs = mdlg.find(".boxes").data('ids');
        objs.forEach(function (el) {
            mdlg.find('.boxes').append(box(el))
        });
        //console.log(mdlg.find('.buscar').next())
        mdlg.find('.buscar').keyup(function () {
            var searchText = $(this).val();
            //console.log(searchText)
            mdlg.find('.habilidades .col-md-6').each(function () {
                var currentLiText = $(this).find('label').text().toUpperCase(),
                    showCurrentLi = currentLiText.indexOf(searchText.toUpperCase()) !== -1;

                $(this).toggle(showCurrentLi);

            });
        });
        mdlg.find('.buscar').next().click(function () {
            mdlg.find('.buscar').val('');
            mdlg.find('.buscar').keyup();
        });

        mdlg.find(".areas .area").click(clickarea);
        mdlg.find(".areas .area:eq(0)").click();
    }

})(jQuery);