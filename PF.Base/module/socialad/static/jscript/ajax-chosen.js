// Generated by CoffeeScript 1.4.0

(function($) {
  return $.fn.ajaxChosen = function(settings, callback, chosenOptions) {
    var chosenXhr, defaultOptions, options, select;
    if (settings == null) {
      settings = {};
    }
    if (chosenOptions == null) {
      chosenOptions = {};
    }
    defaultOptions = {
      minTermLength: 1,
      afterTypeDelay: 500,
      jsonTermKey: "term",
      keepTypingMsg: "Keep typing...",
      lookingForMsg: "Looking for"
    };
    select = this;
    chosenXhr = null;
    optionsFirst = $.extend({}, defaultOptions, $(select).data(), settings);
    options = $.extend({}, defaultOptions, $(select).data(), settings);
    this.chosen(chosenOptions ? chosenOptions : {});
    return this.each(function() {
      return $(this).next('.chosen-container').find(".search-field > input, .chosen-search > input").bind('keyup', function() {
        var field, msg, success, untrimmed_val, val;
        untrimmed_val = $(this).val();
        val = $.trim($(this).val());
        msg = val.length < options.minTermLength ? options.keepTypingMsg : options.lookingForMsg + (" '" + val + "'");
        select.next('.chosen-container').find('.no-results').text(msg);
        if (val === $(this).data('prevVal')) {
          return false;
        }
        $(this).data('prevVal', val);
        if (this.timer) {
          clearTimeout(this.timer);
        }
        if (val.length < options.minTermLength) {
          return false;
        }
        field = $(this);
        if (options.data == null) {
          options.data = {};
        }
        // options.data[options.jsonTermKey] = val;
        if(val.length == 0){
          options.data = optionsFirst.data + '&name=' + 'yn_search_all';
        } else {
          options.data = optionsFirst.data + '&name=' + val;
        }
        if (options.dataCallback != null) {
          options.data = options.dataCallback(options.data);
        }
        success = options.success;
        options.success = function(data) {
          var items, nbItems, selected_values;
          if (data == null) {
            return;
          }
          selected_values = [];
          select.find('option').each(function() {
            // if (!$(this).is(":selected")) {
              return $(this).remove();
            // } else {
              // return selected_values.push($(this).val() + "-" + $(this).text());
            // }
          });
          select.find('optgroup:empty').each(function() {
            return $(this).remove();
          });
          items = callback != null ? callback(data, field) : data;
          nbItems = 0;
          $.each(items, function(i, element) {
            var group, text, value;
            var data_item_type_id, data_title, data_description, data_is_have_image;
            nbItems++;
            if (element.group) {
              group = select.find("optgroup[label='" + element.text + "']");
              if (!group.size()) {
                group = $("<optgroup />");
              }
              group.attr('label', element.text).appendTo(select);
              return $.each(element.items, function(i, element) {
                var text, value;
                if (typeof element === "string") {
                  value = i;
                  text = element;
                } else {
                  value = element.value;
                  text = element.text;
                }
                if ($.inArray(value + "-" + text, selected_values) === -1) {
                  return $("<option />").attr('value', value).html(text).appendTo(group);
                }
              });
            } else {
              if (typeof element === "string") {
                value = i;
                text = element;
              } else {
                value = element.value;
                text = element.text;
                data_item_type_id = element.data_item_type_id;
                data_title = element.data_title;
                data_description = element.data_description;
                data_is_have_image = element.data_is_have_image;
              }
              if ($.inArray(value + "-" + text, selected_values) === -1) {
                 var result = $("<option />");
                          result.attr('value', value);
                          result.attr('data-item-type-id', data_item_type_id);
                          result.attr('data-title', data_title);
                          result.attr('data-description', data_description);
                          result.attr('data-is-have-image', data_is_have_image);
                          result.html(text);
                          return result.appendTo(select);
              }
            }
          });
          if (nbItems) {
            select.trigger("chosen:updated");

            var $adItem =  $('#js_ynsa_ad_item');
            $adItem.on('change', this.onChangeItem);
            $adItem.trigger('change');            
          } else {
            select.data().chosen.no_results_clear();
            select.data().chosen.no_results(field.val());
          }
          if (settings.success != null) {
            settings.success(data);
          }
          return field.val(untrimmed_val);
        };
        return this.timer = setTimeout(function() {
          if (chosenXhr) {
            chosenXhr.abort();
          }
          return chosenXhr = $.ajax(options);
        }, options.afterTypeDelay);
      });
    });
  };
})(jQuery);
