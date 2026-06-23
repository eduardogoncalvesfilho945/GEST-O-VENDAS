document.addEventListener("DOMContentLoaded", function () {
    var formularios = document.querySelectorAll("form");

    formularios.forEach(function (formulario) {
        formulario.addEventListener("submit", function (evento) {
            var obrigatorios = formulario.querySelectorAll("[required]");

            for (var campo of obrigatorios) {
                if (campo.value.trim() === "") {
                    evento.preventDefault();
                    alert("Preencha todos os campos obrigatorios.");
                    campo.focus();
                    return;
                }
            }

            var cpf = formulario.querySelector("[name='cpf']");

            if (cpf && !/^[0-9]{11}$/.test(cpf.value)) {
                evento.preventDefault();
                alert("O CPF deve possuir exatamente 11 numeros.");
                cpf.focus();
                return;
            }

            var telefone = formulario.querySelector("[name='telefone']");

            if (telefone) {
                var numeros = telefone.value.replace(/\D/g, "");

                if (numeros.length < 10 || numeros.length > 11) {
                    evento.preventDefault();
                    alert("Informe um telefone valido com DDD.");
                    telefone.focus();
                    return;
                }
            }

            var quantidade = formulario.querySelector("[name='quantidade']");
            var estoqueMinimo = formulario.querySelector("[name='estoque_minimo']");
            var preco = formulario.querySelector("[name='preco']");

            if (quantidade && Number(quantidade.value) < 0) {
                evento.preventDefault();
                alert("A quantidade nao pode ser negativa.");
                quantidade.focus();
                return;
            }

            if (estoqueMinimo && Number(estoqueMinimo.value) < 0) {
                evento.preventDefault();
                alert("O estoque minimo nao pode ser negativo.");
                estoqueMinimo.focus();
                return;
            }

            if (preco && Number(preco.value) <= 0) {
                evento.preventDefault();
                alert("O preco deve ser maior que zero.");
                preco.focus();
            }
        });
    });
});