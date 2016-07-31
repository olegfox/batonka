angular.
    module("registration", []).config(function($interpolateProvider){
        $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
    })
    .controller("RegistrationController", function ($scope, $http) {

        $scope.submit = function() {

            var $form = jQuery('form');

            var load = $.modal("", {overlayClose: true});

            var windowParams = {overlayClose: true, onClose: function() {
                window.location.reload();
            }};

            $http({
                method: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function() {
                load.close();
                $.modal("Спасибо за регистрацию! Вы получите подтверждение регистрации на указанный электронный адрес.", windowParams);
                $form.get(0).reset();
            }, function(){
                load.close();
                $.modal("Ошибка отправки! Попробуйте еще раз.", windowParams); 
            });

            return false;

        };
    });

