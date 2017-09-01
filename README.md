# map

This Package allows you to access Googles Geocoding and DistanceMatrix Service with an Eloquent model.

You should set the 'latitude' and 'longitude' and zip/city Attribute as a fillable: 

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zoomyboy\Map\HasMap;

class M extends Model
{
	use HasMap;

  protected $fillable = ['latitude', 'longitude', 'address', 'zip', 'city'];
}
```

By default, the Attribute 'addressForCoords' is used to set the coords for the model. This is a string combination of the stored Address, Zip-Code and City.
You can overwrite this behaviour by setting the 'getAddressForCoords' attribute.

You can leave of the 'address' attribute (set it to null or dont create a column at all), because the package will just fetch the position of the city and zip-Code.

### Facade

The Map Facade can be used to manually grab the functions of the package:

```
use Zoomyboy\Map\Facades\Map;
```
 
**Grab Coords**  
You can grab Cordinates with the 'coords' method. The Method acepts 3 Params: address, zip and city, where zip and city are optional.  
You can also leave off the zip and city and put the full address string as the first param. Or you can set all 3 options - that way a proper google string is created out of this information.
The method will return an array with the keys 'latitude' and 'longitude' - or false if the location wasn't found.

```
Map::coords('Address', 'Zip', 'City');
```

**Grab Distances**
You can get the distance in Meters between 2 Locations.  
```
Map::distance('Address 1, 12345 City 2', 'Address 2, 67890 City 2');
```

