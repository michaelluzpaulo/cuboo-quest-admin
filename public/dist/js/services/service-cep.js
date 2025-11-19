var ServiceCep = (function () {

    /**
     *
     * @param cep
     * @param elementPai
     */
    function __get(cep, elementPai) {
        var bufferCep = cep.replace(/\D/g, '');

        if (bufferCep.length == 8) {
            $.getJSON('/api/cep/' + cep, function (data, textStatus, jqXHR) {


                $(elementPai + " #endereco").val(data.items.logradouro);
                $(elementPai + " #bairro").val(data.items.bairro);
                $(elementPai + " #estado_id").val(data.items.estado_id);
                $("#estado_id", elementPai).select2();

                __setCidade(data.items.estado_id,elementPai,data.items.cidade_id);

                $(elementPai + " #tipo_logradouro_id").val(data.items.tipo_logradouro_id);
                $("#tipo_logradouro_id", elementPai).select2();


            }).done(function (data) {
                $.unloadmask();
            }).fail(function (jqxhr, textStatus, error) {
                $.unloadmask();
                Msg.error(jqxhr.responseText);

            }).always(function (data, textStatus, errorThrown) {
                //console.log("complete");
            });
        }
    }

    /**
     *
     * @param estado_id
     * @param elementPai
     * @param cidade
     * @private
     */
    function __setCidade(estado_id,elementPai,cidade) {
        if (estado_id > 0) {
            $("#cidade_id", elementPai).select2('destroy');
            $("#cidade_id", elementPai).html('<option value="0">SELECIONE...</option>');
            $.loadmask();
            $.getJSON('/api/cidades/' + estado_id, function (data, textStatus, jqXHR) {
                $.unloadmask();
                if (data.success) {
                    $.each(data.items, function (i, item) {
                        $("#cidade_id", elementPai).append('<option value="' + item.id + '">' + item.nome + '</option>');
                    });


                    $(elementPai + " #cidade_id").val(cidade);
                    $("#cidade_id", elementPai).select2();
                }
                else {
                    Msg.setResponse(data);
                }

            }).done(function (data) {
                $.unloadmask();
            }).fail(function (jqxhr, textStatus, error) {
                $.unloadmask();
                Msg.error(jqxhr.responseText);

            }).always(function (data, textStatus, errorThrown) {
                //console.log("complete");
            });
        }

    }


    return {
        get: __get,
        setCidade: __setCidade,
    };
})();