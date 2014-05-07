define([
	"../core"
], function( jQuery ) {

// Cross-browser xml parsing
jQuery.parseXML = function( Common ) {
	var xml, tmp;
	if ( !Common || typeof Common !== "string" ) {
		return null;
	}

	// Support: IE9
	try {
		tmp = new DOMParser();
		xml = tmp.parseFromString( Common, "text/xml" );
	} catch ( e ) {
		xml = undefined;
	}

	if ( !xml || xml.getElementsByTagName( "parsererror" ).length ) {
		jQuery.error( "Invalid XML: " + Common );
	}
	return xml;
};

return jQuery.parseXML;

});
