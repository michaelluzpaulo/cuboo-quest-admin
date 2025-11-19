const ServiceHttp = (function () {
   function __exceptionAjax(jqXHR, textStatus, errorThrown) {
      var obj = jqXHR.responseText;

      if (Validator.IsJsonString(obj)) {
         obj = JSON.parse(jqXHR.responseText);
      }

      $.unloadmask();
      __exception(jqXHR.status, obj.message);
   }

   function __exceptionLoad(responseText, textStatus, XMLHttpRequest) {
      $.unloadmask();
      __exception(XMLHttpRequest.status, responseText);
   }

   /**
    *
    * @param {int} statusCode
    * @param {string} message
    */
   function __exception(statusCode, message) {
      console.log("Error --> ", `${statusCode} - ${message}`);
      switch (statusCode) {
         case 400:
            {
               Notify.error(message, () => ServiceHttp.clearLoading());
            }
            break;
         case 401:
            {
               Notify.error("Acesso negado! (401)", () =>
                  ServiceHttp.clearLoading()
               );
            }
            break;
         case 403:
            {
               Notify.error(
                  "A solicitação não foi liberada para esta requisição! (403)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 404:
            {
               Notify.error(
                  "A solicitação não esta disponível no servidor! (404)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 405:
            {
               Notify.error(
                  "A solicitação foi feita através de um método não permitido pelo servidor!  (405)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 408:
            {
               Notify.timeout(
                  "O servidor excedeu o tempo limite de espera! (408)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 414:
            {
               Notify.error(
                  "O endereço fornecido (URL) é muito longo para que o servidor possa processar! (414)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 419:
            {
               Notify.timeout(
                  "O servidor excedeu o tempo limite de espera! (419)",
                  () => ServiceHttp.clearLoading()
               );
            }
            break;
         case 500:
            {
               Notify.error("Erro do servidor! (500)", () =>
                  ServiceHttp.clearLoading()
               );
            }
            break;
         default:
            {
               Notify.error(`Erro de processamento não identificado!`, () =>
                  ServiceHttp.clearLoading()
               );
            }
            break;
      }
   }

   function __clearLoading() {
      $.unloadmask();
   }

   return {
      exceptionAjax: __exceptionAjax,
      exceptionLoad: __exceptionLoad,
      exception: __exception,
      clearLoading: __clearLoading,
   };
})();
