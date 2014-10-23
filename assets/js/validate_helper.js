/* ===================================================
* validate-helper.js
* A jquery plugin that Helps to validate the form with
* validate.js and bootstrap
* ===================================================
*/
; !function( $ ){
$.fn.extend({
validate: function( callback ) {

        // Checks if instance is already created
        if ( this.data("instance") ) {
          return;
        }

        var $this = this
        var temp=[]

        $this.find(".validate").each(function (i, el) {
          var $el = $(el)
          temp.push({name: $el.attr("name"),
                     rules: $el.attr("data-rules"),
                     display: $el.attr("data-display")
                   })
        })
        // Create FormValidator object
        var validator = new FormValidator($this.attr('name'), temp, function(errors, event) {
          // Clear all error fields
          $this.find(".has-error").removeClass("has-error")
          $this.find(".help-block").html("")
          // Check for errors
          if(errors.length > 0) {
              $.each(errors, function (index, err) {
                // Displays the erros message in the help-block
                var $target = $(".help-block-" + err.id).html(err.message)
                // Adds error class to the controlgroup (bootstrap)
				$target.prev('.form-group').removeClass("has-error").addClass("has-error")
                //$target.closest(".control-group").removeClass("error").addClass("error")
              })
             return false
          } else {
            if (typeof callback === "function") {
              callback ($this, event ) //execute callback on form success
            }
          }
        });
        this.data("instance", validator)
      }

      })

} ( window.jQuery )