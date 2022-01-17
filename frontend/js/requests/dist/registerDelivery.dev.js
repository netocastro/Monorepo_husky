"use strict";

$(document).ready(function () {
  // Requisição que busca todos os Motoboys.
  $.ajax({
    url: 'http://localhost/monorepo_husky/backend/motoboy/',
    type: 'GET',
    dataType: "JSON",
    success: function success(data) {
      motoboys(data);
    },
    error: function error(_error) {
      console.log(_error.responseText);
    }
  }); //Requisição que buscar todos os usuários.

  $.ajax({
    url: 'http://localhost/monorepo_husky/backend/user/',
    type: 'GET',
    dataType: "JSON",
    success: function success(data) {
      users(data);
    },
    error: function error(_error2) {
      console.log(_error2.responseText);
    }
  }); // Requisição que de fato faz o registro das Entregas

  $('#register-delivery').on('submit', function (e) {
    e.preventDefault();
    _this = $(this);
    $.ajax({
      url: _this.attr('action'),
      type: _this.attr('method'),
      dataType: _this.attr('data-type'),
      data: _this.serialize(),
      success: function success(data) {
        validateFields(data, _this);
      },
      error: function error(_error3) {
        console.log(_error3.responseText);
      }
    });
  }); //Requisição usada para buscar o endereço dos clientes.

  $('#users').on('change', function (e) {
    $.ajax({
      url: 'http://localhost/monorepo_husky/backend/user/' + $('#users').val(),
      type: 'GET',
      dataType: "JSON",
      success: function success(data) {
        $('#destination_address').val(data[0].address);
      },
      error: function error(_error4) {
        console.log(_error4.responseText);
      }
    });
  }); // Função que preenche o select com todos os motoboys do banco de dados

  function motoboys(data) {
    $("#motoboys").html('');
    $("#motoboys").append("<option value=\"0\">--</option>");
    data.forEach(function (element) {
      $("#motoboys").append("\n                <option value=\"".concat(element.id, "\">").concat(element.name, "</option>\n            ")).fadeIn();
    });
  } // Função que preenche o select com todos os usuarios do banco de dados


  function users(data) {
    $("#users").html('');
    $("#users").append("<option value=\"0\">--</option>");
    data.forEach(function (element) {
      $("#users").append("\n                <option value=\"".concat(element.id, "\">").concat(element.name, "</option>\n            ")).fadeIn();
    });
  }
});