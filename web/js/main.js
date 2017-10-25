// Boostrap tablesorter.
require('tablesorter')

// Get a jQuery instance (actually comes from browser globals because of `externals` key in the
// webpack config)
var jQuery = require('jquery')

// Now do the magic.
jQuery('#myTable').tablesorter()
