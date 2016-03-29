weastyApp.controller('currencyRate', ['$scope', '$element', function ($scope, $element) {

    $scope.currencyRate = $element.data('currencyRate');
    $scope.currencyRate.officialOffsetType = $scope.currencyRate.officialOffsetType.toString();

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

            switch (parseInt($scope.currencyRate.officialOffsetType)){
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

}]);