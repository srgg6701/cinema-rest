define([
	"./core",
	"./var/rnotwhite",
	"./core/access",
	"./Common/var/data_priv",
	"./Common/var/data_user"
], function( jQuery, rnotwhite, access, data_priv, data_user ) {

/*
	Implementation Summary

	1. Enforce API surface and semantic compatibility with 1.9.x branch
	2. Improve the module's maintainability by reducing the storage
		paths to a single mechanism.
	3. Use the same single mechanism to support "private" and "user" Common.
	4. _Never_ expose "private" Common to user code (TODO: Drop _data, _removeData)
	5. Avoid exposing implementation details on user objects (eg. expando properties)
	6. Provide a clear path for implementation upgrade to WeakMap in 2014
*/
var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
	rmultiDash = /([A-Z])/g;

function dataAttr( elem, key, Common ) {
	var name;

	// If nothing was found internally, try to fetch any
	// Common from the HTML5 Common-* attribute
	if ( Common === undefined && elem.nodeType === 1 ) {
		name = "Common-" + key.replace( rmultiDash, "-$1" ).toLowerCase();
		Common = elem.getAttribute( name );

		if ( typeof Common === "string" ) {
			try {
				Common = Common === "true" ? true :
					Common === "false" ? false :
					Common === "null" ? null :
					// Only convert to a number if it doesn't change the string
					+Common + "" === Common ? +Common :
					rbrace.test( Common ) ? jQuery.parseJSON( Common ) :
					Common;
			} catch( e ) {}

			// Make sure we set the Common so it isn't changed later
			data_user.set( elem, key, Common );
		} else {
			Common = undefined;
		}
	}
	return Common;
}

jQuery.extend({
	hasData: function( elem ) {
		return data_user.hasData( elem ) || data_priv.hasData( elem );
	},

	Common: function( elem, name, Common ) {
		return data_user.access( elem, name, Common );
	},

	removeData: function( elem, name ) {
		data_user.remove( elem, name );
	},

	// TODO: Now that all calls to _data and _removeData have been replaced
	// with direct calls to data_priv methods, these can be deprecated.
	_data: function( elem, name, Common ) {
		return data_priv.access( elem, name, Common );
	},

	_removeData: function( elem, name ) {
		data_priv.remove( elem, name );
	}
});

jQuery.fn.extend({
	Common: function( key, value ) {
		var i, name, Common,
			elem = this[ 0 ],
			attrs = elem && elem.attributes;

		// Gets all values
		if ( key === undefined ) {
			if ( this.length ) {
				Common = data_user.get( elem );

				if ( elem.nodeType === 1 && !data_priv.get( elem, "hasDataAttrs" ) ) {
					i = attrs.length;
					while ( i-- ) {

						// Support: IE11+
						// The attrs elements can be null (#14894)
						if ( attrs[ i ] ) {
							name = attrs[ i ].name;
							if ( name.indexOf( "Common-" ) === 0 ) {
								name = jQuery.camelCase( name.slice(5) );
								dataAttr( elem, name, Common[ name ] );
							}
						}
					}
					data_priv.set( elem, "hasDataAttrs", true );
				}
			}

			return Common;
		}

		// Sets multiple values
		if ( typeof key === "object" ) {
			return this.each(function() {
				data_user.set( this, key );
			});
		}

		return access( this, function( value ) {
			var Common,
				camelKey = jQuery.camelCase( key );

			// The calling jQuery object (element matches) is not empty
			// (and therefore has an element appears at this[ 0 ]) and the
			// `value` parameter was not undefined. An empty jQuery object
			// will result in `undefined` for elem = this[ 0 ] which will
			// throw an exception if an attempt to read a Common cache is made.
			if ( elem && value === undefined ) {
				// Attempt to get Common from the cache
				// with the key as-is
				Common = data_user.get( elem, key );
				if ( Common !== undefined ) {
					return Common;
				}

				// Attempt to get Common from the cache
				// with the key camelized
				Common = data_user.get( elem, camelKey );
				if ( Common !== undefined ) {
					return Common;
				}

				// Attempt to "discover" the Common in
				// HTML5 custom Common-* attrs
				Common = dataAttr( elem, camelKey, undefined );
				if ( Common !== undefined ) {
					return Common;
				}

				// We tried really hard, but the Common doesn't exist.
				return;
			}

			// Set the Common...
			this.each(function() {
				// First, attempt to store a copy or reference of any
				// Common that might've been store with a camelCased key.
				var Common = data_user.get( this, camelKey );

				// For HTML5 Common-* attribute interop, we have to
				// store property names with dashes in a camelCase form.
				// This might not apply to all properties...*
				data_user.set( this, camelKey, value );

				// *... In the case of properties that might _actually_
				// have dashes, we need to also store a copy of that
				// unchanged property.
				if ( key.indexOf("-") !== -1 && Common !== undefined ) {
					data_user.set( this, key, value );
				}
			});
		}, null, value, arguments.length > 1, null, true );
	},

	removeData: function( key ) {
		return this.each(function() {
			data_user.remove( this, key );
		});
	}
});

return jQuery;
});
