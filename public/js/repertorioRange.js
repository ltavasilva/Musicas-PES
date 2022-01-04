// Code goes here
(() => {
    angular
    .module('dateRangeDemo', ['ui.bootstrap', 'rzModule'])
    .controller('dateRangeCtrl', function dateRangeCtrl($scope) {
      var vm = this;
  
      // Single Date Slider    
      var dates = [];
      for (var i = 1; i <= 31; i++) {
        dates.push(new Date(2016, 7, i));
      }
      $scope.slider_dates = {
        value: new Date(2016, 7, 15),
        options: {
          stepsArray: dates,
          translate: function(date) {
            if (date !== null)
              return date.toDateString();
            return '';
          }
        }
      };
      
      // Date Range Slider
      //var floorDate = new Date(2015, 0, 1).getTime();
      //var ceilDate = new Date(2015, 0, 31).getTime();
      //var minDate = new Date(2015, 0, 15).getTime();
      //var maxDate = new Date(2015, 0, 20).getTime();

      var date = new Date();
      date.setDate(date.getDate()-45);
      var floorDate = new Date(date.getFullYear(), date.getMonth(), 1).getTime();
      //var floorDate = new Date(2021, 6, 01).getTime();

      date = new Date();
      date.setDate(date.getDate()+15);
      var ceilDate = new Date(date.getFullYear(), date.getMonth() + 1, 0).getTime();

      var minDate = new Date().getTime();
      var maxDate = date.getTime();
      var millisInDay = 24*60*60*1000;
        
  
      var monthNames =
      [
        "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"
      ];
      /*var monthNames =
      [
        "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"
      ];*/
  
      var formatDate = function (date_millis)
      {
        var date = new Date(date_millis);
        return date.getDate()+"-"+monthNames[date.getMonth()]+"-"+date.getFullYear();
      }

      var formatDateCompare = function (date_millis)
      {
        var date = new Date(date_millis);
        return date.getFullYear()+"-"+monthNames[date.getMonth()]+"-"+date.getDate();
      }
  
  
      //Range slider config 
      $scope.dateRangeSlider = {
        minValue: minDate,
        maxValue: maxDate,
        options: {
          floor: floorDate,
          ceil: ceilDate,
          step: millisInDay,
          showTicks: false,
          draggableRange: true,
          onChange:function(nulo, minValue, maxValue, pointerType){

          },
          onEnd:function(nulo, minValue, maxValue, pointerType){
            $("#filterIni").val(formatDateCompare(minValue));
		        $("#filterFim").val(formatDateCompare(maxValue));
            filter();
          },
          translate: function(date_millis) {
            if ((date_millis !== null)) {
              var dateFromMillis = new Date(date_millis);
              //console.log("date_millis="+date_millis);
              // return dateFromMillis.toDateString();
              return formatDate(dateFromMillis);
            }
            return '';
          }
        }
      };
      
    });
  })();
  