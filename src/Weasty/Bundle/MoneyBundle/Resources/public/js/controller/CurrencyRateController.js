weastyApp.controller('currencyRate', ['$scope', '$element', function ($scope, $element) {

    $scope.currencyRate = $element.data('currencyRate');
    $scope.currencyRate.officialOffsetType = $scope.currencyRate.officialOffsetType.toString();

    $scope.officialCurrencyRates = $element.data('officialCurrencyRates');

    var formId = $element.attr('id');
    var formGroupSelector = '.form-group';

    var $rate = $('#' + formId + '_rate', $element);
    var $officialOffsetType = $('#' + formId + '_officialOffsetType', $element);
    var $officialOffsetPercent = $('#' + formId + '_officialOffsetPercent', $element);
    var $officialOffsetValue = $('#' + formId + '_officialOffsetValue', $element);

    var showHideFields = function () {

        if ($scope.currencyRate.updatableFromOfficial) {

            $rate.closest(formGroupSelector).hide();
            $officialOffsetType.closest(formGroupSelector).show();

            switch (parseInt($scope.currencyRate.officialOffsetType)) {
                case 1:
                    $officialOffsetPercent.closest(formGroupSelector).show();
                    $officialOffsetValue.closest(formGroupSelector).hide();
                    break;
                case 2:
                    $officialOffsetPercent.closest(formGroupSelector).hide();
                    $officialOffsetValue.closest(formGroupSelector).show();
                    break;
            }

        } else {

            $rate.closest(formGroupSelector).show();

            $officialOffsetType.closest(formGroupSelector).hide();
            $officialOffsetPercent.closest(formGroupSelector).hide();
            $officialOffsetValue.closest(formGroupSelector).hide();

        }

    };

    $scope.$watch('currencyRate', showHideFields, true);

    $scope.officialCurrencyRate = function (sourceAlphabeticCode, destinationAlphabeticCode) {
        var results = $.grep($scope.officialCurrencyRates, function (officialCurrencyRate) {
            return (
                officialCurrencyRate.sourceAlphabeticCode == sourceAlphabeticCode
                && officialCurrencyRate.destinationAlphabeticCode == destinationAlphabeticCode
            );
        });
        return ( results.length > 0 ? results.shift() : null );
    };

    $scope.finalCurrencyRateValue = function () {

        if ($scope.currencyRate.updatableFromOfficial) {

            var officialCurrencyRate = $scope.officialCurrencyRate($scope.currencyRate.sourceAlphabeticCode, $scope.currencyRate.destinationAlphabeticCode);
            if (officialCurrencyRate) {

                switch (parseInt($scope.currencyRate.officialOffsetType)) {
                    case 1:
                        if($scope.currencyRate.officialOffsetPercent){
                            return parseFloat(officialCurrencyRate.rate) * ( ( 100 + parseFloat($scope.currencyRate.officialOffsetPercent) ) / 100 );
                        } else {
                            return officialCurrencyRate.rate;
                        }
                    case 2:
                        if($scope.currencyRate.officialOffsetValue){
                            return parseFloat(officialCurrencyRate.rate) + parseFloat($scope.currencyRate.officialOffsetValue);
                        } else {
                            return officialCurrencyRate.rate;
                        }
                }

            } else {
                return null;
            }

        } else {
            return $scope.currencyRate.rate;
        }

    };

}]);