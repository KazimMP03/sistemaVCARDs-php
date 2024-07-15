// Pede chave de criação de conta se não for Visitante
function toggleCodigoField() {
    var tipoUsuario = document.getElementById('tipo').value;
    var codigoField = document.getElementById('codigoField');
    var codigoInput = document.getElementById('codigo');

    if (tipoUsuario === 'Visitante') {
        codigoInput.removeAttribute('required');
        codigoField.style.display = 'none';
        codigoInput.classList.add('ignore-validation');
    } else {
        codigoInput.setAttribute('required', 'required');
        codigoField.style.display = 'block';
        codigoInput.classList.remove('ignore-validation');
    }
}
window.onload = toggleCodigoField;

// Estilização dos campos de preenchimento do Cadastro
(function ($) {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        window.history.replaceState({}, document.title, "cadastro.php");
    });

    $('.input100').each(function () {
        $(this).on('blur', function () {
            if ($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })
    })

    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function (event) {
        var check = true;

        for (var i = 0; i < input.length; i++) {

            if ($(input[i]).hasClass('ignore-validation')) {
                continue;
            }

            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }

        if (!check) {
            event.preventDefault();
        }

        return check;
    });

    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    // Validação dos campos de Cadastro
    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if ($(input).val().trim() == '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    // Botão de visualização de senha
    var showPass = 0;
    $('.btn-show-pass').on('click', function () {
        if (showPass == 0) {
            $(this).next('input').attr('type', 'text');
            $(this).find('i').removeClass('zmdi-eye-off');
            $(this).find('i').addClass('zmdi-eye');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type', 'password');
            $(this).find('i').addClass('zmdi-eye-off');
            $(this).find('i').removeClass('zmdi-eye');
            showPass = 0;
        }
    });

})(jQuery);