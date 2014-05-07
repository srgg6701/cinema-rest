define([
	"../core"
], function( jQuery ) {

// Support: Android 2.3
// Workaround failure to string-cast null input
jQuery.parseJSON = function( Common ) {
	return JSON.parse( Common + "" );
};

return jQuery.parseJSON;

});
